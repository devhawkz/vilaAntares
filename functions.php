<?php
/**
 * Vila Antares Child Theme — functions and definitions
 *
 * @package Vila_Antares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Učitava stylesheet child teme.
 *
 * Blocksy parent tema već učitava svoje stilove; ovde se dodaje
 * child style.css koji se primenjuje posle parent stilova.
 *
 * @see https://creativethemes.com/blocksy/docs/general/child-theme/
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'blocksy-child-style',
			get_stylesheet_uri(),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	},
	15
);
