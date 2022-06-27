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

Route::get('/welcome', function () { return view('welcome'); });
Route::get('/', function () { return view('main'); });

/****[ SERVICIOS WEB ]*****/

    //INDEX
    Route::get('serv_afp','App\Http\Controllers\Servicios\ConsultaAfpController@index');
    //OBTENER AFP
    Route::post('serv_afp/fun_obtener_afp','App\Http\Controllers\Servicios\ConsultaAfpController@fun_obtener_afp');
    
    
    
