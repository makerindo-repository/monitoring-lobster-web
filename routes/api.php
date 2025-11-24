<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {

    /* GET DATA MARKER EDGE */
    Route::get('/marker-edge', 'GeneralController@getMarkerEdge')->name('edges-marker');

    /* GET DETAIL INFORMASI DATA EDGE */
    Route::get('/detail-marker-edge/{id}', 'GeneralController@getDetailMarkerEdge');

    /* LOGIN DEVICE */
    Route::post('/auth-login', 'GeneralController@authLogin');

    Route::post('/maintenance-device', 'GeneralController@maintenanceDevice');
    Route::post('/data', 'GeneralController@dummyData');
    Route::post('/telemetry', 'GeneralController@storeTelemetry');
    Route::post('/sensor', 'GeneralController@storeDataSensors');

    /* PROFILE */
    Route::get('/profile', 'GeneralController@getProfile');
    Route::post('/profile', 'GeneralController@updateProfile');

    /* GET DATA MONITORING TELEMETRY */
    Route::get('/monitoring', 'GeneralController@getMonitoringData');
    Route::get('/monitoringv2/{id}', 'GeneralController@newDashboard');

    /*
        API FOR MOBILE ------------------
    */

    /* API UNTUK AKTIVASI IOT NODE */
    Route::post('/check-node', 'GeneralController@checkStatusNode');
    Route::post('/check-node-maintenance', 'GeneralController@checkStatusNodeMaintenance');
    Route::post('/registration-node', 'GeneralController@registrationNode');

    Route::get('/city', 'GeneralController@getCity');

    Route::get('/activated-nodes', 'GeneralController@listActivatedNode');
    Route::get('/activated-nodes/{serial_number}', 'GeneralController@detailActivatedNode');
    Route::get('/activated-nodes/{id}/telemetri', 'GeneralController@listTelemetriNode');
    Route::get('/activated-nodes/{id}/telemetri-daily', 'GeneralController@dayTelemetriNode');
    Route::get('/activated-nodes/{id}/telemetri-monthly', 'GeneralController@monthTelemetriNode');
    Route::get('/activated-nodes/{id}/telemetri-range', 'GeneralController@rangeTelemetriNode');

    // Reset Password

    Route::post('/check-email', 'GeneralController@checkEmail');
    Route::post('/reset-password', 'GeneralController@resetPassword');

    // Sensors
    Route::get('/sensor', 'GeneralController@getSensors');
    Route::post('/sensor', 'GeneralController@storeSensors');
    Route::post('/sensor/{id}', 'GeneralController@updateSensor');

    // Treshold
    Route::get('/treshold', 'GeneralController@getTreshold');
    Route::get('/treshold/web', 'GeneralController@getTresholdWeb');
    Route::post('/treshold', 'GeneralController@storeTreshold');
    Route::post('/treshold', 'GeneralController@updateTreshold');

    Route::get('/lokasi', 'GeneralController@getIotNode');
    Route::post('/detect', 'GeneralController@detect');
    Route::get('/stream/{encoded}', 'GeneralController@proxyVideo');
});
