<?php

if(!function_exists('validate_hex')) {
    function validate_hex($code) {
        if(preg_match('/^#[0-9A-F]{6}$/i', $code) || preg_match('/^#([0-9A-F]{3}){1,2}$/i', $code)) {
            return true;
        } else {
            return false;
        }
    }
}

if(!function_exists('generate_user_id')) {
    function generate_user_id($user_id) {
        $userIdLength = strlen($user_id);
        $maxLength = 6;
        $newUserId = null;

        if($userIdLength < $maxLength) {
            for($i = 0; $i < $maxLength - $userIdLength; $i++) {
                $newUserId .= 0;
            }
            $newUserId .= $user_id;
        } else {
            $newUserId = $user_id;
        }
        return 'UD' . $newUserId;
    }
}