<?php
/**
 * Server-rendered Fullscreen Hero Video block.
 *
 * @package Vila_Antares
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$desktop_video_id  = isset( $attributes['desktopVideoId'] )
	? absint( $attributes['desktopVideoId'] )
	: 0;
$mobile_video_id   = isset( $attributes['mobileVideoId'] )
	? absint( $attributes['mobileVideoId'] )
	: 0;
$desktop_poster_id = isset( $attributes['desktopPosterId'] )
	? absint( $attributes['desktopPosterId'] )
	: 0;
$mobile_poster_id  = isset( $attributes['mobilePosterId'] )
	? absint( $attributes['mobilePosterId'] )
	: 0;

$desktop_video_url = villa_antares_get_valid_attachment_url(
	$desktop_video_id,
	array( 'video/mp4' )
);
$mobile_video_url  = villa_antares_get_valid_attachment_url(
	$mobile_video_id,
	array( 'video/mp4' )
);
$desktop_poster_url = villa_antares_get_valid_attachment_url(
	$desktop_poster_id,
	array( 'image/webp' )
);
$mobile_poster_url = villa_antares_get_valid_attachment_url(
	$mobile_poster_id,
	array( 'image/webp' )
);

$title = isset( $attributes['accessibleTitle'] )
	? trim( wp_strip_all_tags( $attributes['accessibleTitle'] ) )
	: '';
$location = isset( $attributes['accessibleLocation'] )
	? trim( wp_strip_all_tags( $attributes['accessibleLocation'] ) )
	: '';
$tagline = isset( $attributes['accessibleTagline'] )
	? trim( wp_strip_all_tags( $attributes['accessibleTagline'] ) )
	: '';

$title = $title ? $title : __( 'Villa Antares', 'vila-antares' );
$location = $location ? $location : __( 'Montenegro', 'vila-antares' );
$tagline = $tagline
	? $tagline
	: __(
		'The luxury of space. The privilege of privacy. The beauty of the Adriatic.',
		'vila-antares'
	);
$video_accessible_label = sprintf(
	/* translators: %s: accessible property name. */
	__( '%s hero video', 'vila-antares' ),
	$title
);

$video_id = isset( $attributes['videoId'] )
	? sanitize_html_class( $attributes['videoId'] )
	: '';

if ( ! $video_id ) {
	$video_id = 'villa-antares-hero-video-' . substr(
		md5(
			implode(
				'-',
				array(
					(string) get_the_ID(),
					(string) $desktop_video_id,
					(string) $mobile_video_id,
				)
			)
		),
		0,
		12
	);
}

$desktop_dimensions = villa_antares_get_attachment_dimensions(
	$desktop_poster_id,
	1920,
	1080
);
$mobile_dimensions  = villa_antares_get_attachment_dimensions(
	$mobile_poster_id,
	720,
	1280
);
$has_all_media      = $desktop_video_url
	&& $mobile_video_url
	&& $desktop_poster_url
	&& $mobile_poster_url;

$wrapper_extra = array(
	'class' => 'villa-antares-hero',
);

if ( empty( $attributes['anchor'] ) ) {
	$wrapper_extra['id'] = 'home';
}

$wrapper_attributes = get_block_wrapper_attributes( $wrapper_extra );
?>
<section
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by get_block_wrapper_attributes(). ?>
	data-villa-antares-hero
	data-desktop-video="<?php echo esc_url( $desktop_video_url ); ?>"
	data-mobile-video="<?php echo esc_url( $mobile_video_url ); ?>"
	data-desktop-poster="<?php echo esc_url( $desktop_poster_url ); ?>"
	data-mobile-poster="<?php echo esc_url( $mobile_poster_url ); ?>"
>
	<?php if ( $desktop_poster_url && $mobile_poster_url ) : ?>
		<picture class="villa-antares-hero__poster" aria-hidden="true">
			<source
				media="(max-width: 689.98px) and (orientation: portrait)"
				srcset="<?php echo esc_url( $mobile_poster_url ); ?>"
				width="<?php echo esc_attr( (string) $mobile_dimensions['width'] ); ?>"
				height="<?php echo esc_attr( (string) $mobile_dimensions['height'] ); ?>"
			>
			<img
				src="<?php echo esc_url( $desktop_poster_url ); ?>"
				width="<?php echo esc_attr( (string) $desktop_dimensions['width'] ); ?>"
				height="<?php echo esc_attr( (string) $desktop_dimensions['height'] ); ?>"
				alt=""
				decoding="async"
				fetchpriority="high"
			>
		</picture>
	<?php endif; ?>

	<?php if ( $has_all_media ) : ?>
		<video
			id="<?php echo esc_attr( $video_id ); ?>"
			class="villa-antares-hero__video"
			data-villa-antares-hero-video
			aria-label="<?php echo esc_attr( $video_accessible_label ); ?>"
			autoplay
			muted
			loop
			playsinline
			preload="metadata"
		></video>
	<?php endif; ?>

	<div class="villa-antares-hero__copy">
		<h1 class="villa-antares-hero__title"><?php echo esc_html( $title ); ?></h1>
		<p class="villa-antares-hero__location"><?php echo esc_html( $location ); ?></p>
		<p class="villa-antares-hero__tagline"><?php echo esc_html( $tagline ); ?></p>
	</div>

	<?php if ( $has_all_media ) : ?>
		<div
			class="villa-antares-hero__controls"
			data-villa-antares-hero-controls
			role="group"
			aria-label="<?php echo esc_attr__( 'Hero controls', 'vila-antares' ); ?>"
			hidden
		>
			<div class="villa-antares-hero__media-controls">
				<button
					class="villa-antares-hero__control villa-antares-hero__control--play"
					type="button"
					data-villa-antares-play
					data-state="paused"
					data-play-label="<?php echo esc_attr__( 'Play video', 'vila-antares' ); ?>"
					data-pause-label="<?php echo esc_attr__( 'Pause video', 'vila-antares' ); ?>"
					aria-controls="<?php echo esc_attr( $video_id ); ?>"
					aria-label="<?php echo esc_attr__( 'Play video', 'vila-antares' ); ?>"
					aria-pressed="false"
				>
					<svg
						class="villa-antares-hero__icon"
						data-icon="play"
						viewBox="0 0 32 32"
						width="32"
						height="32"
						aria-hidden="true"
						focusable="false"
					>
						<path d="M11 7.5 25 16 11 24.5Z"></path>
					</svg>
					<svg
						class="villa-antares-hero__icon"
						data-icon="pause"
						viewBox="0 0 32 32"
						width="32"
						height="32"
						aria-hidden="true"
						focusable="false"
					>
						<path d="M10 8h4v16h-4zM18 8h4v16h-4z"></path>
					</svg>
				</button>

				<button
					class="villa-antares-hero__control villa-antares-hero__control--sound"
					type="button"
					data-villa-antares-sound
					data-state="muted"
					data-sound-on-label="<?php echo esc_attr__( 'Turn sound on', 'vila-antares' ); ?>"
					data-sound-off-label="<?php echo esc_attr__( 'Turn sound off', 'vila-antares' ); ?>"
					aria-controls="<?php echo esc_attr( $video_id ); ?>"
					aria-label="<?php echo esc_attr__( 'Turn sound on', 'vila-antares' ); ?>"
					aria-pressed="false"
				>
					<svg
						class="villa-antares-hero__icon"
						data-icon="muted"
						viewBox="0 0 32 32"
						width="32"
						height="32"
						aria-hidden="true"
						focusable="false"
					>
						<path d="M5 12h6l7-6v20l-7-6H5Z"></path>
						<path
							d="m22 12 6 8m0-8-6 8"
							fill="none"
							stroke="currentColor"
							stroke-linecap="round"
							stroke-width="2.5"
						></path>
					</svg>
					<svg
						class="villa-antares-hero__icon"
						data-icon="sound"
						viewBox="0 0 32 32"
						width="32"
						height="32"
						aria-hidden="true"
						focusable="false"
					>
						<path d="M5 12h6l7-6v20l-7-6H5Z"></path>
						<path
							d="M22 11.5a6.5 6.5 0 0 1 0 9M25.5 8a11 11 0 0 1 0 16"
							fill="none"
							stroke="currentColor"
							stroke-linecap="round"
							stroke-width="2.25"
						></path>
					</svg>
				</button>
			</div>

			<a
				class="villa-antares-hero__next"
				href="#introduction"
				data-villa-antares-next
				aria-label="<?php echo esc_attr__( 'Go to the next section', 'vila-antares' ); ?>"
			>
				<svg
					viewBox="0 0 56 32"
					width="56"
					height="32"
					fill="none"
					stroke="currentColor"
					stroke-linecap="square"
					stroke-linejoin="miter"
					stroke-width="4"
					aria-hidden="true"
					focusable="false"
				>
					<path d="m5 5 23 22L51 5"></path>
				</svg>
			</a>
		</div>

		<p class="villa-antares-hero__fallback" data-villa-antares-video-fallback hidden>
			<?php echo esc_html__( 'The video could not be played.', 'vila-antares' ); ?>
			<a href="<?php echo esc_url( $desktop_video_url ); ?>">
				<?php echo esc_html__( 'Open the video file', 'vila-antares' ); ?>
			</a>
		</p>
	<?php else : ?>
		<p class="villa-antares-hero__fallback">
			<?php echo esc_html__( 'Hero media is currently unavailable.', 'vila-antares' ); ?>
		</p>
	<?php endif; ?>

	<noscript>
		<p class="villa-antares-hero__fallback villa-antares-hero__fallback--noscript">
			<?php echo esc_html__( 'JavaScript is required for video controls.', 'vila-antares' ); ?>
			<?php if ( $desktop_video_url ) : ?>
				<a href="<?php echo esc_url( $desktop_video_url ); ?>">
					<?php echo esc_html__( 'Open the video file', 'vila-antares' ); ?>
				</a>
			<?php endif; ?>
		</p>
	</noscript>
</section>
