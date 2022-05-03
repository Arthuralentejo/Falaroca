<?php

$atts    = $data['atts'];
$content = $data['content'];

$attributes = $classes = array();

$classes[]    = 'ff';
$classes[]    = 'ff-root';
$attributes[] = 'class="' . implode( ' ', $classes ) . '"';

$attributes = apply_filters( 'ff_shortcodes_shortcode_wrap_attrs', $attributes, $data );

?>
<div <?php echo implode( ' ', $attributes ); ?>>
	<div class="ff-container-fluid">
		<div class="ff-row">
			<?php echo do_shortcode( $content ); ?>
		</div>
	</div>
</div>
