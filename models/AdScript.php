<?php

namespace AdScript;

class AdScript {
    public static function getScripts() {
        $query = mysqli_query(db(), "SELECT * FROM ads");

        return fetch_all($query);
    }

    public static function getScriptByPosition($pos = null) {
        if(empty($pos)) {
            throw new \Error('Ads position is required');
        }

        $query = mysqli_query(db(), "SELECT * FROM ads WHERE position = '$pos'");

        return mysqli_fetch_array($query);
    }

    public static function updateScript($data) {
        $data = (object)$data;

        foreach($data as $ad) {
            $ad = (object)$ad;
            mysqli_query(db(), "UPDATE ads SET script = '$ad->script' WHERE position = '$ad->position'");
        }

        return self::getScripts();
    }
}