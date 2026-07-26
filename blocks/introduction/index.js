(() => {
	'use strict';

	const {
		InnerBlocks,
		InspectorControls,
		MediaUpload,
		MediaUploadCheck,
		RichText,
		useBlockProps
	} = wp.blockEditor;
	const {
		Button,
		FocalPointPicker,
		Notice,
		PanelBody,
		TextControl
	} = wp.components;
	const { useSelect } = wp.data;
	const { createElement: el, Fragment, useEffect, useState } = wp.element;
	const { __ } = wp.i18n;

	const defaultAlt = __(
		'Villa Antares overlooking the Adriatic Sea',
		'vila-antares'
	);
	const paragraphTemplate = [
		[
			'core/paragraph',
			{
				content: __(
					'Hidden among centuries-old olive trees, embraced by Mediterranean gardens and overlooking the endless Adriatic, Villa Antares is more than a residence — it is a private world of timeless beauty, absolute privacy, and uncompromising luxury.',
					'vila-antares'
				)
			}
		],
		[
			'core/paragraph',
			{
				content: __(
					'Villa Antares was conceived with a singular philosophy: excellence without compromise.',
					'vila-antares'
				)
			}
		],
		[
			'core/paragraph',
			{
				content: __(
					'From sunrise over the sea to evenings beneath the Mediterranean stars, Villa Antares offers uninterrupted moments of beauty.',
					'vila-antares'
				)
			}
		],
		[
			'core/paragraph',
			{
				content: __(
					'Expansive terraces, elegant outdoor entertaining spaces, and breathtaking panoramic views create a setting that is both intimate and spectacular.',
					'vila-antares'
				)
			}
		],
		[
			'core/paragraph',
			{
				content: __(
					'Whether envisioned as a prestigious private residence or one of the Adriatic’s most exclusive luxury retreats, Villa Antares stands in a category of its own.',
					'vila-antares'
				)
			}
		],
		[
			'core/paragraph',
			{
				content: __('Welcome to Villa Antares', 'vila-antares')
			}
		]
	];

	const attributes = {
		sectionNumber: { type: 'string', default: '01' },
		eyebrow: { type: 'string', default: 'Explore' },
		decorativeLabel: { type: 'string', default: 'Villa Antares' },
		title: { type: 'string', default: 'VILLA ANTARES' },
		ctaText: { type: 'string', default: 'CONTACT US' },
		ctaUrl: { type: 'string', default: '#contact' },
		imageId: { type: 'integer', default: 0 },
		altText: { type: 'string', default: defaultAlt },
		focalPoint: {
			type: 'object',
			default: { x: 0.5, y: 0.5 }
		}
	};

	const Edit = ({ attributes: values, setAttributes }) => {
		const [mediaError, setMediaError] = useState('');
		const blockProps = useBlockProps({
			className: 'villa-antares-introduction-editor'
		});
		const media = useSelect(
			(select) =>
				values.imageId
					? select('core').getMedia(values.imageId)
					: null,
			[values.imageId]
		);
		const imageUrl = media && media.source_url;
		const focalPoint = values.focalPoint || { x: 0.5, y: 0.5 };
		const update = (key) => (value) => {
			setAttributes({ [key]: value });
		};

		useEffect(() => {
			if (values.align !== 'full') {
				setAttributes({ align: 'full' });
			}
		}, [setAttributes, values.align]);

		const selectImage = (selected) => {
			const mime = selected.mime || selected.mime_type || '';

			if (!selected.id || !mime.startsWith('image/')) {
				setMediaError(
					__(
						'Please choose a supported image file.',
						'vila-antares'
					)
				);
				return;
			}

			setMediaError('');
			setAttributes({
				imageId: selected.id,
				altText:
					typeof selected.alt === 'string' && selected.alt.trim()
						? selected.alt
						: values.altText || defaultAlt
			});
		};

		const mediaActions = el(
			'div',
			{ className: 'villa-antares-introduction-editor__media-actions' },
			el(
				MediaUploadCheck,
				null,
				el(MediaUpload, {
					allowedTypes: ['image'],
					onSelect: selectImage,
					render: ({ open }) =>
						el(
							Button,
							{
								onClick: open,
								variant: values.imageId
									? 'secondary'
									: 'primary'
							},
							values.imageId
								? __('Replace image', 'vila-antares')
								: __('Select image', 'vila-antares')
						),
					value: values.imageId || undefined
				})
			),
			values.imageId
				? el(
						Button,
						{
							isDestructive: true,
							onClick: () => {
								setMediaError('');
								setAttributes({ imageId: 0 });
							},
							variant: 'tertiary'
						},
						__('Remove image', 'vila-antares')
					)
				: null
		);

		return el(
			Fragment,
			null,
			el(
				InspectorControls,
				null,
				el(
					PanelBody,
					{
						initialOpen: true,
						title: __('CTA settings', 'vila-antares')
					},
					el(TextControl, {
						label: __('CTA URL', 'vila-antares'),
						onChange: update('ctaUrl'),
						value: values.ctaUrl
					})
				),
				el(
					PanelBody,
					{
						initialOpen: true,
						title: __('Image settings', 'vila-antares')
					},
					mediaActions,
					el(TextControl, {
						help: __(
							'Describe the image for visitors who cannot see it.',
							'vila-antares'
						),
						label: __('Alt text', 'vila-antares'),
						onChange: update('altText'),
						value: values.altText
					}),
					imageUrl
						? el(FocalPointPicker, {
								label: __('Focal point', 'vila-antares'),
								onChange: update('focalPoint'),
								url: imageUrl,
								value: focalPoint
							})
						: null
				)
			),
			el(
				'div',
				blockProps,
				el(
					'div',
					{ className: 'villa-antares-introduction-editor__text' },
					el(RichText, {
						className:
							'villa-antares-introduction-editor__decorative',
						onChange: update('decorativeLabel'),
						placeholder: __('Decorative label', 'vila-antares'),
						tagName: 'span',
						value: values.decorativeLabel
					}),
					el(
						'div',
						{
							className:
								'villa-antares-introduction-editor__marker'
						},
						el(RichText, {
							onChange: update('sectionNumber'),
							placeholder: __('01', 'vila-antares'),
							tagName: 'span',
							value: values.sectionNumber
						}),
						el('span', { 'aria-hidden': true }),
						el(RichText, {
							onChange: update('eyebrow'),
							placeholder: __('Explore', 'vila-antares'),
							tagName: 'span',
							value: values.eyebrow
						})
					),
					el(RichText, {
						className:
							'villa-antares-introduction-editor__title',
						onChange: update('title'),
						placeholder: __('VILLA ANTARES', 'vila-antares'),
						tagName: 'h2',
						value: values.title
					}),
					el(
						'div',
						{ className: 'villa-antares-introduction-editor__body' },
						el(InnerBlocks, {
							allowedBlocks: ['core/paragraph'],
							renderAppender: false,
							template: paragraphTemplate,
							templateLock: 'all'
						})
					),
					el(
						'div',
						{
							className:
								'villa-antares-introduction-editor__cta'
						},
						el(RichText, {
							onChange: update('ctaText'),
							placeholder: __('CONTACT US', 'vila-antares'),
							tagName: 'span',
							value: values.ctaText
						})
					)
				),
				el(
					'div',
					{ className: 'villa-antares-introduction-editor__media' },
					imageUrl
						? el('img', {
								alt: '',
								src: imageUrl,
								style: {
									objectPosition: `${focalPoint.x * 100}% ${
										focalPoint.y * 100
									}%`
								}
							})
						: el(
								'div',
								{
									className:
										'villa-antares-introduction-editor__placeholder'
								},
								__(
									'Select the Introduction photograph.',
									'vila-antares'
								)
							),
					mediaError
						? el(
								Notice,
								{ isDismissible: false, status: 'error' },
								mediaError
							)
						: null,
					mediaActions
				)
			)
		);
	};

	wp.blocks.registerBlockType('villa-antares/introduction', {
		apiVersion: 3,
		attributes,
		category: 'design',
		description: __(
			'Editorial introduction with editable copy, CTA and responsive image.',
			'vila-antares'
		),
		edit: Edit,
		icon: 'align-pull-left',
		save: () => el(InnerBlocks.Content),
		supports: {
			align: ['full'],
			anchor: false,
			customClassName: false,
			html: false,
			multiple: false
		},
		title: __('Introduction', 'vila-antares')
	});
})();
