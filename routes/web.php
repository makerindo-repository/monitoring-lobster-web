<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@default');
Route::get('/_debug_', 'HomeController@debug');
Route::get('/editor', function () {
    $activated_at = \Carbon\Carbon::parse('2022-05-19 14:12:32');
    $deadline = \Carbon\Carbon::parse('2022-05-19 14:12:32')->subDays(30);

    $hari = \Carbon\Carbon::parse('2022-05-19 14:12:32')->subDays(20);

    dd($hari->gte($deadline));
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',  'DashboardController@index')->name('dashboard');
    Route::get('/dashboard-v2',  'Dashboardv2Controller@index')->name('dashboardv2');
    Route::get('/monitoring', 'MonitoringController@index')->name('monitoring');
    Route::get('/monitoring/live', 'MonitoringController@live')->name('monitoring.live');
    Route::group([
        'prefix'    => '/data-master',
        'namespace' => 'DataMaster',
    ], function() {
        Route::resource('/edge-computing', 'EdgeComputingController');
        Route::resource('/iot-node', 'IOTNodeController');
        Route::resource('/region', 'RegionController');
        Route::resource('/city', 'CityController');
        Route::resource('/client', 'ClientController');
        Route::resource('/sensor', 'SensorController');
    });
    Route::resource('/user', 'UserController');
    Route::get('/petugas/tambah-role-permissions', 'RolePermissionsController@create')->name('createPermission');
    Route::post('/petugas/tambah-role-permissions', 'RolePermissionsController@store')->name('createPermissions');
    Route::patch('/petugas/update', 'RolePermissionsController@update')->name('updatePermissions');
    Route::delete('/petugas/{id}', 'RolePermissionsController@destroy')->name('destroyPermission');

    Route::get('/setting', 'SettingController@index')->name('setting');
    Route::patch('/setting', 'SettingController@update')->name('setting.update');
    Route::patch('/setting/update-data', 'SettingController@updateTresholds')->name('tresholds.update');
    Route::get('/setting/tambah-data', 'SettingController@createTreshold')->name('create');
    Route::post('/setting', 'SettingController@store')->name('tresholds.store');
    Route::delete('/setting/{id}', 'SettingController@deleteTreshold')->name('tresholds.destroy');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::patch('/profile', 'ProfileController@update')->name('profile.update');

    Route::group([
        'prefix' =>  '/report',
        'as'   => 'report.'
    ], function() {
        Route::get('/node-registration', 'ReportController@nodeRegistration')->name('nodeRegistration');
        Route::get('/node-registration-pdf', 'ReportController@nodeRegistrationPDF')->name('nodeRegistration.pdf');
        Route::get('/node-registration-excel', 'ReportController@nodeRegistrationExcel')->name('nodeRegistration.excel');

        Route::get('/raw-monitoring', 'ReportController@rawMonitoring')->name('rawMonitoring');
        Route::get('/raw-monitoring-pdf', 'ReportController@rawMonitoringPDF')->name('rawMonitoring.pdf');
        Route::get('/raw-monitoring-excel', 'ReportController@rawMonitoringExcel')->name('rawMonitoring.excel');

        Route::get('/maintenance-log', 'ReportController@maintenanceLog')->name('maintenanceLog');
        Route::get('/maintenance-pdf', 'ReportController@maintenanceLogPDF')->name('maintenanceLog.pdf');
        Route::get('/maintenance-excel', 'ReportController@maintenanceLogExcel')->name('maintenanceLog.excel');

        Route::get('/activity-log', 'ReportController@activityLog')->name('activityLog');
        Route::get('/activity-log-pdf', 'ReportController@activityLogPDF')->name('activityLog.pdf');
        Route::get('/activity-log-excel', 'ReportController@activityLogExcel')->name('activityLog.excel');

    });
});
