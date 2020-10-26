<?php

namespace Api\AdminController;

use Offer\Offer;
use City\City;
use User\User;

class AdminController {

    public static function getAllOffers() {
        request_method('GET');

        // Check privilege
        if(!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        $result = Offer::getAllOffers();

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
        if(!isset($_POST['city']) || empty(sanitize_input($_POST['city']))) {
            return response(false, null, 'Please select a city');
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
            'city' => sanitize_input($_POST['city']),
            'entry_type' => sanitize_input($_POST['entry_type']),
            'winners_count' => sanitize_input($_POST['winners_count']),
            'shop' => sanitize_input($_POST['shop']),
            'discount' => sanitize_input($_POST['discount']),
            'information' => sanitize_input($_POST['information']),
            'map_link' => sanitize_input($_POST['map_link']),
        ];

        // Create entry
        $result = Offer::createOffer($data);

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
        $result = Offer::deleteOffer($id);

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

    // City
    public static function createCity() {
        request_method('POST');

        // Check privilege
        if(!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        // Validate data
        if(!isset($_POST['name']) || empty(sanitize_input($_POST['name']))) {
            return response(false, null, 'City name is required');
        }

        // Check if city name is already present
        if(City::getCityByName(sanitize_input($_POST['name']))) {
            return response(false, null, 'This city is already present');
        }

        // Data
        $data = [
            'name' => sanitize_input($_POST['name']),
            'created_by' => user()->id,
        ];

        // Create entry
        $result = City::createCity($data);

        if(!$result) {
            return response(false, null, 'Oops! New city cound not be created');
        }

        return response(true, $result, 'New city created');
    }
    public static function getAllCities() {
        request_method('GET');

        // Check privilege
        if(!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        $result = City::getAllCities();

        if(!$result) {
            return response(false, null, 'No city found');
        }

        return response(true, $result, 'Cities found');
    }

    public static function deleteCity() {
        request_method('DELETE');

        // Check privilege
        if (!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        // Validate data
        if(!isset($_GET['id']) || empty(sanitize_input($_GET['id']))) {
            return response(false, null, 'City ID is required');
        }

        $id = sanitize_input($_GET['id']);

        // Delete entry
        $result = City::deleteCity($id);

        if(!$result) {
            return response(false, null, 'Oops! City could not be deleted');
        }

        return response(true, null, 'City has been deleted');
    }
}