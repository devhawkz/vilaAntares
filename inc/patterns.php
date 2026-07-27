<?php
/**
 * Gutenberg block patterns for Villa Antares.
 *
 * @package Vila_Antares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the editable About Villa Antares block pattern.
 *
 * Image blocks are intentionally empty: the site editor selects the original
 * supplied photographs and controls their attachment alt text in Gutenberg.
 *
 * @return string
 */
function villa_antares_get_about_pattern_content() {
	return <<<'BLOCKS'
<!-- wp:group {"tagName":"section","anchor":"about","className":"villa-antares-about","layout":{"type":"constrained"}} -->
<section id="about" class="wp-block-group villa-antares-about"><!-- wp:group {"className":"villa-antares-about__rows","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-about__rows">

<!-- wp:group {"className":"villa-antares-about__row villa-antares-about__row--image-first","layout":{"type":"default"}} -->
<div class="wp-block-group villa-antares-about__row villa-antares-about__row--image-first"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"villa-antares-about__media"} -->
<figure class="wp-block-image size-large villa-antares-about__media"></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"villa-antares-about__card","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-about__card"><!-- wp:heading {"level":2,"className":"villa-antares-about__title"} -->
<h2 class="wp-block-heading villa-antares-about__title">VILLA ANTARES —</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"villa-antares-about__subtitle"} -->
<p class="villa-antares-about__subtitle">Where the Adriatic meets timeless luxury</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Perched above the shimmering Adriatic coastline, nestled in the heart of the most prestigious part of Montenegro coast (Sveti Stefan-Miločer), embraced by centuries-old olive trees and surrounded by lush Mediterranean gardens, Villa Antares is not merely a residence-it is a world of its own.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-about__row villa-antares-about__row--text-first","layout":{"type":"default"}} -->
<div class="wp-block-group villa-antares-about__row villa-antares-about__row--text-first"><!-- wp:group {"className":"villa-antares-about__card","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-about__card"><!-- wp:paragraph -->
<p>Created without compromise and crafted over years with meticulous attention to detail, Villa Antares represents the rare convergence of timeless elegance, absolute privacy, and resort-level luxury. Every stone, every terrace, every garden path reflects a vision of refined living at the highest level.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"villa-antares-about__media"} -->
<figure class="wp-block-image size-large villa-antares-about__media"></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-about__row villa-antares-about__row--image-first","layout":{"type":"default"}} -->
<div class="wp-block-group villa-antares-about__row villa-antares-about__row--image-first"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"villa-antares-about__media"} -->
<figure class="wp-block-image size-large villa-antares-about__media"></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"villa-antares-about__card","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-about__card"><!-- wp:paragraph -->
<p>Set within an exclusive walled estate of approximately 1700 m², the property offers over 1000 m² of luxurious interior living space, seamlessly blending grandeur with warmth and sophistication.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-about__row villa-antares-about__row--text-first","layout":{"type":"default"}} -->
<div class="wp-block-group villa-antares-about__row villa-antares-about__row--text-first"><!-- wp:group {"className":"villa-antares-about__card","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-about__card"><!-- wp:heading {"level":3,"className":"villa-antares-about__heading"} -->
<h3 class="wp-block-heading villa-antares-about__heading">A Sanctuary of Privacy and Prestige</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Hidden behind elegant stone walls and mature Mediterranean landscaping, Villa Antares offers an extraordinary level of seclusion rarely found on the Adriatic coast.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Towering cypress trees, majestic palm trees, flowering gardens, and more than ten ancient olive trees—some over two centuries old—create the atmosphere of a private botanical retreat.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"villa-antares-about__media"} -->
<figure class="wp-block-image size-large villa-antares-about__media"></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-about__row villa-antares-about__row--image-first","layout":{"type":"default"}} -->
<div class="wp-block-group villa-antares-about__row villa-antares-about__row--image-first"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"villa-antares-about__media"} -->
<figure class="wp-block-image size-large villa-antares-about__media"></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"villa-antares-about__card","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-about__card"><!-- wp:paragraph -->
<p>As evening falls, carefully designed architectural lighting transforms the estate into a glowing Mediterranean sanctuary, where every pathway, terrace, and garden feature is beautifully illuminated.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-about__row villa-antares-about__row--text-first","layout":{"type":"default"}} -->
<div class="wp-block-group villa-antares-about__row villa-antares-about__row--text-first"><!-- wp:group {"className":"villa-antares-about__card","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-about__card"><!-- wp:heading {"level":3,"className":"villa-antares-about__heading"} -->
<h3 class="wp-block-heading villa-antares-about__heading">Resort-Style Living at Home</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Designed to rival the world’s finest boutique resorts, Villa Antares offers an exceptional collection of wellness and leisure amenities.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"villa-antares-about__media"} -->
<figure class="wp-block-image size-large villa-antares-about__media"></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-about__row villa-antares-about__row--image-first","layout":{"type":"default"}} -->
<div class="wp-block-group villa-antares-about__row villa-antares-about__row--image-first"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"villa-antares-about__media"} -->
<figure class="wp-block-image size-large villa-antares-about__media"></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"villa-antares-about__card","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-about__card"><!-- wp:paragraph -->
<p>Whether hosting guests or enjoying complete tranquility, every space has been designed to elevate everyday living into an experience of effortless luxury.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-about__row villa-antares-about__row--text-first","layout":{"type":"default"}} -->
<div class="wp-block-group villa-antares-about__row villa-antares-about__row--text-first"><!-- wp:group {"className":"villa-antares-about__card","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-about__card"><!-- wp:heading {"level":3,"className":"villa-antares-about__heading"} -->
<h3 class="wp-block-heading villa-antares-about__heading">Uncompromising Craftsmanship</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The estate showcases premium imported materials, including distinguished natural stone sourced from Verona and Croatia, while bespoke furnishings and outdoor collections were carefully selected from Italy’s most respected manufacturers.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Large panoramic windows frame breathtaking sea views, while rich hardwood floors, custom architectural detailing, and sophisticated interior finishes create an atmosphere of timeless refinement.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Every room is designed to maximize natural light, privacy, and the spectacular surrounding landscape.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"villa-antares-about__media"} -->
<figure class="wp-block-image size-large villa-antares-about__media"></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

</div>
<!-- /wp:group --></section>
<!-- /wp:group -->
BLOCKS;
}

/**
 * Registers the About pattern in the block inserter.
 *
 * @return void
 */
function villa_antares_register_patterns() {
	register_block_pattern(
		'villa-antares/about',
		array(
			'title'       => esc_html__( 'About Villa Antares', 'vila-antares' ),
			'description' => esc_html__( 'Eight editable editorial text and image rows for the About section.', 'vila-antares' ),
			'categories'  => array( 'featured' ),
			'content'     => villa_antares_get_about_pattern_content(),
		)
	);
}
add_action( 'init', 'villa_antares_register_patterns', 20 );
