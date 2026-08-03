(() => {
	'use strict';

	const mobilePortraitQuery = window.matchMedia(
		'(max-width: 689.98px) and (orientation: portrait)'
	);
	const reducedMotionQuery = window.matchMedia(
		'(prefers-reduced-motion: reduce)'
	);
	const saveData =
		typeof navigator.connection === 'object' &&
		navigator.connection !== null &&
		navigator.connection.saveData === true;
	const enteredStorageKey = 'villa-antares-hero-entered';

	const onMediaChange = (query, callback) => {
		if (typeof query.addEventListener === 'function') {
			query.addEventListener('change', callback);
		} else if (typeof query.addListener === 'function') {
			query.addListener(callback);
		}
	};

	document
		.querySelectorAll('[data-villa-antares-hero]')
		.forEach((hero) => {
			const video = hero.querySelector(
				'[data-villa-antares-hero-video]'
			);
			const controls = hero.querySelector(
				'[data-villa-antares-hero-controls]'
			);
			const playButton = hero.querySelector(
				'[data-villa-antares-play]'
			);
			const soundButton = hero.querySelector(
				'[data-villa-antares-sound]'
			);
			const fallback = hero.querySelector(
				'[data-villa-antares-video-fallback]'
			);
			const nextButton = hero.querySelector(
				'[data-villa-antares-next]'
			);
			const enterOverlay = hero.querySelector(
				'[data-villa-antares-enter]'
			);
			const enterButton = hero.querySelector(
				'[data-villa-antares-enter-button]'
			);

			if (!video || !controls || !playButton || !soundButton) {
				return;
			}

			let currentSource = '';
			let desiredPlaying = false;
			let playRequest = 0;
			let sourceRequest = 0;
			let switchingSource = false;
			let preferSound = true;
			let hasEntered = false;
			const playLabel =
				playButton.dataset.playLabel ||
				playButton.getAttribute('aria-label') ||
				'';
			const pauseLabel =
				playButton.dataset.pauseLabel || playLabel;
			const soundOnLabel =
				soundButton.dataset.soundOnLabel ||
				soundButton.getAttribute('aria-label') ||
				'';
			const soundOffLabel =
				soundButton.dataset.soundOffLabel || soundOnLabel;

			const getMedia = () => {
				const useMobile = mobilePortraitQuery.matches;

				return {
					poster: useMobile
						? hero.dataset.mobilePoster
						: hero.dataset.desktopPoster,
					video: useMobile
						? hero.dataset.mobileVideo
						: hero.dataset.desktopVideo
				};
			};

			const setPoster = () => {
				const poster = getMedia().poster;

				if (poster && video.getAttribute('poster') !== poster) {
					video.setAttribute('poster', poster);
				}
			};

			const updateControls = () => {
				const isPlaying =
					!video.paused && !video.ended && !video.error;
				const hasSound =
					!video.muted && video.volume > 0 && !video.error;

				playButton.dataset.state = isPlaying
					? 'playing'
					: 'paused';
				playButton.setAttribute(
					'aria-label',
					isPlaying ? pauseLabel : playLabel
				);
				playButton.setAttribute('aria-pressed', String(isPlaying));

				soundButton.dataset.state = hasSound ? 'sound' : 'muted';
				soundButton.setAttribute(
					'aria-label',
					hasSound ? soundOffLabel : soundOnLabel
				);
				soundButton.setAttribute('aria-pressed', String(hasSound));
			};

			const ensureSource = () => {
				const source = getMedia().video;

				setPoster();

				if (!source || currentSource === source) {
					return Boolean(source);
				}

				currentSource = source;
				video.src = source;
				video.preload = 'metadata';
				video.load();

				return true;
			};

			const requestPlayback = (shouldPlay) => {
				const request = ++playRequest;

				desiredPlaying = shouldPlay;

				if (!shouldPlay) {
					video.pause();
					updateControls();
					return Promise.resolve(false);
				}

				if (!ensureSource()) {
					desiredPlaying = false;
					updateControls();
					return Promise.resolve(false);
				}

				let playResult;

				try {
					playResult = video.play();
				} catch (error) {
					desiredPlaying = false;
					updateControls();
					return Promise.resolve(false);
				}

				return Promise.resolve(playResult)
					.then(() => {
						if (
							request !== playRequest ||
							!desiredPlaying
						) {
							video.pause();
							return false;
						}

						return true;
					})
					.catch(() => {
						if (request === playRequest) {
							desiredPlaying = false;
							hero.classList.add(
								'is-autoplay-blocked'
							);
							updateControls();
						}

						return false;
					});
			};

			const enableSound = () => {
				if (video.volume === 0) {
					video.volume = 1;
				}

				video.muted = false;
				video.removeAttribute('muted');
				preferSound = true;
				updateControls();
			};

			const markEntered = () => {
				hasEntered = true;
				hero.classList.add('is-entered');
				controls.hidden = false;

				if (enterOverlay) {
					enterOverlay.setAttribute('aria-hidden', 'true');
					enterOverlay.setAttribute('inert', '');
				}

				try {
					window.sessionStorage.setItem(
						enteredStorageKey,
						'1'
					);
				} catch (error) {
					// Ignore storage failures (private mode, etc.).
				}
			};

			const startWithSound = () => {
				if (!ensureSource()) {
					return Promise.resolve(false);
				}

				preferSound = true;
				enableSound();

				return requestPlayback(true).then((playedWithSound) => {
					if (playedWithSound && !video.muted) {
						hero.classList.remove('is-autoplay-blocked');
						updateControls();
						return true;
					}

					video.muted = true;
					video.setAttribute('muted', '');
					hero.classList.add('is-autoplay-blocked');

					return requestPlayback(true).then((playedMuted) => {
						updateControls();
						return playedMuted;
					});
				});
			};

			const enterExperience = () => {
				if (hasEntered) {
					return;
				}

				markEntered();
				startWithSound();
			};

			const switchResponsiveSource = () => {
				const nextMedia = getMedia();

				setPoster();

				if (
					!currentSource ||
					!nextMedia.video ||
					currentSource === nextMedia.video
				) {
					return;
				}

				const request = ++sourceRequest;
				const wasPlaying =
					desiredPlaying &&
					!video.paused &&
					!video.ended &&
					!video.error;
				const savedTime = Number.isFinite(video.currentTime)
					? video.currentTime
					: 0;
				const keepSound = preferSound && !video.muted;

				switchingSource = true;
				++playRequest;
				video.muted = true;
				hero.classList.remove('is-video-playing');
				currentSource = nextMedia.video;
				video.src = nextMedia.video;
				video.preload = 'metadata';
				video.load();

				const restoreState = () => {
					if (request !== sourceRequest) {
						return;
					}

					if (
						savedTime > 0 &&
						Number.isFinite(video.duration) &&
						video.duration > 0
					) {
						video.currentTime = Math.min(
							savedTime,
							Math.max(0, video.duration - 0.1)
						);
					}

					switchingSource = false;
					desiredPlaying = wasPlaying;

					if (keepSound) {
						enableSound();
					}

					if (wasPlaying) {
						requestPlayback(true).then((played) => {
							if (!played && keepSound) {
								video.muted = true;
								requestPlayback(true);
							}
						});
					} else {
						updateControls();
					}
				};

				video.addEventListener(
					'loadedmetadata',
					restoreState,
					{ once: true }
				);
			};

			playButton.addEventListener('click', () => {
				requestPlayback(!desiredPlaying);
			});

			video.addEventListener('click', () => {
				if (!hasEntered) {
					return;
				}

				requestPlayback(!desiredPlaying);
			});

			soundButton.addEventListener('click', () => {
				const turnSoundOn = video.muted || video.volume === 0;

				if (!turnSoundOn) {
					preferSound = false;
					video.muted = true;
					updateControls();
					return;
				}

				if (!ensureSource()) {
					updateControls();
					return;
				}

				preferSound = true;
				enableSound();

				if (!video.paused) {
					updateControls();
					return;
				}

				requestPlayback(true).then((played) => {
					if (!played) {
						video.muted = true;
						updateControls();
					}
				});
			});

			video.addEventListener('playing', () => {
				desiredPlaying = true;
				hero.classList.add('is-video-playing');

				if (!video.muted) {
					hero.classList.remove('is-autoplay-blocked');
				}

				updateControls();
			});

			video.addEventListener('pause', () => {
				hero.classList.remove('is-video-playing');

				if (!switchingSource) {
					desiredPlaying = false;
				}

				updateControls();
			});

			video.addEventListener('ended', () => {
				desiredPlaying = false;
				hero.classList.remove('is-video-playing');
				updateControls();
			});

			video.addEventListener('volumechange', updateControls);

			video.addEventListener('error', () => {
				++playRequest;
				desiredPlaying = false;
				hero.classList.remove('is-video-playing');
				hero.classList.add('has-video-error');
				playButton.disabled = true;
				soundButton.disabled = true;

				if (fallback) {
					fallback.hidden = false;
				}

				updateControls();
			});

			onMediaChange(
				mobilePortraitQuery,
				switchResponsiveSource
			);
			onMediaChange(reducedMotionQuery, () => {
				if (reducedMotionQuery.matches && !video.paused) {
					requestPlayback(false);
				}
			});

			if (nextButton) {
				nextButton.addEventListener('click', (event) => {
					const content = hero.parentElement;
					let target =
						content && hero.nextElementSibling
							? hero.nextElementSibling
							: null;

					if (!target && nextButton.hash) {
						target = document.querySelector(nextButton.hash);
					}

					if (!target) {
						return;
					}

					event.preventDefault();
					target.scrollIntoView({
						behavior: reducedMotionQuery.matches
							? 'auto'
							: 'smooth',
						block: 'start'
					});
				});
			}

			if (enterButton) {
				enterButton.addEventListener('click', enterExperience);
			}

			if (enterOverlay) {
				enterOverlay.addEventListener('keydown', (event) => {
					if (event.key === 'Enter' || event.key === ' ') {
						event.preventDefault();
						enterExperience();
					}
				});
			}

			setPoster();
			updateControls();

			if (reducedMotionQuery.matches || saveData) {
				hero.classList.add('requires-manual-playback');
				video.preload = 'none';
				video.removeAttribute('src');
				markEntered();
				return;
			}

			let alreadyEntered = false;

			try {
				alreadyEntered =
					window.sessionStorage.getItem(enteredStorageKey) ===
					'1';
			} catch (error) {
				alreadyEntered = false;
			}

			if (alreadyEntered || !enterOverlay || !enterButton) {
				markEntered();
				startWithSound();
				return;
			}

			controls.hidden = true;
			ensureSource();

			window.setTimeout(() => {
				if (!hasEntered && enterButton) {
					enterButton.focus();
				}
			}, 0);
		});
})();
