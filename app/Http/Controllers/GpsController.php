<?php
/**
 * Created by PhpStorm.
 * User: faiz
 * Date: 11/21/2015
 * Time: 2:41 PM
 */

namespace bustracker\Http\Controllers;

use bustracker\Model\Gps;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GpsController extends Controller
{

    private $gpsModel;

    public function __construct(Gps $gpsModel)
    {
        $this->gpsModel = $gpsModel;
    }

    public function index()
    {
        $gpsData = $this->gpsModel->all();

        return $gpsData;
    }

    public function store(Request $request)
    {
        $gpsData = $request->all();

        $client = new Client();

        $response = $client->request('GET', 'http://maps.googleapis.com/maps/api/geocode/json', [
            'query' => [
                'latlng' =>  $gpsData['latitude'] . ',' . $gpsData['longitude'],
            ],
        ]);

        $address = json_decode($response->getBody(), true);

        if (!empty($address)) {
            $gpsData['address'] = $address['results'][0]['formatted_address'];
        }

        $storeGPSResult = $this->gpsModel->create($gpsData);

        if ($storeGPSResult) {
            return 'Successfully store GPS Data.';
        }

        return 'Failed to Store GPS Data';
    }

    public function getLastData()
    {
        $lastGPSData = $this->gpsModel->orderBy('id', 'desc')->first();

        //request the directions
        // https://maps.googleapis.com/maps/api/distancematrix/json?origins=3.119816,101.665262&destinations=3.159236,101.701775
        //&departure_time=1448110050&mode=driving&traffic_model=pessimistic&key=AIzaSyARWwkONQ4RXXVJrrYRBCaOtYrp9hAg2sU
        $routes=json_decode(file_get_contents(
            'http://maps.googleapis.com/maps/api/directions/json?&alternatives=true&origin=' . $lastGPSData['latitude']
            . ',' . $lastGPSData['longitude'] . '&destination=3.159236,101.701775'
        ))->routes;
        $lastGPSData['distance'] = $routes[0]->legs[0]->distance->text;
        $lastGPSData['estimated_duration'] = $routes[0]->legs[0]->duration->text;

        return json_encode($lastGPSData);
    }

    public function polingGPSData()
    {
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->setCallback(
            function() {
                echo "retry: 30000\n\n"; // no retry would default to 3 seconds.
                echo "data: " . $this->getLastData() . "\n\n";
                ob_flush();
                flush();
            });
        $response->send();
    }



}