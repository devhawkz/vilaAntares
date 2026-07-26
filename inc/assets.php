<?php
/**
 * Frontend asset loading.
 *
 * @package Vila_Antares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues the child theme frontend stylesheet.
 *
 * @return void
 */
function villa_antares_enqueue_assets() {
	$stylesheet_path = get_stylesheet_directory() . '/assets/css/site.css';

	if ( ! file_exists( $stylesheet_path ) ) {
		return;
	}

	$asset_version = filemtime( $stylesheet_path );

	if ( false === $asset_version ) {
		$asset_version = wp_get_theme()->get( 'Version' );
	}

	wp_enqueue_style(
		'villa-antares-site',
		get_stylesheet_directory_uri() . '/assets/css/site.css',
		array(),
		(string) $asset_version
	);
}
add_action( 'wp_enqueue_scripts', 'villa_antares_enqueue_assets', 20 );
