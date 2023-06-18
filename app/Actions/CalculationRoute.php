<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class CalculationRoute {
    public static function run($latBegin, $longBegin, $latEnd, $longEnd) {
        $response = Http::get("https://api.tomtom.com/routing/1/calculateRoute/{$latBegin},{$longBegin}:{$latEnd},{$longEnd}/json?instructionsType=text&language=en-US&vehicleHeading=90&sectionType=traffic&report=effectiveSettings&routeType=eco&traffic=true&avoid=unpavedRoads&travelMode=car&vehicleMaxSpeed=120&vehicleCommercial=false&vehicleEngineType=combustion&key=8G20bE5y7PQbBlAbMlAU6q6IEuKUhI33");

        logger($latBegin);
        logger($longBegin);
        logger($latEnd);
        logger($longEnd);

        return $response->json()['routes'][0]['summary']['lengthInMeters'];

    }
}
