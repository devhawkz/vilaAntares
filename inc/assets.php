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
 * Returns a cache-safe local asset version.
 *
 * @param string $relative_path Path relative to the child theme directory.
 * @return string
 */
function villa_antares_get_asset_version( $relative_path ) {
	$asset_path = get_stylesheet_directory() . '/' . ltrim( $relative_path, '/' );

	if ( file_exists( $asset_path ) ) {
		$modified_time = filemtime( $asset_path );

		if ( false !== $modified_time ) {
			return (string) $modified_time;
		}
	}

	return (string) wp_get_theme()->get( 'Version' );
}

/**
 * Registers child theme styles and scripts.
 *
 * @return void
 */
function villa_antares_register_assets() {
	$swiper_style_path = get_stylesheet_directory()
		. '/assets/vendor/swiper/swiper.min.css';

	if ( file_exists( $swiper_style_path ) ) {
		wp_register_style(
			'villa-antares-swiper',
			get_stylesheet_directory_uri()
				. '/assets/vendor/swiper/swiper.min.css',
			array(),
			'14.0.6'
		);
	}

	if ( file_exists( get_stylesheet_directory() . '/assets/css/site.css' ) ) {
		wp_register_style(
			'villa-antares-site',
			get_stylesheet_directory_uri() . '/assets/css/site.css',
			array(),
			villa_antares_get_asset_version( 'assets/css/site.css' )
		);
	}

	$header_script_path = get_stylesheet_directory() . '/assets/js/header-menu.js';

	if ( file_exists( $header_script_path ) ) {
		wp_register_script(
			'villa-antares-header-menu',
			get_stylesheet_directory_uri() . '/assets/js/header-menu.js',
			array(),
			villa_antares_get_asset_version( 'assets/js/header-menu.js' ),
			true
		);
		wp_script_add_data( 'villa-antares-header-menu', 'strategy', 'defer' );
	}

	$hero_script_path = get_stylesheet_directory() . '/assets/js/hero-video.js';

	if ( file_exists( $hero_script_path ) ) {
		wp_register_script(
			'villa-antares-hero-video',
			get_stylesheet_directory_uri() . '/assets/js/hero-video.js',
			array(),
			villa_antares_get_asset_version( 'assets/js/hero-video.js' ),
			true
		);
		wp_script_add_data( 'villa-antares-hero-video', 'strategy', 'defer' );
	}

	$gallery_script_path = get_stylesheet_directory()
		. '/assets/js/gallery-slider.js';

	if (
		file_exists( $gallery_script_path )
		&& function_exists( 'wp_register_script_module' )
	) {
		wp_register_script_module(
			'villa-antares-gallery-slider',
			get_stylesheet_directory_uri()
				. '/assets/js/gallery-slider.js',
			array(),
			villa_antares_get_asset_version( 'assets/js/gallery-slider.js' ),
			array( 'in_footer' => true )
		);
	}

	$editor_script_path = get_stylesheet_directory() . '/blocks/hero-video/index.js';

	if ( file_exists( $editor_script_path ) ) {
		wp_register_script(
			'villa-antares-hero-video-editor',
			get_stylesheet_directory_uri() . '/blocks/hero-video/index.js',
			array(
				'wp-block-editor',
				'wp-blocks',
				'wp-components',
				'wp-core-data',
				'wp-data',
				'wp-element',
				'wp-i18n',
			),
			villa_antares_get_asset_version( 'blocks/hero-video/index.js' ),
			true
		);
	}

	$introduction_editor_script_path = get_stylesheet_directory()
		. '/blocks/introduction/index.js';

	if ( file_exists( $introduction_editor_script_path ) ) {
		wp_register_script(
			'villa-antares-introduction-editor',
			get_stylesheet_directory_uri() . '/blocks/introduction/index.js',
			array(
				'wp-block-editor',
				'wp-blocks',
				'wp-components',
				'wp-core-data',
				'wp-data',
				'wp-element',
				'wp-i18n',
			),
			villa_antares_get_asset_version(
				'blocks/introduction/index.js'
			),
			true
		);
	}
}
add_action( 'init', 'villa_antares_register_assets', 5 );

/**
 * Checks whether the current singular page contains the gallery slider.
 *
 * @return bool
 */
function villa_antares_has_gallery_slider() {
	if ( ! is_singular() ) {
		return false;
	}

	$current_post = get_queried_object();

	if ( ! $current_post instanceof WP_Post ) {
		return false;
	}

	return has_block( 'core/gallery', $current_post )
		&& false !== strpos(
			$current_post->post_content,
			'villa-antares-gallery'
		);
}

/**
 * Enqueues the child theme global frontend assets.
 *
 * The Hero view script is associated with its block metadata and is therefore
 * enqueued by WordPress only when the block is rendered.
 *
 * @return void
 */
function villa_antares_enqueue_assets() {
	$has_gallery_slider = villa_antares_has_gallery_slider();

	if (
		$has_gallery_slider
		&& wp_style_is( 'villa-antares-swiper', 'registered' )
	) {
		wp_enqueue_style( 'villa-antares-swiper' );
	}

	if ( wp_style_is( 'villa-antares-site', 'registered' ) ) {
		wp_enqueue_style( 'villa-antares-site' );
	}

	if ( wp_script_is( 'villa-antares-header-menu', 'registered' ) ) {
		wp_enqueue_script( 'villa-antares-header-menu' );
	}

	if (
		$has_gallery_slider
		&& function_exists( 'wp_enqueue_script_module' )
	) {
		if ( wp_script_is( 'wp-i18n', 'registered' ) ) {
			wp_enqueue_script( 'wp-i18n' );
		}

		wp_enqueue_script_module( 'villa-antares-gallery-slider' );
	}
}
add_action( 'wp_enqueue_scripts', 'villa_antares_enqueue_assets', 20 );
