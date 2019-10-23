<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/hello', function () {
    return 'hello world';
});

Route::get('/city', function (Request $request) {
    $province = $request->get('q');
    $provinceid = App\ProvinceModel::where('name', $province)->first()->province_id;
    return App\CityModel::where('province_id', $provinceid)->get([DB::raw('name as id'), DB::raw('name as text')]);
});
Route::get('/country', function (Request $request) {
    $city = $request->get('q');
    $cityid = App\cityModel::where('name', $city)->first()->city_id;
    return App\CountryModel::where('city_id', $cityid)->get([DB::raw('name as id'), DB::raw('name as text')]);
});

/*Route::get('/city', function (Request $request) {
    $proviceid = $request->get('q');
    return App\CityModel::where('province_id', $proviceid)->get([DB::raw('city_id as id'), DB::raw('name as text')]);
});
Route::get('/country', function (Request $request) {
    $cityid = $request->get('q');
    return App\CountryModel::where('city_id', $cityid)->get([DB::raw('country_id as id'), DB::raw('name as text')]);
});*/
