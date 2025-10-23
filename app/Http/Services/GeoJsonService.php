<?php

namespace App\Http\Services;

class GeoJsonService {

    public function getPointOf($datas, $resource) {

        $geoJsonData = $datas->map(function ($data) use ($resource){
            return  [
                'type' => 'Feature',
                'properties' => new $resource($data),
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        $data->lng,
                        $data->lat
                    ],
                ],
            ];
        });

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $geoJsonData
        ]);

    }

}
