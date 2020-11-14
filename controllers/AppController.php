<?php

namespace AppController;

use AdScript\AdScript;
use City\City;
use Entry\Entry;
use Offer\Offer;
use Participants\Participants;

class AppController {
    public static function index() {
        if(!user()) {
            redirect('/login');
        }

        $participations = Participants::getAllParticipantsByUserId(user()->id);

        $cities = [];
        foreach ($participations as $participation) {
            $cities[] = $participation['city']->id;
        }

        $selectedCities = array_map(function($item) {
            return $item['city'];
        }, $participations);

        $data = [
            'participations' => $participations,
            'entries' => Entry::getAllEntries(),
            'cities' => City::getAllCities(),
            'offers' => count($cities) ? Offer::getOffersByCities($cities) : null,
            'selected_cities' => $selectedCities,
            'ads' => AdScript::getScripts()
        ];

        return view('app/index', $data);
    }
}