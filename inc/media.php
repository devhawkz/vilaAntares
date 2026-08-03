<?php
/**
 * Responsive image delivery helpers.
 *
 * Caps delivered widths so mobile clients never fetch multi‑megapixel
 * originals as the default `src` / srcset candidate.
 *
 * @package Vila_Antares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Maximum intrinsic width allowed in srcset / rewritten src.
 *
 * @param bool $is_gallery Whether the image belongs to the villa gallery.
 * @return int
 */
function villa_antares_get_max_image_width( $is_gallery = false ) {
	// Gallery is full-bleed; editorial images are ~61vw on desktop.
	// Both stay far below multi‑megapixel camera originals that break mobile.
	return 2048;
}

/**
 * Caps WordPress core srcset generation.
 *
 * @return int
 */
function villa_antares_filter_max_srcset_image_width() {
	return villa_antares_get_max_image_width( false );
}
add_filter( 'max_srcset_image_width', 'villa_antares_filter_max_srcset_image_width' );

/**
 * Returns absolute filesystem path for an uploads-relative file.
 *
 * @param string $relative Relative path under uploads, e.g. 2026/07/file.webp.
 * @return string
 */
function villa_antares_get_uploads_path( $relative ) {
	$uploads = wp_get_upload_dir();

	if ( empty( $uploads['basedir'] ) ) {
		return '';
	}

	return trailingslashit( $uploads['basedir'] ) . ltrim( $relative, '/' );
}

/**
 * Strips WordPress size / scaled suffixes from a filename stem.
 *
 * @param string $stem Filename without extension.
 * @return string
 */
function villa_antares_normalize_image_stem( $stem ) {
	$stem = preg_replace( '/-scaled$/', '', $stem );
	$stem = preg_replace( '/-\d+x\d+$/', '', $stem );

	return is_string( $stem ) ? $stem : '';
}

/**
 * Collects on-disk width candidates for an image stem.
 *
 * @param string $dir_url  Uploads directory URL for the file.
 * @param string $dir_path Uploads directory path for the file.
 * @param string $basename Current basename from the img src.
 * @param int    $max_width Maximum width to include.
 * @return array<int, string> Map of width => absolute URL.
 */
function villa_antares_collect_image_candidates( $dir_url, $dir_path, $basename, $max_width ) {
	$candidates = array();
	$ext        = strtolower( pathinfo( $basename, PATHINFO_EXTENSION ) );
	$raw_stem   = preg_replace( '/\.[^.]+$/', '', $basename );
	$stem       = villa_antares_normalize_image_stem( $raw_stem );

	if ( ! $stem || ! $ext ) {
		return $candidates;
	}

	$dir_url  = trailingslashit( $dir_url );
	$dir_path = trailingslashit( $dir_path );
	$widths   = array( 300, 768, 1024, 1536, 2048 );

	foreach ( $widths as $width ) {
		if ( $width > $max_width ) {
			continue;
		}

		$matched = '';
		$pattern = $dir_path . $stem . '-' . $width . 'x*.' . $ext;
		$found   = glob( $pattern );

		if ( ! empty( $found[0] ) ) {
			// Prefer the largest height variant for this width if multiple exist.
			usort(
				$found,
				static function ( $a, $b ) {
					return filesize( $b ) <=> filesize( $a );
				}
			);
			$matched = basename( $found[0] );
		}

		// Also accept -scaled-{w}x{h} siblings.
		if ( ! $matched ) {
			$scaled_pattern = $dir_path . $stem . '-scaled-' . $width . 'x*.' . $ext;
			$scaled_found   = glob( $scaled_pattern );
			if ( ! empty( $scaled_found[0] ) ) {
				$matched = basename( $scaled_found[0] );
			}
		}

		if ( $matched ) {
			$candidates[ $width ] = $dir_url . $matched;
		}
	}

	// Prefer a -scaled full file when present and within the cap.
	$scaled_basename = $stem . '-scaled.' . $ext;
	$scaled_path     = $dir_path . $scaled_basename;
	if ( is_file( $scaled_path ) ) {
		$size = @getimagesize( $scaled_path );
		if ( is_array( $size ) && ! empty( $size[0] ) ) {
			$width = (int) $size[0];
			if ( $width <= $max_width ) {
				$candidates[ $width ] = $dir_url . $scaled_basename;
			}
		}
	}

	// Include the original only when it is already within the cap.
	$original_basename = $stem . '.' . $ext;
	$original_path     = $dir_path . $original_basename;
	if ( is_file( $original_path ) ) {
		$size = @getimagesize( $original_path );
		if ( is_array( $size ) && ! empty( $size[0] ) ) {
			$width = (int) $size[0];
			if ( $width <= $max_width ) {
				$candidates[ $width ] = $dir_url . $original_basename;
			}
		}
	}

	// Keep the current src as a candidate when it is already a capped size file.
	$current_path = $dir_path . $basename;
	if ( is_file( $current_path ) ) {
		$size = @getimagesize( $current_path );
		if ( is_array( $size ) && ! empty( $size[0] ) ) {
			$width = (int) $size[0];
			if ( $width <= $max_width ) {
				$candidates[ $width ] = $dir_url . $basename;
			}
		}
	}

	ksort( $candidates, SORT_NUMERIC );

	return $candidates;
}

/**
 * Builds a srcset string from a width => URL map.
 *
 * @param array<int, string> $candidates Candidates.
 * @return string
 */
function villa_antares_format_srcset( $candidates ) {
	if ( empty( $candidates ) ) {
		return '';
	}

	$parts = array();
	foreach ( $candidates as $width => $url ) {
		$parts[] = $url . ' ' . (int) $width . 'w';
	}

	return implode( ', ', $parts );
}

/**
 * Picks the best candidate URL at or below a target width.
 *
 * @param array<int, string> $candidates Candidates.
 * @param int                $target     Preferred max width.
 * @return string
 */
function villa_antares_pick_candidate_url( $candidates, $target ) {
	if ( empty( $candidates ) ) {
		return '';
	}

	$chosen_width = 0;
	foreach ( array_keys( $candidates ) as $width ) {
		if ( $width <= $target ) {
			$chosen_width = $width;
		}
	}

	if ( ! $chosen_width ) {
		$chosen_width = (int) array_key_first( $candidates );
	}

	return $candidates[ $chosen_width ];
}

/**
 * Replaces or inserts an HTML attribute on a tag.
 *
 * @param string $tag   HTML tag.
 * @param string $attr  Attribute name.
 * @param string $value Attribute value.
 * @return string
 */
function villa_antares_set_img_attribute( $tag, $attr, $value ) {
	$pattern = '/\s' . preg_quote( $attr, '/' ) . '=["\'][^"\']*["\']/i';

	if ( preg_match( $pattern, $tag ) ) {
		return preg_replace(
			$pattern,
			' ' . $attr . '="' . esc_attr( $value ) . '"',
			$tag,
			1
		);
	}

	return preg_replace(
		'/<img\b/i',
		'<img ' . $attr . '="' . esc_attr( $value ) . '"',
		$tag,
		1
	);
}

/**
 * Adds responsive srcset/sizes and loading hints to content images.
 *
 * @param string $content Post content HTML.
 * @return string
 */
function villa_antares_optimize_content_images( $content ) {
	if ( ! is_string( $content ) || '' === $content || false === strpos( $content, '<img' ) ) {
		return $content;
	}

	$uploads = wp_get_upload_dir();
	if ( empty( $uploads['baseurl'] ) || empty( $uploads['basedir'] ) ) {
		return $content;
	}

	return preg_replace_callback(
		'/<img\b[^>]*>/i',
		static function ( $matches ) use ( $uploads ) {
			$tag = $matches[0];

			if ( ! preg_match( '/\ssrc=["\']([^"\']+)["\']/i', $tag, $src_match ) ) {
				return $tag;
			}

			$src = $src_match[1];
			if ( false === strpos( $src, '/uploads/' ) ) {
				return $tag;
			}

			$path_part = wp_parse_url( $src, PHP_URL_PATH );
			if ( ! is_string( $path_part ) ) {
				return $tag;
			}

			$marker = '/uploads/';
			$pos    = strpos( $path_part, $marker );
			if ( false === $pos ) {
				return $tag;
			}

			$relative = substr( $path_part, $pos + strlen( $marker ) );
			$basename = basename( $relative );
			$dir_rel  = trim( dirname( $relative ), '.' );
			$dir_url  = trailingslashit( $uploads['baseurl'] ) . ( '.' === $dir_rel ? '' : trailingslashit( $dir_rel ) );
			$dir_path = trailingslashit( $uploads['basedir'] ) . ( '.' === $dir_rel ? '' : trailingslashit( $dir_rel ) );

			$is_gallery = false !== strpos( $basename, 'villa-antares-gallery-' )
				|| false !== strpos( $tag, 'villa-antares-gallery' );
			$max_width  = villa_antares_get_max_image_width( $is_gallery );
			$candidates = villa_antares_collect_image_candidates(
				$dir_url,
				$dir_path,
				$basename,
				$max_width
			);

			if ( empty( $candidates ) ) {
				return $tag;
			}

			$srcset = villa_antares_format_srcset( $candidates );
			$tag    = villa_antares_set_img_attribute( $tag, 'srcset', $srcset );

			// Never leave a multi‑megapixel original as the default src.
			$safe_src = villa_antares_pick_candidate_url( $candidates, $max_width );
			if ( $safe_src ) {
				$tag = villa_antares_set_img_attribute( $tag, 'src', $safe_src );
			}

			$sizes = $is_gallery
				? '100vw'
				: '(min-width: 64rem) 61vw, calc(100vw - 2.5rem)';
			$tag   = villa_antares_set_img_attribute( $tag, 'sizes', $sizes );
			$tag   = villa_antares_set_img_attribute( $tag, 'decoding', 'async' );

			// Gallery loading strategy is owned by render_block filter.
			if ( ! $is_gallery && false === stripos( $tag, 'loading=' ) ) {
				$tag = villa_antares_set_img_attribute( $tag, 'loading', 'lazy' );
			}

			return $tag;
		},
		$content
	);
}
add_filter( 'the_content', 'villa_antares_optimize_content_images', 20 );

/**
 * Caps attachment images rendered outside the_content (e.g. Introduction).
 *
 * @param array|false  $image         Image data from wp_get_attachment_image_src.
 * @param int          $attachment_id Attachment ID.
 * @param string|int[] $size          Requested size.
 * @return array|false
 */
function villa_antares_cap_attachment_image_src( $image, $attachment_id, $size ) {
	static $busy = false;

	if ( $busy || ! is_array( $image ) || empty( $image[0] ) || empty( $image[1] ) ) {
		return $image;
	}

	$max_width = villa_antares_get_max_image_width( false );
	if ( (int) $image[1] <= $max_width ) {
		return $image;
	}

	$busy = true;

	// Prefer WordPress intermediate sizes already registered for this attachment.
	foreach ( array( '1536x1536', 'large', 'medium_large' ) as $fallback_size ) {
		$fallback = wp_get_attachment_image_src( $attachment_id, $fallback_size );
		if (
			is_array( $fallback )
			&& ! empty( $fallback[0] )
			&& ! empty( $fallback[1] )
			&& (int) $fallback[1] <= $max_width
		) {
			$busy = false;
			return $fallback;
		}
	}

	$uploads = wp_get_upload_dir();
	$path    = wp_parse_url( $image[0], PHP_URL_PATH );
	if ( ! is_string( $path ) || false === strpos( $path, '/uploads/' ) ) {
		$busy = false;
		return $image;
	}

	$marker   = '/uploads/';
	$pos      = strpos( $path, $marker );
	$relative = substr( $path, $pos + strlen( $marker ) );
	$basename = basename( $relative );
	$dir_rel  = trim( dirname( $relative ), '.' );
	$dir_url  = trailingslashit( $uploads['baseurl'] ) . ( '.' === $dir_rel ? '' : trailingslashit( $dir_rel ) );
	$dir_path = trailingslashit( $uploads['basedir'] ) . ( '.' === $dir_rel ? '' : trailingslashit( $dir_rel ) );

	$candidates = villa_antares_collect_image_candidates(
		$dir_url,
		$dir_path,
		$basename,
		$max_width
	);
	$url        = villa_antares_pick_candidate_url( $candidates, $max_width );

	if ( ! $url ) {
		$busy = false;
		return $image;
	}

	$width = (int) array_key_last( $candidates );
	foreach ( array_keys( $candidates ) as $candidate_width ) {
		if ( $candidates[ $candidate_width ] === $url ) {
			$width = (int) $candidate_width;
			break;
		}
	}

	$original_width = (int) $image[1];
	$image[0]       = $url;
	$image[1]       = $width;
	if ( ! empty( $image[2] ) && $original_width > 0 ) {
		$image[2] = (int) round( (int) $image[2] * ( $width / $original_width ) );
	}

	$busy = false;

	return $image;
}
add_filter( 'wp_get_attachment_image_src', 'villa_antares_cap_attachment_image_src', 20, 3 );

/**
 * Marks gallery images: first eager, rest lazy; force sizes=100vw.
 *
 * @param string $block_content Rendered block HTML.
 * @param array  $block         Parsed block.
 * @return string
 */
function villa_antares_optimize_gallery_block_images( $block_content, $block ) {
	if ( empty( $block['blockName'] ) || 'core/gallery' !== $block['blockName'] ) {
		return $block_content;
	}

	if ( false === strpos( $block_content, 'villa-antares-gallery' )
		&& false === strpos( $block_content, 'wp-block-gallery' )
	) {
		return $block_content;
	}

	$index = 0;

	return preg_replace_callback(
		'/<img\b[^>]*>/i',
		static function ( $matches ) use ( &$index ) {
			$tag = $matches[0];
			++$index;

			$loading = ( 1 === $index ) ? 'eager' : 'lazy';
			$fetch   = ( 1 === $index ) ? 'high' : 'auto';

			$tag = villa_antares_set_img_attribute( $tag, 'loading', $loading );
			$tag = villa_antares_set_img_attribute( $tag, 'sizes', '100vw' );

			if ( 1 === $index ) {
				$tag = villa_antares_set_img_attribute( $tag, 'fetchpriority', $fetch );
			}

			return $tag;
		},
		$block_content
	);
}
add_filter( 'render_block', 'villa_antares_optimize_gallery_block_images', 20, 2 );
