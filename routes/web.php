<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('prueba/{name}', 'PruebaController@prueba');

Route::resource('trainers', 'TrainerController');
//Route::resource('pokemons', 'PokemonController');
Route::get('trainers/{trainer}/pokemons','PokemonController@index');
Route::post('trainers/{trainer}/pokemons','PokemonController@store');

/*
Route::get('/name/{name}/lastname/{lastname?}', function($name, $lastname = 'Apellido'){
    return 'Hola soy '.$name.' '.$lastname;
});

Route::get('mi_primer_ruta', function(){
    return 'Hola, esta es mi primer ruta.';
});
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
