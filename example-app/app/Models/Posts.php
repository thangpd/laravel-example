<?php

namespace App\Models;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Posts {

	public $title;
	public $desc;
	public $slug;
	public $date;
	public $body;

	public function __construct( $title, $desc, $slug, $date, $body ) {
		$this->title = $title;
		$this->desc  = $desc;
		$this->date  = $date;
		$this->slug  = $slug;
		$this->body  = $body;
	}

	/** Version 1.0 findBySlug and cache
	 *
	 */
	public static function findBySlug( $slug ) {

		if ( ! file_exists( $path = ( resource_path() . '/views/static_html/' . $slug . '.html' ) ) ) {
			throw new ModelNotFoundException( 'not found ' . $path );
		}

		//cache 10 seconds, return the cache content if not expired.
		try {
			$cache = cache()->remember( "posts.{$slug}", 10, function () use ( $path ) {
				$post = YamlFrontMatter::parseFile( $path );

				return new Posts(
					$post->title,
					$post->desc,
					$post->slug,
					$post->date,
					$post->body()
				);
			} );
		} catch ( \Exception $exception ) {
			ddd( $exception->getMessage() );
		}

		return $cache;
	}


	/**
	 * FindBySlug version 2.0 Find by query firstWhere From Collection.
	 *
	 * @param $slug
	 *
	 * @return mixed
	 */
	public function findBySlugFromCollection( $slug ) {
		$posts_collection = Posts::all();

		return $posts_collection->firstWhere( 'slug', '=', $slug );
	}


	public static function all() {

		//php artisan tinker
		// view
		// cache('posts.all')
		// forget
		// cache()->forget('posts.all');
		return cache()->rememberForever( 'posts.all', function () {
			return collect( File::files( resource_path( '/views/static_html' ) ) )
				->map( function ( $file ) {
					return YamlFrontMatter::parseFile( $file );
				} )
				->map( function ( $post ) {

					return new \App\Models\Posts(
						$post->title,
						$post->desc,
						$post->slug,
						$post->date,
						$post->body()
					);
					//sortby Date from collection
				} )->sortByDesc( 'date' );
		} );

	}

}
