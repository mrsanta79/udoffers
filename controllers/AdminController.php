<?php

namespace AdminController;

use City\City;
use Entry\Entry;

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

        $data = [
            'entries' => Entry::getAllEntries(),
            'cities' => City::getAllCities(),
        ];

        return view('admin/fields', $data, 'fields');
    }

    public static function offers() {
        if(!user()) {
            redirect('/login');
        }
        if(!is_admin()) {
            redirect('/');
        }

        $data = [
            'entries' => Entry::getAllEntries(),
            'cities' => City::getAllCities(),
        ];

        return view('admin/offers', $data, 'offers');
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
}