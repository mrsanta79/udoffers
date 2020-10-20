<?php

namespace AuthController;

class AuthController {
    public static function login() {
        if(user()) {
            if(is_admin()) {
                redirect('/admin/fields');
            } else {
                echo 'User';
            }
        }

        return view('auth/login');
    }

    public static function logout() {
        reset_user();

        redirect('login');
    }
}