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
 * Enqueues the child theme frontend assets.
 *
 * @return void
 */
function villa_antares_enqueue_assets() {
	$stylesheet_path = get_stylesheet_directory() . '/assets/css/site.css';

	if ( file_exists( $stylesheet_path ) ) {
		$stylesheet_version = filemtime( $stylesheet_path );

		if ( false === $stylesheet_version ) {
			$stylesheet_version = wp_get_theme()->get( 'Version' );
		}

		wp_enqueue_style(
			'villa-antares-site',
			get_stylesheet_directory_uri() . '/assets/css/site.css',
			array(),
			(string) $stylesheet_version
		);
	}

	$header_script_path = get_stylesheet_directory() . '/assets/js/header-menu.js';

	if ( ! file_exists( $header_script_path ) ) {
		return;
	}

	$header_script_version = filemtime( $header_script_path );

	if ( false === $header_script_version ) {
		$header_script_version = wp_get_theme()->get( 'Version' );
	}

	wp_enqueue_script(
		'villa-antares-header-menu',
		get_stylesheet_directory_uri() . '/assets/js/header-menu.js',
		array(),
		(string) $header_script_version,
		true
	);
	wp_script_add_data( 'villa-antares-header-menu', 'strategy', 'defer' );
}
add_action( 'wp_enqueue_scripts', 'villa_antares_enqueue_assets', 20 );
