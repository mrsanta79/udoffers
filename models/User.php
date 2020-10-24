<?php

namespace User;

class User {
    public static function getAllUsers() {
        $loggedinId = user()->id;
        $query = mysqli_query(db(), "SELECT * FROM users WHERE id != '$loggedinId' AND is_deleted = 0");

        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($result as $key=>$item) {

            unset($result[$key]['password']);
            $result[$key]['id'] = intval($result[$key]['id']);
            $result[$key]['is_facebook'] = boolval($result[$key]['is_facebook']);
            $result[$key]['is_google'] = boolval($result[$key]['is_google']);
            $result[$key]['is_admin'] = boolval($result[$key]['is_admin']);
            $result[$key]['created_at'] = intval($result[$key]['created_at']);
            $result[$key]['is_deleted'] = boolval($result[$key]['is_deleted']);
        }

        return $result;
    }
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
        $user->is_deleted = boolval($user->is_deleted);

        return $user;
    }

    public static function deleteUser(int $id) {
        if(!isset($id) || empty($id)) {
            throw new \Error('User ID is required');
        }

        $query = mysqli_query(db(), "UPDATE users SET is_deleted = 1 WHERE id = '$id'");

        if(!$query) {
            return false;
        }

        return true;
    }

}