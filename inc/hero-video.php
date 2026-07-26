<?php
/**
 * Fullscreen Hero Video block registration and media helpers.
 *
 * @package Vila_Antares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolves a validated attachment URL.
 *
 * @param mixed         $attachment_id Attachment ID supplied by block attributes.
 * @param array<string> $allowed_mimes Allowed MIME types.
 * @return string
 */
function villa_antares_get_valid_attachment_url( $attachment_id, $allowed_mimes ) {
	$attachment_id = absint( $attachment_id );

	if (
		! $attachment_id
		|| 'attachment' !== get_post_type( $attachment_id )
		|| ! in_array( get_post_mime_type( $attachment_id ), $allowed_mimes, true )
	) {
		return '';
	}

	$attachment_url = wp_get_attachment_url( $attachment_id );

	return is_string( $attachment_url ) ? $attachment_url : '';
}

/**
 * Returns validated image dimensions with a safe fallback.
 *
 * @param mixed $attachment_id Attachment ID supplied by block attributes.
 * @param int   $fallback_width Fallback width.
 * @param int   $fallback_height Fallback height.
 * @return array{width: int, height: int}
 */
function villa_antares_get_attachment_dimensions(
	$attachment_id,
	$fallback_width,
	$fallback_height
) {
	$metadata = wp_get_attachment_metadata( absint( $attachment_id ) );
	$width    = is_array( $metadata ) && isset( $metadata['width'] )
		? absint( $metadata['width'] )
		: 0;
	$height   = is_array( $metadata ) && isset( $metadata['height'] )
		? absint( $metadata['height'] )
		: 0;

	return array(
		'width'  => $width ? $width : $fallback_width,
		'height' => $height ? $height : $fallback_height,
	);
}

/**
 * Registers the metadata-driven dynamic Hero Video block.
 *
 * @return void
 */
function villa_antares_register_hero_video_block() {
	$block_path = get_stylesheet_directory() . '/blocks/hero-video';

	if ( file_exists( $block_path . '/block.json' ) ) {
		register_block_type( $block_path );
	}
}
add_action( 'init', 'villa_antares_register_hero_video_block', 20 );
