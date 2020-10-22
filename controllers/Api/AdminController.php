<?php

namespace Api\AdminController;

use Admin\Admin;
use User\User;

class AdminController {

    public static function getAllOffers() {
        request_method('GET');

        // Check privilege
        if(!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        $result = Admin::getAllOffers();

        if(!$result) {
            return response(false, null, 'No offer found');
        }

        return response(true, $result, 'Offers found');
    }

    public static function createOffer() {
        request_method('POST');

        // Check privilege
        if(!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        // Validate data
        if(!isset($_POST['date']) || empty(sanitize_input($_POST['date']))) {
            return response(false, null, 'Date is required');
        }
        if(!isset($_POST['country']) || empty(sanitize_input($_POST['country']))) {
            return response(false, null, 'Please select a country');
        }
        if(!isset($_POST['entry_type']) || empty(sanitize_input($_POST['entry_type']))) {
            return response(false, null, 'Please select an entry type');
        }
        if(!isset($_POST['winners_count']) || empty(sanitize_input($_POST['winners_count']))) {
            return response(false, null, 'Please select the maximum number of winners');
        }
        if(!isset($_POST['shop']) || empty(sanitize_input($_POST['shop']))) {
            return response(false, null, 'Shop name is required');
        }
        if(!isset($_POST['discount']) || empty(sanitize_input($_POST['discount']))) {
            return response(false, null, 'Discount details is required');
        }
        if(!isset($_POST['map_link']) || empty(sanitize_input($_POST['map_link']))) {
            return response(false, null, 'Please enter the google map link');
        }

        // Data
        $data = [
            'date' => strtotime(sanitize_input($_POST['date'])),
            'country' => sanitize_input($_POST['country']),
            'entry_type' => sanitize_input($_POST['entry_type']),
            'winners_count' => sanitize_input($_POST['winners_count']),
            'shop' => sanitize_input($_POST['shop']),
            'discount' => sanitize_input($_POST['discount']),
            'information' => sanitize_input($_POST['information']),
            'map_link' => sanitize_input($_POST['map_link']),
        ];

        // Create entry
        $result = Admin::createOffer($data);

        if(!$result) {
            return response(false, null, 'Oops! New offer cound not be created');
        }

        return response(true, $result, 'New offer created');
    }

    public static function deleteOffer() {
        request_method('DELETE');

        // Check privilege
        if (!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        // Validate data
        if(!isset($_GET['id']) || empty(sanitize_input($_GET['id']))) {
            return response(false, null, 'Offer ID is required');
        }

        $id = sanitize_input($_GET['id']);

        // Delete entry
        $result = Admin::deleteOffer($id);

        if(!$result) {
            return response(false, null, 'Oops! Offer could not be deleted');
        }

        return response(true, null, 'Offer has been deleted');
    }

    // Users
    public static function getAllUsers() {
        request_method('GET');

        // Check privilege
        if(!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        $result = User::getAllUsers();

        if(!$result) {
            return response(false, null, 'No user found');
        }

        return response(true, $result, 'Users found');
    }

    public static function deleteUser() {
        request_method('DELETE');

        // Check privilege
        if (!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        // Validate data
        if(!isset($_GET['id']) || empty(sanitize_input($_GET['id']))) {
            return response(false, null, 'User ID is required');
        }

        $id = sanitize_input($_GET['id']);

        // Delete entry
        $result = User::deleteUser($id);

        if(!$result) {
            return response(false, null, 'Oops! User could not be deleted');
        }

        return response(true, null, 'User has been deleted');
    }
}