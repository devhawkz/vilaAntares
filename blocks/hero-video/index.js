(() => {
	'use strict';

	const { MediaUpload, MediaUploadCheck, InspectorControls, useBlockProps } =
		wp.blockEditor;
	const { Button, Notice, PanelBody, TextControl } = wp.components;
	const { useSelect } = wp.data;
	const { createElement: el, Fragment, useEffect, useState } = wp.element;
	const { __ } = wp.i18n;

	const attributes = {
		desktopVideoId: { type: 'integer', default: 0 },
		mobileVideoId: { type: 'integer', default: 0 },
		desktopPosterId: { type: 'integer', default: 0 },
		mobilePosterId: { type: 'integer', default: 0 },
		accessibleTitle: { type: 'string', default: 'Villa Antares' },
		accessibleLocation: { type: 'string', default: 'Montenegro' },
		accessibleTagline: {
			type: 'string',
			default:
				'The luxury of space. The privilege of privacy. The beauty of the Adriatic.'
		},
		videoId: { type: 'string', default: '' }
	};

	const MediaField = ({
		attachmentId,
		expectedMime,
		isPoster,
		label,
		onChange
	}) => {
		const [error, setError] = useState('');
		const media = useSelect(
			(select) =>
				attachmentId
					? select('core').getMedia(attachmentId)
					: null,
			[attachmentId]
		);
		const filename =
			media && (media.filename || media.slug || media.title?.rendered);
		const mediaUrl = media && media.source_url;
		const details = media && media.media_details;

		const selectMedia = (selected) => {
			const mime = selected.mime || selected.mime_type || '';

			if (mime !== expectedMime) {
				setError(
					__(
						'Please choose a file with the required format.',
						'vila-antares'
					)
				);
				return;
			}

			setError('');
			onChange(selected.id);
		};

		return el(
			'div',
			{ className: 'villa-antares-hero-editor__media' },
			el(
				'div',
				{ className: 'villa-antares-hero-editor__media-heading' },
				el('strong', null, label),
				el(
					'span',
					{ className: 'villa-antares-hero-editor__status' },
					attachmentId
						? __('Selected', 'vila-antares')
						: __('Required', 'vila-antares')
				)
			),
			isPoster && mediaUrl
				? el('img', {
						className: 'villa-antares-hero-editor__poster',
						src: mediaUrl,
						alt: ''
					})
				: null,
			attachmentId
				? el(
						'p',
						{ className: 'villa-antares-hero-editor__details' },
						filename || `Attachment #${attachmentId}`,
						details?.width && details?.height
							? ` — ${details.width} × ${details.height}`
							: ''
					)
				: el(
						'p',
						{ className: 'villa-antares-hero-editor__details' },
						__('No file selected.', 'vila-antares')
					),
			error
				? el(
						Notice,
						{ status: 'error', isDismissible: false },
						error
					)
				: null,
			el(
				'div',
				{ className: 'villa-antares-hero-editor__actions' },
				el(
					MediaUploadCheck,
					null,
					el(MediaUpload, {
						allowedTypes: [expectedMime],
						onSelect: selectMedia,
						render: ({ open }) =>
							el(
								Button,
								{
									variant: attachmentId
										? 'secondary'
										: 'primary',
									onClick: open
								},
								attachmentId
									? __('Replace', 'vila-antares')
									: __('Select', 'vila-antares')
							),
						value: attachmentId || undefined
					})
				),
				attachmentId
					? el(
							Button,
							{
								isDestructive: true,
								variant: 'tertiary',
								onClick: () => {
									setError('');
									onChange(0);
								}
							},
							__('Remove', 'vila-antares')
						)
					: null
			)
		);
	};

	const Edit = ({ attributes: values, clientId, setAttributes }) => {
		const missingMedia = [
			values.desktopVideoId,
			values.mobileVideoId,
			values.desktopPosterId,
			values.mobilePosterId
		].some((id) => !id);
		const blockProps = useBlockProps({
			className: 'villa-antares-hero-editor'
		});

		useEffect(() => {
			const nextAttributes = {};

			if (!values.videoId) {
				nextAttributes.videoId = `villa-antares-hero-video-${clientId.replace(
					/[^a-z0-9-]/gi,
					''
				)}`;
			}

			if (values.align !== 'full') {
				nextAttributes.align = 'full';
			}

			if (!values.anchor) {
				nextAttributes.anchor = 'home';
			}

			if (Object.keys(nextAttributes).length) {
				setAttributes(nextAttributes);
			}
		}, [
			clientId,
			setAttributes,
			values.align,
			values.anchor,
			values.videoId
		]);

		const update = (key) => (value) => {
			setAttributes({ [key]: value });
		};

		return el(
			Fragment,
			null,
			el(
				InspectorControls,
				null,
				el(
					PanelBody,
					{
						title: __('Accessible content', 'vila-antares'),
						initialOpen: true
					},
					el(TextControl, {
						label: __('Accessible title', 'vila-antares'),
						value: values.accessibleTitle,
						onChange: update('accessibleTitle')
					}),
					el(TextControl, {
						label: __('Accessible location', 'vila-antares'),
						value: values.accessibleLocation,
						onChange: update('accessibleLocation')
					}),
					el(TextControl, {
						label: __('Accessible tagline', 'vila-antares'),
						value: values.accessibleTagline,
						onChange: update('accessibleTagline')
					})
				)
			),
			el(
				'div',
				blockProps,
				el(
					'div',
					{ className: 'villa-antares-hero-editor__intro' },
					el(
						'h2',
						null,
						__('Fullscreen Hero Video', 'vila-antares')
					),
					el(
						'p',
						null,
						__(
							'The editor displays poster previews only. Frontend shows an Enter overlay, then plays the hero video with sound.',
							'vila-antares'
						)
					)
				),
				missingMedia
					? el(
							Notice,
							{ status: 'warning', isDismissible: false },
							__(
								'Select all four required media files before publishing.',
								'vila-antares'
							)
						)
					: null,
				el(
					'div',
					{ className: 'villa-antares-hero-editor__grid' },
					el(MediaField, {
						attachmentId: values.desktopVideoId,
						expectedMime: 'video/mp4',
						isPoster: false,
						label: __('Desktop MP4', 'vila-antares'),
						onChange: update('desktopVideoId')
					}),
					el(MediaField, {
						attachmentId: values.mobileVideoId,
						expectedMime: 'video/mp4',
						isPoster: false,
						label: __('Mobile portrait MP4', 'vila-antares'),
						onChange: update('mobileVideoId')
					}),
					el(MediaField, {
						attachmentId: values.desktopPosterId,
						expectedMime: 'image/webp',
						isPoster: true,
						label: __('Desktop poster', 'vila-antares'),
						onChange: update('desktopPosterId')
					}),
					el(MediaField, {
						attachmentId: values.mobilePosterId,
						expectedMime: 'image/webp',
						isPoster: true,
						label: __('Mobile portrait poster', 'vila-antares'),
						onChange: update('mobilePosterId')
					})
				),
				el(
					'div',
					{ className: 'villa-antares-hero-editor__copy-preview' },
					el('h1', null, values.accessibleTitle),
					el('p', null, values.accessibleLocation),
					el('p', null, values.accessibleTagline)
				)
			)
		);
	};

	wp.blocks.registerBlockType('villa-antares/hero-video', {
		apiVersion: 3,
		title: __('Fullscreen Hero Video', 'vila-antares'),
		description: __(
			'Responsive fullscreen video with accessible content and custom controls.',
			'vila-antares'
		),
		category: 'media',
		icon: 'format-video',
		attributes,
		supports: {
			align: ['full'],
			anchor: true,
			html: false,
			multiple: false
		},
		edit: Edit,
		save: () => null
	});
})();
