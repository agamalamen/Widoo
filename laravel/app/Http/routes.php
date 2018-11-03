<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
	'uses' => 'HomeController@getWelcome',
	'as'   => 'get.welcome'
]);

Route::get('/challenges/{challenge_id}', [
	'uses' => 'ChallengeController@getChallenge',
	'as'   => 'get.challenge'
]);

Route::post('/challenges/functions/post-qr', [
	'uses' => 'ChallengeController@postQr',
	'as'   => 'post.qr',
	'middleware' => 'auth'
]);

Route::auth();

Route::auth();
