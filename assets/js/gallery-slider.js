/**
 * Enhances the editable core Gallery block with a local Swiper slider.
 */
import Swiper from '../vendor/swiper/swiper.min.mjs';
import Navigation from '../vendor/swiper/modules/navigation.min.mjs';
import Keyboard from '../vendor/swiper/modules/keyboard.min.mjs';
import A11y from '../vendor/swiper/modules/a11y.min.mjs';
import Autoplay from '../vendor/swiper/modules/autoplay.min.mjs';

( () => {
	'use strict';

	const gallerySelector = '.villa-antares-gallery';
	const reducedMotionQuery = window.matchMedia(
		'(prefers-reduced-motion: reduce)'
	);
	const __ = window.wp?.i18n?.__ ?? ( ( text ) => text );

	/**
	 * Creates an accessible gallery navigation button.
	 *
	 * @param {string} direction Navigation direction.
	 * @param {string} label     Accessible label.
	 * @return {HTMLButtonElement} Navigation button.
	 */
	const createArrow = ( direction, label ) => {
		const button = document.createElement( 'button' );
		const icon = document.createElementNS(
			'http://www.w3.org/2000/svg',
			'svg'
		);
		const path = document.createElementNS(
			'http://www.w3.org/2000/svg',
			'path'
		);
		const isPrevious = direction === 'previous';

		button.type = 'button';
		button.className = [
			'villa-antares-gallery__arrow',
			`villa-antares-gallery__arrow--${ direction }`,
		].join( ' ' );
		button.setAttribute( 'aria-label', label );

		icon.setAttribute( 'viewBox', '0 0 24 24' );
		icon.setAttribute( 'aria-hidden', 'true' );
		icon.setAttribute( 'focusable', 'false' );
		path.setAttribute(
			'd',
			isPrevious ? 'M15 5l-7 7 7 7' : 'M9 5l7 7-7 7'
		);

		icon.append( path );
		button.append( icon );

		return button;
	};

	/**
	 * Initializes a single gallery when its expected core block markup exists.
	 *
	 * @param {HTMLElement} gallery Gallery section.
	 * @return {void}
	 */
	const initializeGallery = ( gallery ) => {
		if ( gallery.dataset.galleryInitialized === 'true' ) {
			return;
		}

		const galleryBlock = Array.from( gallery.children ).find( ( child ) =>
			child.classList.contains( 'wp-block-gallery' )
		);

		if ( ! galleryBlock ) {
			return;
		}

		const slides = Array.from( galleryBlock.children ).filter( ( child ) =>
			child.classList.contains( 'wp-block-image' )
		);

		if ( slides.length === 0 ) {
			return;
		}

		const previousButton = createArrow(
			'previous',
			__( 'Previous gallery image', 'villa-antares' )
		);
		const nextButton = createArrow(
			'next',
			__( 'Next gallery image', 'villa-antares' )
		);
		const autoplayEnabled =
			slides.length > 1 && ! reducedMotionQuery.matches;

		gallery.classList.add( 'swiper' );
		galleryBlock.classList.add( 'swiper-wrapper' );
		slides.forEach( ( slide ) => slide.classList.add( 'swiper-slide' ) );
		gallery.append( previousButton, nextButton );

		const slider = new Swiper( gallery, {
			a11y: {
				enabled: true,
				firstSlideMessage: __(
					'This is the first gallery image',
					'villa-antares'
				),
				lastSlideMessage: __(
					'This is the last gallery image',
					'villa-antares'
				),
				nextSlideMessage: __(
					'Next gallery image',
					'villa-antares'
				),
				prevSlideMessage: __(
					'Previous gallery image',
					'villa-antares'
				),
			},
			autoplay: {
				delay: 6000,
				disableOnInteraction: true,
				enabled: autoplayEnabled,
				stopOnLastSlide: false,
				waitForTransition: true,
			},
			keyboard: {
				enabled: true,
				onlyInViewport: true,
				pageUpDown: false,
			},
			loop: false,
			modules: [ Navigation, Keyboard, A11y, Autoplay ],
			navigation: {
				disabledClass: 'is-disabled',
				nextEl: nextButton,
				prevEl: previousButton,
			},
			rewind: true,
			slidesPerView: 1,
			spaceBetween: 0,
			speed: reducedMotionQuery.matches ? 0 : 550,
			watchOverflow: true,
		} );

		reducedMotionQuery.addEventListener( 'change', ( event ) => {
			if ( event.matches && slider.autoplay.running ) {
				slider.autoplay.stop();
			}
		} );

		gallery.dataset.galleryInitialized = 'true';
	};

	document.querySelectorAll( gallerySelector ).forEach( initializeGallery );
} )();
