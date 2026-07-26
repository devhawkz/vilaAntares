(() => {
	'use strict';

	const panel = document.querySelector('[data-villa-antares-menu]');
	const toggles = Array.from(
		document.querySelectorAll('[data-villa-antares-menu-toggle]')
	);

	if (!panel || toggles.length === 0) {
		return;
	}

	const root = document.documentElement;
	const header = document.querySelector('#header');
	const openLabel = panel.dataset.openLabel || 'Open navigation';
	const closeLabel = panel.dataset.closeLabel || 'Close navigation';
	const focusableSelector = [
		'a[href]',
		'button:not([disabled])',
		'input:not([disabled])',
		'select:not([disabled])',
		'textarea:not([disabled])',
		'[tabindex]:not([tabindex="-1"])'
	].join(',');
	let activeTrigger = null;
	let isOpen = false;
	let scrollPosition = 0;

	const isVisible = (element) =>
		element.getClientRects().length > 0 &&
		window.getComputedStyle(element).visibility !== 'hidden';

	const setToggleState = (expanded) => {
		toggles.forEach((toggle) => {
			toggle.setAttribute('aria-expanded', String(expanded));
			toggle.setAttribute(
				'aria-label',
				expanded ? closeLabel : openLabel
			);
			toggle.removeAttribute('data-toggle-panel');
		});
	};

	const getFocusables = () => {
		const headerItems = header
			? Array.from(header.querySelectorAll(focusableSelector)).filter(
				isVisible
			)
			: toggles.filter(isVisible);
		const panelItems = Array.from(
			panel.querySelectorAll(focusableSelector)
		).filter(isVisible);

		return [...headerItems, ...panelItems];
	};

	const setBackgroundInert = (enabled) => {
		const parent = panel.parentElement;

		if (!parent) {
			return;
		}

		Array.from(parent.children).forEach((element) => {
			if (
				element === panel ||
				element.matches('#header, [data-header]')
			) {
				return;
			}

			if (enabled && !element.hasAttribute('inert')) {
				element.setAttribute('inert', '');
				element.setAttribute('data-villa-antares-inerted', '');
			} else if (
				!enabled &&
				element.hasAttribute('data-villa-antares-inerted')
			) {
				element.removeAttribute('inert');
				element.removeAttribute('data-villa-antares-inerted');
			}
		});
	};

	const lockPage = () => {
		scrollPosition = window.scrollY;
		root.style.setProperty(
			'--villa-antares-locked-scroll',
			`${scrollPosition}px`
		);
		root.classList.add('villa-antares-menu-open');
	};

	const unlockPage = () => {
		root.classList.remove('villa-antares-menu-open');
		root.style.removeProperty('--villa-antares-locked-scroll');
		window.scrollTo(0, scrollPosition);
	};

	const openMenu = (trigger) => {
		if (isOpen) {
			return;
		}

		isOpen = true;
		activeTrigger = trigger;
		panel.removeAttribute('inert');
		panel.setAttribute('aria-hidden', 'false');
		setToggleState(true);
		setBackgroundInert(true);
		lockPage();

		window.requestAnimationFrame(() => {
			if (!isOpen) {
				return;
			}

			const firstLink = panel.querySelector('a[href]');

			if (firstLink && isVisible(firstLink)) {
				firstLink.focus({ preventScroll: true });
			}
		});
	};

	const closeMenu = (restoreFocus = true) => {
		if (!isOpen) {
			return;
		}

		isOpen = false;
		panel.setAttribute('aria-hidden', 'true');
		panel.setAttribute('inert', '');
		setToggleState(false);
		setBackgroundInert(false);
		unlockPage();

		if (restoreFocus && activeTrigger && activeTrigger.isConnected) {
			activeTrigger.focus({ preventScroll: true });
		}
	};

	const updateCurrentLink = () => {
		const currentHash = window.location.hash || '#home';

		panel.querySelectorAll('a[href^="#"]').forEach((link) => {
			const isCurrent = link.getAttribute('href') === currentHash;

			if (isCurrent) {
				link.setAttribute('aria-current', 'location');
			} else {
				link.removeAttribute('aria-current');
			}
		});
	};

	toggles.forEach((toggle) => {
		toggle.setAttribute('type', 'button');
		toggle.setAttribute('aria-controls', panel.id);
		toggle.removeAttribute('data-toggle-panel');

		toggle.addEventListener('click', (event) => {
			event.preventDefault();
			event.stopPropagation();

			if (isOpen) {
				closeMenu();
			} else {
				openMenu(toggle);
			}
		});
	});

	panel.addEventListener('click', (event) => {
		const link = event.target.closest('a[href^="#"]');

		if (!link) {
			return;
		}

		const hash = link.getAttribute('href');

		if (!hash || hash === '#') {
			return;
		}

		event.preventDefault();
		closeMenu();

		if (window.location.hash !== hash) {
			window.history.pushState(null, '', hash);
		}

		const target = document.getElementById(hash.slice(1));

		if (target) {
			target.scrollIntoView();
		}

		updateCurrentLink();
	});

	document.addEventListener('keydown', (event) => {
		if (!isOpen) {
			return;
		}

		if (event.key === 'Escape') {
			event.preventDefault();
			closeMenu();
			return;
		}

		if (event.key !== 'Tab') {
			return;
		}

		const focusables = getFocusables();

		if (focusables.length === 0) {
			event.preventDefault();
			return;
		}

		const firstItem = focusables[0];
		const lastItem = focusables[focusables.length - 1];

		if (event.shiftKey && document.activeElement === firstItem) {
			event.preventDefault();
			lastItem.focus();
		} else if (
			!event.shiftKey &&
			document.activeElement === lastItem
		) {
			event.preventDefault();
			firstItem.focus();
		}
	});

	window.addEventListener('hashchange', updateCurrentLink);
	window.addEventListener('pageshow', () => {
		isOpen = false;
		panel.setAttribute('aria-hidden', 'true');
		panel.setAttribute('inert', '');
		setToggleState(false);
		setBackgroundInert(false);
		root.classList.remove('villa-antares-menu-open');
		root.style.removeProperty('--villa-antares-locked-scroll');
		updateCurrentLink();
	});

	setToggleState(false);
	updateCurrentLink();
})();
