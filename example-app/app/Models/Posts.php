<?php

namespace App\Models;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class Posts {


	public static function all() {

	}

	public static function findBySlug( $slug ) {

		if ( ! file_exists( $path = ( resource_path() . '/views/static_html/' . $slug . '.html' ) ) ) {
//			ddd( $path );
			throw new ModelNotFoundException( 'not found ' . $path );
		}

		//cache 10 seconds, return the cache content if not expired.
		try {
			$cache = cache()->remember( "posts.{$slug}", 10, function () use ( $path ) {
				return file_get_contents( $path );
			} );
		} catch ( \Exception $exception ) {
			ddd( $exception->getMessage() );
		}

		return $cache;


	}

}
