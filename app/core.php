<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(!function_exists('env')) {
    function env($name = '') {
        return $name == null && !isset($_ENV[$name]) ? null : $_ENV[$name];
    }
}

if(!function_exists('request_method')) {
    function request_method($method = 'GET') {
        if($_SERVER['REQUEST_METHOD'] != $method) {
            http_response_code(400);
            throw new Error('Invalid http method');
            return false;
        }

        return true;
    }
}

if(!function_exists('assets')) {
    function assets($file_name = '') {
        return env('APP_URL') . 'assets/' . $file_name;
    }
}

if(!function_exists('view')) {
    function view($view_file = null, $data = null, $page_name = null) {
        if(!file_exists('./views/' . $view_file . '.flake.php')) {
            throw new Error('View file not found');
        }

        return require_once './views/' . $view_file . '.flake.php';
    }
}

if(!function_exists('redirect')) {
    function redirect($route = '') {
        return header("Location: $route");
    }
}

if(!function_exists('url')) {
    function url($route = '') {
        if(strpos($route, '/') == 0) {
            $route = substr($route, 1);
        }
        return env('APP_URL') . $route;
    }
}

if(!function_exists('api')) {
    function api($route = '') {
        if(strpos($route, '/') == 0) {
            $route = substr($route, 1);
        }
        return url('/api/' . $route);
    }
}

if(!function_exists('collect')) {
    function collect($data) {
        $response = null;
        if(is_array($data)) {
            if (count($data)) {
                foreach ($data as $key => $item) {
                    $response[$key] = (object)$item;
                }
            }
            return $response;
        } else {
            return $data;
        }
    }
}

if(!function_exists('response')) {
    function response($success = false, $data = null, $message = null) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'data' => empty($data) && $data == null ? null : $data,
            'message' => $message
        ]);
    }
}

if(!function_exists('sanitize_input')) {
    function sanitize_input($input) {
        return mysqli_real_escape_string(db(), trim($input));
    }
}

if(!function_exists('user')) {
    function user($user = null, $hide_fields = null) {
        if($user != null) {
            if(isset($hide_fields) && count($hide_fields)) {
                foreach ($hide_fields as $field) {
                    unset($user[$field]);
                }
            }

            $user['id'] = intval($user['id']);
            $user['is_facebook'] = boolval($user['is_facebook']);
            $user['is_google'] = boolval($user['is_google']);
            $user['is_admin'] = boolval($user['is_admin']);
            $user['created_at'] = intval($user['created_at']);
            $user['is_deleted'] = boolval($user['is_deleted']);

            $_SESSION['user'] = (object)$user;
        }

        if(session_status() == PHP_SESSION_NONE) {
            return false;
        }
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            return false;
        }

        return $_SESSION['user'];
    }
}

if(!function_exists('reset_user')) {
    function reset_user() {
        unset($_SESSION['user']);
    }
}

if(!function_exists('is_admin')) {
    function is_admin() {
        if(!user()) {
            return false;
        }

        return user()->is_admin ? true : false;
    }
}

if(!function_exists('lang')) {
    function lang() {
        if(user() && isset(user()->locale)) {
            return user()->locale;
        } else if(isset($_COOKIE['locale'])) {
            return $_COOKIE['locale'];
        } else {
            return env('APP_LOCALE');
        }
    }
}

if(!function_exists('trans')) {
    function trans($data) {
        $data = explode('.', $data);
        $val = [];

        // Get file
        $array = include 'lang/' . lang() . '/' . $data[0] . '.lang.php';

        // Get the variable inside the file
        $variable = $data[count($data) - 1];

        array_walk_recursive($array, function($v, $k) use($variable, &$val){
            if($k == $variable) array_push($val, $v);
        });

        return count($val) > 1 ? $val : array_pop($val);
    }
}

if(!function_exists('load_layout')) {
    function load_layout($file_name, $data = null, $page_name = '') {
        require_once 'views/' . $file_name . '.flake.php';
    }
}

if(!function_exists('avatar')) {
    function avatar($name) {
        $name = str_replace(' ', '+', $name);
        return "https://ui-avatars.com/api/?type=svg&name=$name&size=100";
    }
}

if(!function_exists('mailer')) {
    function mailer($address, $subject, $message, $senderEmail = null, $senderName = null) {
        if(empty(trim($address))) {
            throw new Error('Address is required');
        }
        if(empty(trim($subject))) {
            throw new Error('Subject is required');
        }
        if(empty(trim($message))) {
            throw new Error('Message is required');
        }

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Mailer = env('SMTP_MAILER');
        $mail->Host = env('SMTP_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('SMTP_USER');
        $mail->Password = env('SMTP_PASS');
        $mail->SMTPSecure = env('SMTP_SECURE');
        $mail->Port = env('SMTP_PORT');

        $senderName = !empty(trim($senderName)) ? $senderName : env('APP_NAME') . ' - Support';
        $senderEmail = !empty(trim($senderEmail)) ? $senderEmail : 'support@' . env('APP_DOMAIN');

        $mail->setFrom($senderEmail, $senderName);
        $mail->addAddress($address);

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        if($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}