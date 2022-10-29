<?php

namespace App\Services\Visit;

use App\Services\Core\BaseService;

class VisitService extends BaseService
{
    

    //Function to get address from latitude and longitude
    public static function geolocationaddress($lat, $long)
    {
        try {
            $API_KEY=@settings('google');
            $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=$API_KEY";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $geocode);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($response);
            $dataarray = get_object_vars($output);
            if ($dataarray['status'] != 'ZERO_RESULTS' && $dataarray['status'] != 'INVALID_REQUEST') {
                if (isset($dataarray['results'][0]->formatted_address)) {

                    $address = $dataarray['results'][0]->formatted_address;

                } else {
                    $address = 'Not Found';

                }
            } else {
                $address = 'Not Found';
            }

            return $address;
        } catch (\Throwable $th) {
            return "";
        }
    }
}