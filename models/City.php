<?php

namespace City;

use User\User;

class City {
    public static function getAllCities() {
        $query = mysqli_query(db(), "SELECT * FROM cities");

        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($result as $key=>$item) {
            $result[$key]['id'] = intval($result[$key]['id']);
            $result[$key]['created_at'] = intval($result[$key]['created_at']);

            // Assign user data
            $result[$key]['creator'] = User::getUserById($result[$key]['created_by']);
        }

        return $result;
    }

    public static function getCityById(int $id) {
        if(!isset($id) || empty($id)) {
            throw new \Error('City ID is required');
        }

        $query = mysqli_query(db(), "SELECT * FROM cities WHERE id = '$id'");
        if(mysqli_num_rows($query) < 1) {
            return false;
        }

        $city = mysqli_fetch_object($query);

        $city->id = intval($city->id);
        $city->created_at = intval($city->created_at);

        // Assign user data
        $city->creator = User::getUserById($city->created_by);

        return $city;
    }

    public static function getCityByName(string $name) {
        if(!isset($name) || empty($name)) {
            throw new \Error('City name is required');
        }

        $query = mysqli_query(db(), "SELECT * FROM cities WHERE name = '$name'");
        if(mysqli_num_rows($query) < 1) {
            return false;
        }

        $city = mysqli_fetch_object($query);

        $city->id = intval($city->id);
        $city->created_at = intval($city->created_at);

        // Assign user data
        $city->creator = User::getUserById($city->created_by);

        return $city;
    }

    public static function createCity($data) {
        $conn = db();

        $data['created_at'] = strtotime('now');

        $data = (object)$data;

        $query = mysqli_query($conn, "INSERT INTO cities (name, created_by, created_at) VALUES ('$data->name', '$data->created_by', '$data->created_at')");

        if(!$query) {
            return false;
        }

        $id = mysqli_insert_id($conn);

        // Get city details
        $city = self::getCityById($id);
        return $city;
    }

    public static function deleteCity(int $id) {
        $query = mysqli_query(db(), "DELETE FROM cities WHERE id = '$id'");

        if(!$query) {
            return false;
        }

        return true;
    }
}