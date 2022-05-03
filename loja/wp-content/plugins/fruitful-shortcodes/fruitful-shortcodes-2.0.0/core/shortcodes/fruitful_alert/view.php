<?php
$atts    = $data['atts'];
$content = $data['content'];

$attributes = $classes = array();

$classes[] = 'ff-root';
$classes[] = 'fruitful_alert';
$classes[] = 'ff-' . $atts['color'];

$attributes[] = 'id="' . $atts['id'] . '"';
$attributes[] = 'class="' . implode( ' ', $classes ) . '"';

$attributes = apply_filters( 'ff_shortcodes_shortcode_wrap_attrs', $attributes, $data );

?>
<div <?php echo implode( ' ', $attributes ); ?>>
	
	<i class="ff-icon"></i>
	
	<?php echo $content; ?>
	
	<a href="#" class="ff-alert-dismiss"></a>

</div>