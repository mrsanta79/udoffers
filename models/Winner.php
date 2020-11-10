<?php

namespace Winner;

use User\User;

class Winner {
    public static function getWinnersByOfferId(int $id) {
        if (!isset($id) || empty($id)) {
            throw new \Error('Offer ID is required');
        }

        $query = mysqli_query(db(), "SELECT * FROM winners WHERE offer_id = '$id'");
        if (mysqli_num_rows($query) < 1) {
            return null;
        }

        $winners = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach($winners as $key => $winner) {
            $winners[$key]['id'] = intval($winners[$key]['id']);
            $winners[$key]['user_id'] = intval($winners[$key]['user_id']);
            $winners[$key]['offer_id'] = intval($winners[$key]['offer_id']);

            // Assign user data
            $winners[$key]['user'] = User::getUserById($winner['user_id']);
        }

        return $winners;
    }
}