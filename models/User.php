<?php

namespace User;

class User {

    public static function getUserById(int $id) {
        if(!isset($id) || empty($id)) {
            throw new \Error('User ID is required');
        }

        $query = mysqli_query(db(), "SELECT * FROM users WHERE id = '$id'");
        $user = mysqli_fetch_object($query);

        unset($user->password);
        $user->id = intval($user->id);
        $user->is_facebook = boolval($user->is_facebook);
        $user->is_google = boolval($user->is_google);
        $user->is_admin = boolval($user->is_admin);
        $user->created_at = intval($user->created_at);

        return $user;
    }

}