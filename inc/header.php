<?php
/**
 * Blocksy Header Builder integration and fullscreen navigation markup.
 *
 * @package Vila_Antares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the social networks configured in the active Blocksy header section.
 *
 * @return array<int, array<string, mixed>>
 */
function villa_antares_get_header_socials_descriptor() {
	$header_placements = get_theme_mod( 'header_placements', array() );

	if (
		! is_array( $header_placements )
		|| empty( $header_placements['sections'] )
		|| ! is_array( $header_placements['sections'] )
	) {
		return array();
	}

	$current_section_id = isset( $header_placements['current_section'] )
		? sanitize_key( $header_placements['current_section'] )
		: '';

	foreach ( $header_placements['sections'] as $section ) {
		if ( ! is_array( $section ) ) {
			continue;
		}

		$section_id = isset( $section['id'] ) ? sanitize_key( $section['id'] ) : '';

		if ( $current_section_id && $section_id !== $current_section_id ) {
			continue;
		}

		if ( empty( $section['items'] ) || ! is_array( $section['items'] ) ) {
			continue;
		}

		foreach ( $section['items'] as $item ) {
			if ( empty( $item['id'] ) || ! is_string( $item['id'] ) ) {
				continue;
			}

			$original_id = explode( '~', $item['id'] )[0];

			if (
				'socials' === $original_id
				&& ! empty( $item['values']['header_socials'] )
				&& is_array( $item['values']['header_socials'] )
			) {
				return $item['values']['header_socials'];
			}
		}
	}

	return array();
}

/**
 * Keeps only enabled social networks with valid configured HTTP(S) URLs.
 *
 * @param array<int, array<string, mixed>> $descriptor Social network settings.
 * @return array<int, array<string, mixed>>
 */
function villa_antares_get_valid_socials( $descriptor ) {
	$valid_socials    = array();
	$allowed_networks = array( 'facebook', 'instagram' );

	foreach ( $descriptor as $network ) {
		if ( ! is_array( $network ) || empty( $network['id'] ) ) {
			continue;
		}

		$network_id = sanitize_key( $network['id'] );

		if (
			! in_array( $network_id, $allowed_networks, true )
			|| empty( $network['enabled'] )
		) {
			continue;
		}

		$profile_url = get_theme_mod( $network_id, '' );
		$url_scheme  = is_string( $profile_url )
			? wp_parse_url( $profile_url, PHP_URL_SCHEME )
			: '';

		if (
			! is_string( $profile_url )
			|| ! wp_http_validate_url( $profile_url )
			|| ! in_array( strtolower( (string) $url_scheme ), array( 'http', 'https' ), true )
		) {
			continue;
		}

		$valid_socials[] = array(
			'id'      => $network_id,
			'enabled' => true,
		);
	}

	return $valid_socials;
}

/**
 * Prevents Blocksy from rendering placeholder social links in the Header Builder.
 *
 * @param array<string, mixed> $args Blocksy header item template arguments.
 * @return array<string, mixed>
 */
function villa_antares_filter_header_socials( $args ) {
	if ( empty( $args['item_id'] ) || ! is_string( $args['item_id'] ) ) {
		return $args;
	}

	$original_id = explode( '~', $args['item_id'] )[0];

	if ( 'socials' !== $original_id ) {
		return $args;
	}

	$descriptor = array();

	if (
		isset( $args['atts']['header_socials'] )
		&& is_array( $args['atts']['header_socials'] )
	) {
		$descriptor = $args['atts']['header_socials'];
	}

	$args['atts']['header_socials'] = villa_antares_get_valid_socials( $descriptor );
	$args['atts']['link_target']    = 'yes';
	$args['atts']['link_nofollow']  = 'no';
	$args['attr']['role']           = 'group';
	$args['attr']['aria-label']     = esc_attr__(
		'Social media',
		'vila-antares'
	);

	return $args;
}
add_filter(
	'blocksy:header:item-template-args',
	'villa_antares_filter_header_socials',
	20
);

/**
 * Connects the Blocksy trigger element to the custom fullscreen navigation.
 *
 * @param string|null          $custom_content Filtered header markup, when supplied.
 * @param array<string, mixed> $rows           Rendered Blocksy Header Builder rows.
 * @param string               $device         Current Blocksy device context.
 * @return string
 */
function villa_antares_connect_header_trigger( $custom_content, $rows, $device ) {
	unset( $device );

	$header_markup = is_string( $custom_content )
		? $custom_content
		: implode( '', array_values( $rows ) );

	if ( ! class_exists( 'WP_HTML_Tag_Processor' ) ) {
		return $header_markup;
	}

	$processor = new WP_HTML_Tag_Processor( $header_markup );

	while (
		$processor->next_tag(
			array(
				'tag_name'  => 'BUTTON',
				'class_name' => 'ct-header-trigger',
			)
		)
	) {
		$processor->set_attribute( 'type', 'button' );
		$processor->set_attribute( 'data-villa-antares-menu-toggle', '' );
		$processor->set_attribute( 'aria-controls', 'villa-antares-navigation' );
		$processor->set_attribute( 'aria-expanded', 'false' );
		$processor->set_attribute(
			'aria-label',
			esc_attr__( 'Open navigation', 'vila-antares' )
		);
		$processor->remove_attribute( 'data-toggle-panel' );
		$processor->remove_class( 'ct-toggle' );
		$processor->add_class( 'villa-antares-menu-toggle' );
	}

	return $processor->get_updated_html();
}
add_filter(
	'blocksy:header:rows-render',
	'villa_antares_connect_header_trigger',
	20,
	3
);

/**
 * Renders the shared desktop and mobile fullscreen navigation panel.
 *
 * @return void
 */
function villa_antares_render_overlay_navigation() {
	$socials = villa_antares_get_valid_socials(
		villa_antares_get_header_socials_descriptor()
	);
	?>
	<div
		id="villa-antares-navigation"
		class="villa-antares-menu"
		data-villa-antares-menu
		data-villa-antares-motion
		data-open-label="<?php echo esc_attr__( 'Open navigation', 'vila-antares' ); ?>"
		data-close-label="<?php echo esc_attr__( 'Close navigation', 'vila-antares' ); ?>"
		role="dialog"
		aria-modal="true"
		aria-label="<?php echo esc_attr__( 'Site navigation', 'vila-antares' ); ?>"
		aria-hidden="true"
		inert
	>
		<div class="villa-antares-menu__scroll">
			<div class="villa-antares-menu__content villa-antares-container">
				<nav
					class="villa-antares-menu__navigation"
					aria-label="<?php echo esc_attr__( 'Primary navigation', 'vila-antares' ); ?>"
				>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'villa-antares-overlay',
							'container'      => false,
							'menu_class'     => 'villa-antares-menu__list',
							'menu_id'        => 'villa-antares-overlay-menu',
							'fallback_cb'    => false,
							'depth'          => 1,
						)
					);
					?>
				</nav>

				<?php if ( $socials && function_exists( 'blocksy_social_icons' ) ) : ?>
					<div
						class="villa-antares-menu__socials"
						role="group"
						aria-label="<?php echo esc_attr__( 'Social media', 'vila-antares' ); ?>"
					>
						<?php
						echo blocksy_social_icons( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Blocksy escapes its social markup.
							$socials,
							array(
								'type'          => 'simple',
								'icons-color'   => 'custom',
								'links_target'  => '_blank',
								'links_rel'     => 'noopener noreferrer',
								'label_visibility' => array(
									'desktop' => false,
									'tablet'  => false,
									'mobile'  => false,
								),
							)
						);
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}
add_action(
	'blocksy:header:after',
	'villa_antares_render_overlay_navigation',
	10
);
