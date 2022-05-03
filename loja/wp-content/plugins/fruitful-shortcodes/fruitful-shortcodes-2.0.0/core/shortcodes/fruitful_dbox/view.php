<?php
$atts    = $data['atts'];
$content = $data['content'];

$attributes = $classes = array();

$classes[] = 'ff-root';
$classes[] = 'ff fruitful_dbox';
$classes[] = 'ff-' . $atts['style'];

$attributes[] = 'class="' . implode( ' ', $classes ) . '"';

$attributes = apply_filters( 'ff_shortcodes_shortcode_wrap_attrs', $attributes, $data );

?>
<div <?php echo implode( ' ', $attributes ); ?>>
	
	<?php if ( $atts['small_heading'] <> '' ): ?>
		<h4><?php echo $atts['small_heading']; ?></h4>
	<?php endif; ?>
	
	<?php if ( $atts['heading'] <> '' ): ?>
		<h2><?php echo $atts['heading']; ?></h2>
	<?php endif; ?>
	
	<?php echo apply_filters( 'the_content', $content ); ?>
	
	<?php if ( $atts['button_title'] <> '' ): ?>
		<a href="<?php echo $atts['button_link']; ?>" class="dbox-btn"><?php echo $atts['button_title']; ?></a>
	<?php endif; ?>

</div>