<?php

namespace Admin;

use User\City;
use User\User;

class Admin {
    public static function getAllOffers() {
        $query = mysqli_query(db(), "SELECT * FROM offers");

        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($result as $key=>$item) {
            // Convert to int
            $result[$key]['id'] = intval($result[$key]['id']);
            $result[$key]['created_by'] = intval($result[$key]['created_by']);
            $result[$key]['created_at'] = intval($result[$key]['created_at']);

            // Assign user data
            $result[$key]['creator'] = User::getUserById($item['created_by']);

            // Assign city
            $result[$key]['city'] = City::getCityById($item['city']);
        }

        return $result;
    }

    public static function getOfferById(int $id) {
        if(!isset($id) || empty($id)) {
            throw new \Error('Offer ID is required');
        }

        $query = mysqli_query(db(), "SELECT * FROM offers WHERE offers.id = '$id'");

        if(mysqli_num_rows($query) <= 0) {
            return false;
        }

        $offer = mysqli_fetch_object($query);
        $offer->creator = User::getUserById($offer->created_by);

        return $offer;
    }

    public static function createOffer($data) {
        $conn = db();

        $data['created_by'] = user()->id;
        $data['created_at'] = strtotime('now');

        $data = (object)$data;

        $query = mysqli_query($conn, "INSERT INTO offers (date, city, entry_type, winners_count, shop, discount, information, map_link, created_by, created_at) VALUES ('$data->date', '$data->city', '$data->entry_type', '$data->winners_count', '$data->shop', '$data->discount', '$data->information', '$data->map_link', '$data->created_by', '$data->created_at')");

        if(!$query) {
            return false;
        }

        $id = mysqli_insert_id($conn);

        // Get offer details
        $offer = self::getOfferById($id);
        return $offer;
    }

    public static function deleteOffer(int $id) {
        if(!isset($id) || empty($id)) {
            throw new \Error('Offer ID is required');
        }

        $query = mysqli_query(db(), "DELETE FROM offers WHERE id = '$id'");

        if(!$query) {
            return false;
        }

        return true;
    }
}