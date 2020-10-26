<?php

namespace Api\AuthController;

use User\User;

class AuthController {
    public static function auth() {
        request_method('POST');

        // Validate input
        if(!isset($_POST['email']) || empty($_POST['email'])) {
            return response(false, null, 'Email is required');
        }

        // Data
        $email = sanitize_input($_POST['email']);

        $senderEmail = 'info@' . env('APP_DOMAIN');
        $senderName = 'Info - ' . env('APP_NAME');

        // Check if user is present or not
        $query = mysqli_query(db(), "SELECT * FROM users WHERE email = '$email'");
        if(mysqli_num_rows($query) > 0) {
            // User data
            $user = mysqli_fetch_object($query);

            // Check if account is deleted or not
            if($user->is_deleted) {
                return response(false, null, "Your account has been deleted. Please contact to our support team.");
            }

            // Check if account is facebook or gmail account
            if($user->is_facebook || $user->is_google) {
                $accountType = $user->is_facebook ? 'Facebook' : 'Google';
                return response(false, null, "This is a $accountType linked account. Please login using $accountType.");
            }

            // Mail password
            $updatedAccount = self::loginWithEmail($email, false);
            if(!$updatedAccount) {
                return response(false, null, 'Password can not be generated. Please try again later.');
            }

            // Mail body
            ob_start();
            view('emails/login-otp', [
                'password' => $updatedAccount['password'],
                'is_new_account' => $user->name == null ? true : false,
            ]);
            $message = ob_get_clean();

            if(!mailer($email, 'Password initialized', $message, $senderEmail, $senderName)) {
                return response(false, null, 'Your OTP could not be sent. Please try again.');
            }

            return response(true,  ['is_new_account' => false], 'OTP has been sent to the registered mail address.');
        } else {

            // Create entry and mail password
            $createdAccount = self::loginWithEmail($email);
            if(!$createdAccount) {
                return response(false, null, 'Sorry, your account could not be created.');
            }

            // Mail body
            ob_start();
            view('emails/login-otp', [
                'password' => $createdAccount['password'],
                'is_new_account' => true,
            ]);
            $message = ob_get_clean();

            if(!mailer($email, 'Password initialized', $message, $senderEmail, $senderName)) {
                return response(false, null, 'Your OTP could not be sent. Please try to login again.');
            }

            return response(true, ['is_new_account' => true], 'OTP has been sent to the registered mail address.');
        }
    }

    public static function loginWithEmail($email = null, $isNewUser = true, $isFacebookAccount = false, $isGoogleAccount = false) {
        if(empty($email)) {
            throw new \Error('Email is required');
        }

        // Create random password
        $characters = '~!+^%$@0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $password = '';
        for ($i = 0; $i < 10; $i++) {
            $password .= $characters[rand(0, $charactersLength - 1)];
        }
        $password_ecrypted = password_hash($password, PASSWORD_BCRYPT);

        if($isNewUser) {
            // Create date
            $createdAt = strtotime('now');

            $createAccountQuery = "INSERT INTO users (email, password, created_at) VALUES ('$email', '$password_ecrypted', '$createdAt')";
            if (mysqli_query(db(), $createAccountQuery)) {
                return [
                    'password' => $password
                ];
            } else {
                return false;
            }
        } else {
            $updateAccountQuery = "UPDATE users SET password = '$password_ecrypted' WHERE email = '$email'";
            if (mysqli_query(db(), $updateAccountQuery)) {
                return [
                    'password' => $password
                ];
            } else {
                return false;
            }
        }
    }

    public static function loginPasswordVerify() {
        // Validate input
        if(!isset($_POST['email']) || empty($_POST['email'])) {
            return response(false, null, 'Invalid login. Please login again');
        }
        if(!isset($_POST['password']) || empty($_POST['password'])) {
            return response(false, null, 'Password is required');
        }

        // Data
        $name = isset($_POST['name']) ? sanitize_input($_POST['name']) : null;
        $email = sanitize_input($_POST['email']);
        $password = sanitize_input($_POST['password']);

        // Update name
        if($name != null) {
            mysqli_query(db(), "UPDATE users SET name = '$name' WHERE email = '$email'");
        }

        // Check if user is okay
        $checkUser = mysqli_query(db(), "SELECT * FROM users WHERE email = '$email'");
        if(mysqli_num_rows($checkUser) <= 0) {
            return response(false, null, 'Invalid login. Please login again');
        }

        $user = mysqli_fetch_object($checkUser);

        // Check password
        if(!password_verify($password, $user->password)) {
            return response(false, null, 'Invalid password');
        }

        $hideFields = ['password'];
        user($user, $hideFields);
        return response(true, user(), 'Login success');
    }

    public static function loginWithFacebook() {
        request_method('POST');

        // Validate input
        if(!isset($_POST['email']) || empty($_POST['email'])) {
            return response(false, null, 'Invalid login. Please login again 1');
        }
        if(!isset($_POST['name']) || empty($_POST['name'])) {
            return response(false, null, 'Invalid login. Please login again 2');
        }
        if(!isset($_POST['avatar']) || empty($_POST['avatar'])) {
            return response(false, null, 'Invalid login. Please login again 3');
        }

        $data = (object)[
            'email' => sanitize_input($_POST['email']),
            'name' => sanitize_input($_POST['name']),
            'avatar' => sanitize_input($_POST['avatar']),
            'created_at' => strtotime('now')
        ];

        // Check user
        $user = User::getUserByEmail($data->email);

        // Verify if it's a google account
        if($user && !$user->is_facebook) {
            return response(false, null, 'This is not a facebook authenticated account. Please login using the correct method.');
        }

        // Create entry if not found
        if(!$user) {
            $conn = db();
            $query = mysqli_query($conn, "INSERT INTO users (name, email, avatar, is_facebook, created_at) VALUES ('$data->name', '$data->email', '$data->avatar', true, '$data->created_at')");

            if ($query) {
                $userId = mysqli_insert_id($conn);
                $user = User::getUserById($userId);

                // Set user session
                user($user);

                // Send welcome mail
                ob_start();
                view('emails/welcome');
                $message = ob_get_clean();

                $subject = 'Welcome to ' . env('APP_NAME');
                $senderName = 'Info - ' . env('APP_NAME');
                $senderEmail = 'info@' . env('APP_DOMAIN');

                mailer($user->email, $subject, $message, $senderEmail, $senderName);

                return response(true, user(), 'Login success');
            } else {
                return response(false, null, 'Sorry, your account could not be created.');
            }
        } else {

            // Update name and avatar if not same
            if($user->name != $data->name || $user->avatar != $data->avatar) {
                mysqli_query(db(), "UPDATE users SET name = '$data->name', avatar = '$data->avatar' WHERE id = '$user->id'");
            }

            // Set user session
            user($user);

            return response(true, user(), 'Login success');
        }

        // Set session if user found in database
        user($user);

        return response(true, user(), 'Login success');
    }

    public static function loginWithGoogle() {
        request_method('POST');

        // Validate input
        if(!isset($_POST['email']) || empty($_POST['email'])) {
            return response(false, null, 'Invalid login. Please login again');
        }
        if(!isset($_POST['name']) || empty($_POST['name'])) {
            return response(false, null, 'Invalid login. Please login again');
        }
        if(!isset($_POST['avatar']) || empty($_POST['avatar'])) {
            return response(false, null, 'Invalid login. Please login again');
        }

        $data = (object)[
            'email' => sanitize_input($_POST['email']),
            'name' => sanitize_input($_POST['name']),
            'avatar' => sanitize_input($_POST['avatar']),
            'created_at' => strtotime('now')
        ];

        // Check user
        $user = User::getUserByEmail($data->email);

        // Verify if it's a google account
        if($user && !$user->is_google) {
            return response(false, null, 'This is not a google authenticated account. Please login using the correct method.');
        }

        // Create entry if not found
        if(!$user) {
            $conn = db();
            $query = mysqli_query($conn, "INSERT INTO users (name, email, avatar, is_google, created_at) VALUES ('$data->name', '$data->email', '$data->avatar', true, '$data->created_at')");

            if ($query) {
                $userId = mysqli_insert_id($conn);
                $user = User::getUserById($userId);

                // Set user session
                user($user);

                // Send welcome mail
                ob_start();
                view('emails/welcome');
                $message = ob_get_clean();

                $subject = 'Welcome to ' . env('APP_NAME');
                $senderName = 'Info - ' . env('APP_NAME');
                $senderEmail = 'info@' . env('APP_DOMAIN');

                mailer($user->email, $subject, $message, $senderEmail, $senderName);

                return response(true, user(), 'Login success');
            } else {
                return response(false, null, 'Sorry, your account could not be created.');
            }
        } else {

            // Update name and avatar if not same
            if($user->name != $data->name || $user->avatar != $data->avatar) {
                mysqli_query(db(), "UPDATE users SET name = '$data->name', avatar = '$data->avatar' WHERE id = '$user->id'");
            }

            // Set user session
            user($user);

            return response(true, user(), 'Login success');
        }

        // Set session if user found in database
        user($user);

        return response(true, user(), 'Login success');
    }
}