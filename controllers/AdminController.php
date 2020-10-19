<?php

namespace AdminController;

class AdminController {
    public static function index() {
        redirect('/admin/fields');
    }

    public static function fields() {
        return view('admin/fields', null, 'fields');
    }

    public static function offers() {
        return view('admin/offers', null, 'offers');
    }

    public static function users() {
        return view('admin/users', null, 'users');
    }

    public static function createField() {

    }

    public static function createOffer() {

    }
}