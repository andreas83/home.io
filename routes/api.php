<?php

use Illuminate\Http\Request;
use App\Sensor;
use App\SensorData;
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

Route::get('sensors', function() {
    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.
    return Sensor::all();
});
 
Route::get('sensors/{id}', function($id) {
    return Sensor::find($id);
});

Route::get('sensors/{id}/data', function($id) {
    return SensorData::where("sensor_id", $id)->get();
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
