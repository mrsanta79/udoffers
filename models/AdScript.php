<?php

namespace AdScript;

class AdScript {
    public static function getScript() {
        $query = mysqli_query(db(), "SELECT * FROM ads WHERE id = 1");

        return mysqli_fetch_array($query);
    }

    public static function updateScript($data) {
        $data = (object)$data;

        $query = mysqli_query(db(), "UPDATE ads SET script = '$data->script' WHERE id = 1");

        if(!$query) {
            return false;
        }

        return [
            'id' => 1,
            'script' => $data->script
        ];
    }
}