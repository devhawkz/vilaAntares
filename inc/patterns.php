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
<div class="wp-block-group villa-antares-about__card"><!-- wp:paragraph {"className":"villa-antares-about__eyebrow"} -->
<p class="villa-antares-about__eyebrow"><span class="villa-antares-about__eyebrow-number">02</span><span class="villa-antares-about__eyebrow-line" aria-hidden="true"></span><span class="villa-antares-about__eyebrow-label">About</span></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"villa-antares-about__title"} -->
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
 * Returns the editable Sustainable Luxury block pattern.
 *
 * @return string
 */
function villa_antares_get_sustainability_pattern_content() {
	return <<<'BLOCKS'
<!-- wp:group {"tagName":"section","anchor":"sustainability","className":"villa-antares-sustainability","layout":{"type":"constrained"}} -->
<section id="sustainability" class="wp-block-group villa-antares-sustainability"><!-- wp:group {"className":"villa-antares-sustainability__inner","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-sustainability__inner"><!-- wp:paragraph {"className":"villa-antares-sustainability__eyebrow"} -->
<p class="villa-antares-sustainability__eyebrow"><span class="villa-antares-sustainability__eyebrow-number">03</span><span class="villa-antares-sustainability__eyebrow-line" aria-hidden="true"></span><span class="villa-antares-sustainability__eyebrow-label">Sustainable Luxury</span></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"villa-antares-sustainability__title"} -->
<h2 class="wp-block-heading villa-antares-sustainability__title">Sustainable Luxury</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"villa-antares-sustainability__intro"} -->
<p class="villa-antares-sustainability__intro">Beyond its beauty, Villa Antares offers exceptional self-sufficiency and modern infrastructure:</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"villa-antares-sustainability__list","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-sustainability__list">
<!-- wp:group {"className":"villa-antares-sustainability__item","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group villa-antares-sustainability__item"><!-- wp:paragraph {"className":"villa-antares-sustainability__number"} -->
<p class="villa-antares-sustainability__number">01</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Private spring water supply servicing the residence, swimming pools, and organic gardens</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-sustainability__item","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group villa-antares-sustainability__item"><!-- wp:paragraph {"className":"villa-antares-sustainability__number"} -->
<p class="villa-antares-sustainability__number">02</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Ecological vegetable garden</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-sustainability__item","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group villa-antares-sustainability__item"><!-- wp:paragraph {"className":"villa-antares-sustainability__number"} -->
<p class="villa-antares-sustainability__number">03</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Solar energy system</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-sustainability__item","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group villa-antares-sustainability__item"><!-- wp:paragraph {"className":"villa-antares-sustainability__number"} -->
<p class="villa-antares-sustainability__number">04</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Backup power generator</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-sustainability__item","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group villa-antares-sustainability__item"><!-- wp:paragraph {"className":"villa-antares-sustainability__number"} -->
<p class="villa-antares-sustainability__number">05</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Underfloor heating throughout the property</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-sustainability__item","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group villa-antares-sustainability__item"><!-- wp:paragraph {"className":"villa-antares-sustainability__number"} -->
<p class="villa-antares-sustainability__number">06</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Premium climate control systems</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-sustainability__item","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group villa-antares-sustainability__item"><!-- wp:paragraph {"className":"villa-antares-sustainability__number"} -->
<p class="villa-antares-sustainability__number">07</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Fireplaces creating warmth and ambiance throughout the seasons</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"villa-antares-sustainability__outro"} -->
<p class="villa-antares-sustainability__outro">This rare combination of sustainability and luxury ensures comfort, independence, and peace of mind throughout the year.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
BLOCKS;
}

/**
 * Returns the editable Features block pattern.
 *
 * @return string
 */
function villa_antares_get_features_pattern_content() {
	return <<<'BLOCKS'
<!-- wp:group {"tagName":"section","anchor":"features","className":"villa-antares-features","layout":{"type":"constrained"}} -->
<section id="features" class="wp-block-group villa-antares-features"><!-- wp:group {"className":"villa-antares-features__inner","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-features__inner"><!-- wp:paragraph {"className":"villa-antares-features__eyebrow"} -->
<p class="villa-antares-features__eyebrow"><span class="villa-antares-features__eyebrow-number">04</span><span class="villa-antares-features__eyebrow-line" aria-hidden="true"></span><span class="villa-antares-features__eyebrow-label">Features</span></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"villa-antares-features__title"} -->
<h2 class="wp-block-heading villa-antares-features__title">Features</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"villa-antares-features__categories","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-features__categories">
<!-- wp:group {"className":"villa-antares-features__category","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-features__category"><!-- wp:group {"className":"villa-antares-features__category-heading","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group villa-antares-features__category-heading"><!-- wp:paragraph {"className":"villa-antares-features__category-number"} -->
<p class="villa-antares-features__category-number">01</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"className":"villa-antares-features__category-title"} -->
<h3 class="wp-block-heading villa-antares-features__category-title">Indoor</h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->
<!-- wp:list {"className":"villa-antares-features__list"} -->
<ul class="wp-block-list villa-antares-features__list"><li>Air conditioning</li><li>Underfloor heating</li><li>Fireplace</li><li>Heated swimming pool with integrated hydrotherapy jet</li><li>Jacuzzi</li><li>Sauna</li><li>Massage suite</li><li>Gym</li><li>Laundry and ironing room</li><li>Dining room</li><li>Cable and smart TV</li><li>Stereo/sound system</li><li>Wi-Fi connection</li><li>Billiards table</li><li>Bar</li><li>Coffee machine</li></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-features__category","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-features__category"><!-- wp:group {"className":"villa-antares-features__category-heading","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group villa-antares-features__category-heading"><!-- wp:paragraph {"className":"villa-antares-features__category-number"} -->
<p class="villa-antares-features__category-number">02</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"className":"villa-antares-features__category-title"} -->
<h3 class="wp-block-heading villa-antares-features__category-title">Outdoor</h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->
<!-- wp:list {"className":"villa-antares-features__list"} -->
<ul class="wp-block-list villa-antares-features__list"><li>Heated infinity pool with two integrated hydrotherapy jets</li><li>Jacuzzi</li><li>Terrace</li><li>Bar</li><li>BBQ</li><li>Refrigerator</li><li>Coffee machine</li><li>Cable and smart TV</li><li>Stereo/sound system</li><li>Sun loungers and umbrellas</li><li>Two showers</li><li>Two toilets</li><li>Ecological vegetable garden with spring water supply</li><li>Fig, lemon, orange, mandarin, and pomegranate trees</li><li>More than ten olive trees, some over 200 years old</li><li>Eight private parking spaces</li><li>Gated property</li><li>Backup power generator</li></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-features__category","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-features__category"><!-- wp:group {"className":"villa-antares-features__category-heading","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group villa-antares-features__category-heading"><!-- wp:paragraph {"className":"villa-antares-features__category-number"} -->
<p class="villa-antares-features__category-number">03</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"className":"villa-antares-features__category-title"} -->
<h3 class="wp-block-heading villa-antares-features__category-title">Safety</h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->
<!-- wp:list {"className":"villa-antares-features__list"} -->
<ul class="wp-block-list villa-antares-features__list"><li>Security alarm system</li><li>Fire sensors</li><li>Automatic fire extinguisher</li><li>Safe</li><li>First aid kit</li></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->
</div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
BLOCKS;
}

/**
 * Returns the editable Location block pattern.
 *
 * @return string
 */
function villa_antares_get_location_pattern_content() {
	return <<<'BLOCKS'
<!-- wp:group {"tagName":"section","anchor":"location","className":"villa-antares-location","layout":{"type":"constrained"}} -->
<section id="location" class="wp-block-group villa-antares-location"><!-- wp:group {"className":"villa-antares-location__inner","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-location__inner"><!-- wp:paragraph {"className":"villa-antares-location__eyebrow"} -->
<p class="villa-antares-location__eyebrow"><span class="villa-antares-location__eyebrow-number">05</span><span class="villa-antares-location__eyebrow-line" aria-hidden="true"></span><span class="villa-antares-location__eyebrow-label">Location</span></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"villa-antares-location__title"} -->
<h2 class="wp-block-heading villa-antares-location__title">Location</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"villa-antares-location__intro"} -->
<p class="villa-antares-location__intro">Villa Antares is situated in the heart of one of the most prestigious parts of the Montenegrin coast, just 2 km from Sveti Stefan–Miločer, 300 m from Hotel Maestral Resort &amp; Casino, 26 km from Tivat Airport, 60 km from Podgorica Airport, and 70 km from Dubrovnik Airport.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"villa-antares-location__distances","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-location__distances">
<!-- wp:group {"className":"villa-antares-location__distance","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-location__distance"><!-- wp:paragraph {"className":"villa-antares-location__distance-value"} -->
<p class="villa-antares-location__distance-value">2 km</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"villa-antares-location__distance-label"} -->
<p class="villa-antares-location__distance-label">Sveti Stefan–Miločer</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-location__distance","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-location__distance"><!-- wp:paragraph {"className":"villa-antares-location__distance-value"} -->
<p class="villa-antares-location__distance-value">300 m</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"villa-antares-location__distance-label"} -->
<p class="villa-antares-location__distance-label">Hotel Maestral Resort &amp; Casino</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-location__distance","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-location__distance"><!-- wp:paragraph {"className":"villa-antares-location__distance-value"} -->
<p class="villa-antares-location__distance-value">26 km</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"villa-antares-location__distance-label"} -->
<p class="villa-antares-location__distance-label">Tivat Airport</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-location__distance","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-location__distance"><!-- wp:paragraph {"className":"villa-antares-location__distance-value"} -->
<p class="villa-antares-location__distance-value">60 km</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"villa-antares-location__distance-label"} -->
<p class="villa-antares-location__distance-label">Podgorica Airport</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"villa-antares-location__distance","layout":{"type":"constrained"}} -->
<div class="wp-block-group villa-antares-location__distance"><!-- wp:paragraph {"className":"villa-antares-location__distance-value"} -->
<p class="villa-antares-location__distance-value">70 km</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"villa-antares-location__distance-label"} -->
<p class="villa-antares-location__distance-label">Dubrovnik Airport</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<!-- /wp:group -->

</div></section>
<!-- /wp:group -->
BLOCKS;
}

/**
 * Gets the editable full-width map pattern content.
 *
 * @return string
 */
function villa_antares_get_map_pattern_content() {
	return <<<'BLOCKS'
<!-- wp:group {"tagName":"section","anchor":"map","className":"villa-antares-map","layout":{"type":"constrained"}} -->
<section id="map" class="wp-block-group villa-antares-map"><!-- wp:html -->
<div class="villa-antares-map__embed"><iframe title="Villa Antares location in Podličak, Budva" src="https://www.google.com/maps?output=embed&amp;q=VILLA%20ANTARES%2C%20Podli%C4%8Dak%20bb%2C%20Budva%2C%20Montenegro" width="600" height="450" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
<!-- /wp:html --></section>
<!-- /wp:group -->
BLOCKS;
}

/**
 * Registers the theme patterns in the block inserter.
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

	register_block_pattern(
		'villa-antares/sustainable-luxury',
		array(
			'title'       => esc_html__( 'Sustainable Luxury', 'vila-antares' ),
			'description' => esc_html__( 'Editable sustainable luxury editorial section with seven benefits.', 'vila-antares' ),
			'categories'  => array( 'featured' ),
			'content'     => villa_antares_get_sustainability_pattern_content(),
		)
	);

	register_block_pattern(
		'villa-antares/features',
		array(
			'title'       => esc_html__( 'Features', 'vila-antares' ),
			'description' => esc_html__( 'Editable Indoor, Outdoor, and Safety features section.', 'vila-antares' ),
			'categories'  => array( 'featured' ),
			'content'     => villa_antares_get_features_pattern_content(),
		)
	);

	register_block_pattern(
		'villa-antares/location',
		array(
			'title'       => esc_html__( 'Location', 'vila-antares' ),
			'description' => esc_html__( 'Editable location section with distances and address.', 'vila-antares' ),
			'categories'  => array( 'featured' ),
			'content'     => villa_antares_get_location_pattern_content(),
		)
	);

	register_block_pattern(
		'villa-antares/map',
		array(
			'title'       => esc_html__( 'Villa Antares Map', 'vila-antares' ),
			'description' => esc_html__( 'Editable full-width Villa Antares location map.', 'vila-antares' ),
			'categories'  => array( 'featured' ),
			'content'     => villa_antares_get_map_pattern_content(),
		)
	);
}
add_action( 'init', 'villa_antares_register_patterns', 20 );
