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


	return view( 'posts', [ 'posts' => \App\Models\Posts::all() ] );
} );


Route::get( '/posts/{post}', function ( $slug ) {


//	$post = \App\Models\Posts::findBySlug( $slug );
	$post = \App\Models\Posts::findBySlugFromCollection( $slug );


	return view( 'posts_details', [ 'post' => $post ] );

	// where post var like a-Z and can include -
} )->where( 'post', '[a-z_\-]+' );






