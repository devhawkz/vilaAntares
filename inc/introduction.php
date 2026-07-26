<?php
/**
 * Introduction block registration and image validation.
 *
 * @package Vila_Antares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Confirms that a block attribute references a supported image attachment.
 *
 * @param mixed $attachment_id Attachment ID supplied by block attributes.
 * @return int
 */
function villa_antares_get_valid_introduction_image_id( $attachment_id ) {
	$attachment_id = absint( $attachment_id );
	$allowed_mimes = array(
		'image/avif',
		'image/jpeg',
		'image/png',
		'image/webp',
	);

	if (
		! $attachment_id
		|| 'attachment' !== get_post_type( $attachment_id )
		|| ! in_array(
			get_post_mime_type( $attachment_id ),
			$allowed_mimes,
			true
		)
		|| ! wp_attachment_is_image( $attachment_id )
	) {
		return 0;
	}

	return $attachment_id;
}

/**
 * Registers the metadata-driven dynamic Introduction block.
 *
 * @return void
 */
function villa_antares_register_introduction_block() {
	$block_path = get_stylesheet_directory() . '/blocks/introduction';

	if ( file_exists( $block_path . '/block.json' ) ) {
		register_block_type( $block_path );
	}
}
add_action( 'init', 'villa_antares_register_introduction_block', 20 );
