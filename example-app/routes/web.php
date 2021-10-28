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

Route::get( '/', function () {
	return view( 'home' );
} );


Route::get( '/about-us', function () {


	return 'ok';
} );


Route::get( '/posts', function () {


	return 'posts';
} );


Route::get( '/posts/{post}', function ( $slug ) {


	$content = \App\Models\Posts::findBySlug( $slug );


	return view( 'posts', [ 'content' => $content ] );

	// where post var like a-Z and can include -
} )->where( 'post', '[a-z_\-]+' );






