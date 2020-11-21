<?php

namespace Api\AdminController;

use AdScript\AdScript;
use Entry\Entry;
use Offer\Offer;
use City\City;
use User\User;

class AdminController {

    public static function getAllOffers() {
        request_method('GET');

        // Check privilege
        if(!user()) {
            return response(false, null, 'You are not authorized');
        }

        if(isset($_GET['cities']) && !empty($_GET['cities'])) {
            $cities = explode(' ', $_GET['cities']);
            $cities = array_filter($cities, function ($city) {
                return !empty($city);
            });

            $result = Offer::getOffersByCities($cities);
        } else {
            $result = Offer::getAllOffers();
        }

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
            'date' => sanitize_input($_POST['date']),
            'city' => sanitize_input($_POST['city']),
            'entry_type' => sanitize_input($_POST['entry_type']),
            'winners_count' => sanitize_input($_POST['winners_count']),
            'shop' => sanitize_input($_POST['shop']),
            'discount' => sanitize_input($_POST['discount']),
            'information' => sanitize_input($_POST['information']),
            'map_link' => sanitize_input($_POST['map_link']),
        ];

        // Create offer
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

        // Delete offer
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

        // Delete user
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

        // Create city
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

        // Delete city
        $result = City::deleteCity($id);

        if(!$result) {
            return response(false, null, 'Oops! City could not be deleted');
        }

        return response(true, null, 'City has been deleted');
    }

    // Entry
    public static function createEntry() {
        request_method('POST');

        // Check privilege
        if(!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        // Validate data
        if(!isset($_POST['name']) || empty(sanitize_input($_POST['name']))) {
            return response(false, null, 'Entry name is required');
        }
        if(!isset($_FILES['background']) || empty($_FILES['background'])) {
            return response(false, null, 'Entry background is required');
        }
        if(!getimagesize($_FILES['background']['tmp_name'])) {
            return response(false, null, 'Background is not a supported image file');
        }

        if(filesize($_FILES['background']['tmp_name']) > 5000000) {
            return response(false, null, 'Max file size is 2 MB');
        }

        // Validate hex code
//        if(!validate_hex(sanitize_input($_POST['background']))) {
//            return response(false, null, 'Invalid hex code. Please try again.');
//        }

        // Data
        $data = [
            'name' => sanitize_input($_POST['name']),
//            'background' => sanitize_input($_FILES['background']),
            'created_by' => user()->id,
        ];

        // Create entry
        $result = Entry::createEntry($data, $_FILES['background']);

        if(!$result) {
            return response(false, null, 'Oops! New entry cound not be created');
        }

        return response(true, $result, 'New entry created');
    }
    public static function getAllEntries() {
        request_method('GET');

        // Check privilege
        if(!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        $result = Entry::getAllEntries();

        if(!$result) {
            return response(false, null, 'No entry found');
        }

        return response(true, $result, 'Entries found');
    }

    public static function deleteEntry() {
        request_method('DELETE');

        // Check privilege
        if (!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        // Validate data
        if(!isset($_GET['id']) || empty(sanitize_input($_GET['id']))) {
            return response(false, null, 'Entry ID is required');
        }

        $id = sanitize_input($_GET['id']);

        // Delete entry
        $result = Entry::deleteEntry($id);

        if(!$result) {
            return response(false, null, 'Oops! Entry could not be deleted');
        }

        return response(true, null, 'Entry has been deleted');
    }

    // Ads Scripts
    public static function updateAdsScript() {
        request_method('POST');

        // Check privilege
        if (!is_admin()) {
            return response(false, null, 'You are not authorized');
        }

        $data = [
            'top_script' => [
                'script' => htmlentities(sanitize_input($_POST['top_script']), ENT_QUOTES),
                'position' => 'top',
            ],
            'right_script' => [
                'script' => htmlentities(sanitize_input($_POST['right_script']), ENT_QUOTES),
                'position' => 'right',
            ],
            'bottom_script' => [
                'script' => htmlentities(sanitize_input($_POST['bottom_script']), ENT_QUOTES),
                'position' => 'bottom',
            ],
            'left_script' => [
                'script' => htmlentities(sanitize_input($_POST['left_script']), ENT_QUOTES),
                'position' => 'left',
            ],
        ];

        // Update Script
        $result = AdScript::updateScript($data);

        if(!$result) {
            return response(false, null, 'Oops! Script could not be updated');
        }

        return response(true, $result, 'Scripts have been updated');
    }
}