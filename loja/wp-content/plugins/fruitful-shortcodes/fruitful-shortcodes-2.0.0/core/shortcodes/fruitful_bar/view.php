<?php
	global $ff_pbar_shortcode_delay;

	$ff_pbar_shortcode_delay = $ff_pbar_shortcode_delay + 0.2;

	$atts = $data['atts'];
	$content = $data['content'];
	$attributes = $classes = array();

	$classes[] = 'ff-root';
	$classes[] = 'ff fruitful_bar';

	$atts['type'] = str_replace( 'progress-bar-', '', $atts['type']);
	$classes[] = 'ff-type-' . $atts['type'];

	if( filter_var( $atts['striped'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $atts['stripped'], FILTER_VALIDATE_BOOLEAN )) {
		$classes[] = 'ff-style-striped';
	}

	if( $atts['icon'] <> '' ) {
		$classes[] = 'ff-iconic';
	}

	$atts['width'] = str_replace( '%', '', $atts['width'] );

	if( $atts['width'] > 95 ) {
		$classes[] = 'ff-full';
	}

	$attributes[] = 'class="' . implode( ' ', $classes ) . '"';
?>

<div <?php echo implode( ' ', $attributes ); ?>>

	<div class="ff-bar" data-delay="<?php echo $ff_pbar_shortcode_delay; ?>s" data-width="<?php echo absint( $atts['width'] ); ?>%"></div>

	<?php if( $atts['icon'] <> '' ): ?>
	<div class="ff-icon">
		<i class="<?php echo $atts['icon']; ?>"></i>
	</div>
	<?php endif; ?>

	<?php if( $atts['title'] <> '' ): ?>
	<div class="ff-title">
		<?php echo $atts['title']; ?>
	</div>
	<?php endif; ?>

	<div class="ff-value"><?php echo $atts['width']; ?>%</div>

</div>