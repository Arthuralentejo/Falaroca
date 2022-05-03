<?php

$atts    = $data['atts'];
$content = $data['content'];

$attributes = $classes = array();

$classes[]    = 'ff-root';
$classes[]    = 'fruitful_pbar';
$attributes[] = 'class="' . implode( ' ', $classes ) . '"';

$attributes = apply_filters( 'ff_shortcodes_shortcode_wrap_attrs', $attributes, $data );

?>

<div <?php echo implode( ' ', $attributes ); ?>>
	<?php
		global $ff_pbar_shortcode_delay;
		$ff_pbar_shortcode_delay = 0.0;
		echo do_shortcode( $content );
	?>
</div>