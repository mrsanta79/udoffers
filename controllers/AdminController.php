<?php

namespace AdminController;

class AdminController {
    public static function index() {
        if(!user()) {
            redirect('/login');
        }
        if(!is_admin()) {
            redirect('/');
        }

        redirect('/admin/fields');
    }

    public static function fields() {
        if(!user()) {
            redirect('/login');
        }
        if(!is_admin()) {
            redirect('/');
        }

        return view('admin/fields', null, 'fields');
    }

    public static function offers() {
        if(!user()) {
            redirect('/login');
        }
        if(!is_admin()) {
            redirect('/');
        }

        return view('admin/offers', null, 'offers');
    }

    public static function users() {
        if(!user()) {
            redirect('/login');
        }
        if(!is_admin()) {
            redirect('/');
        }

        return view('admin/users', null, 'users');
    }

    public static function createField() {

    }

    public static function createOffer() {

    }
}