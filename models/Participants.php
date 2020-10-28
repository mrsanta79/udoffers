<?php

namespace Participants;

use City\City;
use User\User;

class Participants {
    public static function participate($cities) {
        $user_id = user()->id;
        $cities = explode(',', $cities);
        $getOldParticipations = mysqli_query(db(), "SELECT * FROM participants WHERE user_id = '$user_id'");

        // Remove previous participations
        if(mysqli_num_rows($getOldParticipations) > 0) {
            mysqli_query(db(), "DELETE FROM participants WHERE user_id = '$user_id'");
        }

        // Add new participations
        $query = 'INSERT INTO participants (user_id, city_id) VALUES ';
        foreach($cities as $key => $city) {
            $query .= "('$user_id', '$city')";
            if($key != count($cities) - 1) {
                $query .= ', ';
            }
        }

        if(!mysqli_query(db(), $query)) {
            return false;
        }

        return true;
    }
    public static function getAllParticipants() {
        $query = mysqli_query(db(), "SELECT * FROM participants");

        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($result as $key=>$item) {
            // Convert to int
            $result[$key]['id'] = intval($result[$key]['id']);
            $result[$key]['user_id'] = intval($result[$key]['user_id']);
            $result[$key]['city_id'] = intval($result[$key]['city_id']);

            // Assign user data
            $result[$key]['user'] = User::getUserById($item['user_id']);

            // Assign city
            $result[$key]['city'] = City::getCityById($item['city_id']);
        }

        return $result;
    }
    public static function getAllParticipantsByUserId(int $user_id) {
        $query = mysqli_query(db(), "SELECT * FROM participants WHERE user_id = '$user_id'");

        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($result as $key=>$item) {
            // Convert to int
            $result[$key]['id'] = intval($result[$key]['id']);
            $result[$key]['user_id'] = intval($result[$key]['user_id']);
            $result[$key]['city_id'] = intval($result[$key]['city_id']);

            // Assign user data
            $result[$key]['user'] = User::getUserById($item['user_id']);

            // Assign city
            $result[$key]['city'] = City::getCityById($item['city_id']);
        }

        return $result;
    }
}