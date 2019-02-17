<?php

use Illuminate\Http\Request;
use App\SensorData;
use App\Http\Controllers\Api;
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

JsonApi::register('v1')->routes(function ($api) {
    $api->resource('sensors');
    $api->resource('sensorDatas');
    $api->resource('dashboards');
    $api->resource('dashboardItems');


});

//since json api specification does not support
//aggregation we need to make it by ourself.

Route::get('api/v1/sensorDatas/{id}/data/key', function($id) {
    return SensorData::select("key")->where("sensor_id", $id)->groupBy("key")->get();
});


/*

Route::get('dashboards', function() {

    return Dashboard::all();
});

 Route::post('dashboards', function(Request $request) {
    return Dashboard::create($request->all());
});
Route::get('dashboards/{id}', function($id) {
    return Dashboard::find($id);
});
Route::put('dashboards/{id}', function(Request $request, $id) {
    $dash = Dashboard::findOrFail($id);
    $dash->update($request->all());

    return $dash;
});

Route::post('dashboard/item', function(Request $request) {
    $res=$request->all();
    $res['sensor_data_key']= json_encode($res['sensor_data_key']);
    return DashboardItem::create($res);
});

Route::put('dashboard/item', function(Request $request) {
    $res=$request->all();
    $res=$res['sensor_item'];

    $DashBoardItem = DashboardItem::where("dashboard_id", $res['dashboard_id'])->where("sensor_id", $res['sensor_id'])->get();

    foreach($DashBoardItem as $item)
    {
        $res['sensor_data_key']= json_encode($res['sensor_data_key']);
        $res['sensor_data_key']= "";
        $item->update($res);
    }
    $DashBoardItem[0]->sensor_data_key=json_decode($DashBoardItem[0]->sensor_data_key);
    return $DashBoardItem[0];
});

Route::get('dashboard/{id}/items', function($id) {
    return DashboardItem::where("dashboard_id", $id)->get();
});

Route::get('dashboard/{dashboard_id}/item/{item_id}', function($dashboard_id, $item_id) {
    return DashboardItem::where("dashboard_id", $dashboard_id)->where("sensor_id", $item_id)->get();
});




Route::get('sensors', function() {
    // If the Content-Type and Accept headers are set to 'application/json',
    // this will return a JSON structure. This will be cleaned up later.
    return Sensor::all();
});

Route::get('sensors/{id}', function($id) {
    return Sensor::find($id);
});

Route::get('sensors/{id}/data', function($id) {
      return SensorData::select([
        "key", DB::raw("AVG(value) value"),
        DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H') date"),
        DB::raw("MAX(created_at) created_at")])->
            where("sensor_id", $id)->
            groupBy('date')->
            groupBy("key")->get();
});

Route::get('sensors/{id}/data/key', function($id) {
    return SensorData::select("key")->where("sensor_id", $id)->groupBy("key")->get();


});

Route::post('sensors/data', function(Request $request) {
    return SensorData::create($request->all());
});

Route::post('sensors', function(Request $request) {
    return Sensor::create($request->all());
});

Route::put('sensors/{id}', function(Request $request, $id) {
    $Sensor = Sensor::findOrFail($id);
    $Sensor->update($request->all());

    return $Sensor;
});

Route::delete('sensors/{id}', function($id) {
    Sensor::find($id)->delete();

    return 204;
});
*/
