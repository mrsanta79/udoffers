<?php

namespace Api\AppController;

use Participants\Participants;

class AppController {
    public static function getAllParticipants() {
        request_method('GET');

        // Check privilege
        if(!user()) {
            return response(false, null, 'You are not authorized');
        }

        $result = Participants::getAllParticipants();

        if(!$result) {
            return response(false, null, 'No participants found');
        }

        return response(true, $result, 'Participants found');
    }

    public static function participate() {
        request_method('POST');

        // Check privilege
        if(!user()) {
            return response(false, null, 'You are not authorized');
        }

        // Validate data
        if(!isset($_POST['cities']) || empty(sanitize_input($_POST['cities']))) {
            return response(false, null, 'Please select at least one city to update');
        }

        $result = Participants::participate(sanitize_input($_POST['cities']));

        if(!$result) {
            return response(false, null, 'Something went wrong!');
        }

        return response(true, $result, 'You have participated successfully.');
    }
}