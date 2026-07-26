<?php
/**
 * Child theme setup.
 *
 * @package Vila_Antares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the child theme translation directory.
 *
 * Blocksy already provides the theme supports required by this foundation.
 *
 * @return void
 */
function villa_antares_setup() {
	load_child_theme_textdomain(
		'vila-antares',
		get_stylesheet_directory() . '/languages'
	);
}
add_action( 'after_setup_theme', 'villa_antares_setup', 20 );
