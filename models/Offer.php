<?php

namespace Offer;

use City\City;
use Entry\Entry;
use User\User;
use Winner\Winner;

class Offer {
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
            $result[$key]['entry_type'] = Entry::getEntryById($item['entry_type']);
        }

        return $result;
    }

    public static function getOfferById(int $id) {
        if(!isset($id) || empty($id)) {
            throw new \Error('Offer ID is required');
        }

        $query = mysqli_query(db(), "SELECT * FROM offers WHERE id = '$id'");

        if(mysqli_num_rows($query) <= 0) {
            return false;
        }

        $offer = mysqli_fetch_object($query);
        $offer->creator = User::getUserById($offer->created_by);
        $offer->entry_type = Entry::getEntryById($offer->entry_type);

        return $offer;
    }

    public static function getOffersByCities(array $cities) {
        if(!isset($cities) || empty($cities)) {
            throw new \Error('City is required');
        }

        $cities = implode(", ", $cities);

        $date = date('d/m/Y', strtotime('today'));
        $query = "SELECT * FROM offers WHERE city IN ($cities) AND date = '$date'";

        $query = mysqli_query(db(), $query);

        if(mysqli_num_rows($query) <= 0) {
            return false;
        }

        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($result as $key => $item) {
            // Convert to int
            $result[$key]['id'] = intval($result[$key]['id']);
            $result[$key]['created_by'] = intval($result[$key]['created_by']);
            $result[$key]['created_at'] = intval($result[$key]['created_at']);

            // Assign user data
            $result[$key]['creator'] = User::getUserById($item['created_by']);

            // Assign city
            $result[$key]['city'] = City::getCityById($item['city']);
            $result[$key]['entry_type'] = Entry::getEntryById($item['entry_type']);
            $result[$key]['winners'] = Winner::getWinnersByOfferId($item['id']);
        }

        return $result;
    }

    public static function createOffer($data) {
        $conn = db();

        $data['created_by'] = user()->id;
        $data['created_at'] = strtotime('now');
        if(substr($data['map_link'], 0, 8) != "https://" && substr($data['map_link'], 0, 7) != "http://") {
            $data['map_link'] = 'http://' . $data['map_link'];
        }

        $data = (object)$data;

        $query = mysqli_query($conn, "INSERT INTO offers (date, city, entry_type, winners_count, shop, discount, information, map_link, created_by, created_at) VALUES ('$data->date', '$data->city', '$data->entry_type', '$data->winners_count', '$data->shop', '$data->discount', '$data->information', '$data->map_link', '$data->created_by', '$data->created_at')");

        if(!$query) {
            return false;
        }

        $id = mysqli_insert_id($conn);

        // Create winners
        $participantsOfTheCityQuery = mysqli_query($conn, "SELECT * FROM participants WHERE city_id = '$data->city'");

        if(mysqli_num_rows($participantsOfTheCityQuery) > 0) {
            $participantsOfTheCity = mysqli_fetch_all($participantsOfTheCityQuery, MYSQLI_ASSOC);
            shuffle($participantsOfTheCity);

            $winnersQuery = 'INSERT INTO winners (offer_id, user_id) VALUES ';
            for($i = 0; $i < $data->winners_count; $i++) {
                $user_id = $participantsOfTheCity[$i]['user_id'];
                $winnersQuery .= "('$id', '$user_id')";
                if($i != $data->winners_count - 1) {
                    $winnersQuery .= ', ';
                }
            }

            // Execute and create winners
            mysqli_query($conn, $winnersQuery);
        }

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