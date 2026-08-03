<?php
/**
 * Server-rendered Introduction block.
 *
 * @package Vila_Antares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section_number = isset( $attributes['sectionNumber'] )
	? trim( wp_strip_all_tags( $attributes['sectionNumber'] ) )
	: '';
$eyebrow = isset( $attributes['eyebrow'] )
	? trim( wp_strip_all_tags( $attributes['eyebrow'] ) )
	: '';
$decorative_label = isset( $attributes['decorativeLabel'] )
	? trim( wp_strip_all_tags( $attributes['decorativeLabel'] ) )
	: '';
$title = isset( $attributes['title'] )
	? trim( wp_strip_all_tags( $attributes['title'] ) )
	: '';
$cta_text = isset( $attributes['ctaText'] )
	? trim( wp_strip_all_tags( $attributes['ctaText'] ) )
	: '';
$cta_url = isset( $attributes['ctaUrl'] )
	? esc_url_raw( trim( $attributes['ctaUrl'] ) )
	: '';

$section_number   = $section_number
	? $section_number
	: __( '01', 'vila-antares' );
$eyebrow          = $eyebrow
	? $eyebrow
	: __( 'Explore', 'vila-antares' );
$decorative_label = $decorative_label
	? $decorative_label
	: __( 'Villa Antares', 'vila-antares' );
$title             = $title
	? $title
	: __( 'VILLA ANTARES', 'vila-antares' );
$cta_text          = $cta_text
	? $cta_text
	: __( 'CONTACT US', 'vila-antares' );
$cta_url           = $cta_url ? $cta_url : '#contact';

$image_id = villa_antares_get_valid_introduction_image_id(
	isset( $attributes['imageId'] ) ? $attributes['imageId'] : 0
);
$alt_text = isset( $attributes['altText'] )
	? trim( wp_strip_all_tags( $attributes['altText'] ) )
	: '';

if ( $image_id && ! $alt_text ) {
	$alt_text = trim(
		wp_strip_all_tags(
			get_post_meta( $image_id, '_wp_attachment_image_alt', true )
		)
	);
}

$alt_text = $alt_text
	? $alt_text
	: __( 'Villa Antares overlooking the Adriatic Sea', 'vila-antares' );

$focal_point = isset( $attributes['focalPoint'] )
	&& is_array( $attributes['focalPoint'] )
	? $attributes['focalPoint']
	: array();
$focal_x = isset( $focal_point['x'] ) && is_numeric( $focal_point['x'] )
	? (float) $focal_point['x']
	: 0.5;
$focal_y = isset( $focal_point['y'] ) && is_numeric( $focal_point['y'] )
	? (float) $focal_point['y']
	: 0.5;
$focal_x = max( 0, min( 1, $focal_x ) );
$focal_y = max( 0, min( 1, $focal_y ) );
$focal_style = sprintf(
	'--villa-antares-introduction-focal-x: %.2f%%; --villa-antares-introduction-focal-y: %.2f%%;',
	$focal_x * 100,
	$focal_y * 100
);

$image_html = '';

if ( $image_id ) {
	$image_html = wp_get_attachment_image(
		$image_id,
		'1536x1536',
		false,
		array(
			'alt'           => $alt_text,
			'class'         => 'villa-antares-introduction__image',
			'decoding'      => 'async',
			'fetchpriority' => false,
			'loading'       => 'lazy',
			'sizes'         => '(min-width: 1536px) 760px, (min-width: 1280px) 52vw, calc(100vw - 40px)',
		)
	);
}

// Split off the first paragraph so mobile/tablet can place the image
// directly beneath it while desktop keeps the original overlap layout.
$content   = is_string( $content ) ? $content : '';
$lead_html = '';
$rest_html = $content;

if ( preg_match( '/^\s*<p\b[^>]*>.*?<\/p>/is', $content, $lead_match ) ) {
	$lead_html = $lead_match[0];
	$rest_html = substr( $content, strlen( $lead_match[0] ) );
}

$rest_html = trim( $rest_html );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'villa-antares-introduction',
		'id'    => 'introduction',
	)
);
?>
<section
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by get_block_wrapper_attributes(). ?>
	aria-labelledby="villa-antares-introduction-title"
>
	<div class="villa-antares-introduction__layout">
		<div class="villa-antares-introduction__text-top">
			
			<div class="villa-antares-introduction__marker">
				<span><?php echo esc_html( $section_number ); ?></span>
				<span
					class="villa-antares-introduction__marker-line"
					aria-hidden="true"
				></span>
				<span><?php echo esc_html( $eyebrow ); ?></span>
			</div>
			

			<h2
				id="villa-antares-introduction-title"
				class="villa-antares-introduction__title"
			><?php echo esc_html( $title ); ?></h2>

			<?php if ( $lead_html ) : ?>
				<div class="villa-antares-introduction__lead">
					<?php echo wp_kses_post( $lead_html ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $image_html ) : ?>
			<figure
				class="villa-antares-introduction__media"
				style="<?php echo esc_attr( $focal_style ); ?>"
			>
				<?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Generated and escaped by wp_get_attachment_image(). ?>
			</figure>
		<?php endif; ?>

		<div class="villa-antares-introduction__text-bottom">
			<?php if ( $rest_html ) : ?>
				<div class="villa-antares-introduction__body">
					<?php echo wp_kses_post( $rest_html ); ?>
				</div>
			<?php endif; ?>

			<a
				class="villa-antares-introduction__cta"
				href="<?php echo esc_url( $cta_url ); ?>"
			><?php echo esc_html( $cta_text ); ?></a>
		</div>
	</div>

	<div
		class="villa-antares-introduction__vertical-label"
		aria-hidden="true"
	>
		<span class="villa-antares-introduction__vertical-line"></span>
		<span><?php echo esc_html( $title ); ?></span>
	</div>
</section>
