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

Route::get( '/posts/{post}', function ( $slug ) {


	if ( ! file_exists( $path = ( __DIR__ . '/../resources/views/static_html/' . $slug . '.html' ) ) ) {
		return redirect( '/' );
	}


	//cache 1200 seconds, return the cache content if not expired.
	$content = cache()->remember( "posts.{$slug}", 10, function () use ( $path ) {
		return file_get_contents( $path );
	} );


	return view( 'posts', [ 'content' => $content ] );

	// where post var like a-Z and can include -
} )->where( 'post', '[a-z_\-]+' );






