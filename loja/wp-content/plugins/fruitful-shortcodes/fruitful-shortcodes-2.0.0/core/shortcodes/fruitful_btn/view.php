<?php
	$atts = $data['atts'];
	$content = $data['content'];

	$attributes = $classes = array();

	$classes[] = 'ff';
	$classes[] = 'ff-root';
	$classes[] = 'fruitful_btn'; 
	$classes[] = 'ff-type-' . $atts['type']; 

	if( $atts['type'] == 'button' || $atts['type'] == 'link'  ) {
		$attributes[] = 'target="' . $atts['target'] . '"';
		$attributes[] = 'href="' . $atts['link'] . '"';
	} else {

		$attributes[] = 'type="' . $atts['type'] . '"';
		$attributes[] = 'value="' . $content . '"';

		if( $atts['state'] == 'disabled' ) {
			$attributes[] = 'disabled="disabled"';
		}

	}

	if( $atts['icon'] <> '' ) {
		$classes[] = 'ff-with-icon';

		if( $atts['icon_position'] <> '' ) {
			$classes[] = 'ff-icon-pos-' . $atts['icon_position'];
		}

	}

	$classes[] = 'ff-size-' . $atts['size'];
	$classes[] = 'ff-color-' . $atts['color'];
	$classes[] = 'ff-style-' . $atts['style'];

	$attributes[] = 'id="' . $atts['id'] . '"';

	$attributes[] = 'class="' . implode( ' ', $classes ) . '"';

	$color = '';
	if (!empty($atts['text_color'])) {

		$color = 'color:' . esc_attr($atts['text_color']) . ';';
    }

	$bg_color = '';
	if(!empty($atts['background_color'])) {
		$bg_color = 'background-color:' . esc_attr($atts['background_color']). ';';
	}
	$border_color = '';
	if(!empty($atts['border_color'])) {
		$border_color = 'border-color:' . esc_attr($atts['border_color']). ';';
	}

	$attributes[] = "style='{$color}{$bg_color}{$border_color}'";
	
	$attributes = apply_filters( 'ff_shortcodes_shortcode_wrap_attrs', $attributes, $data );

?>

<?php if( $atts['type'] == 'link' ||  $atts['type'] == 'button' ): ?>
<a <?php echo implode( ' ', $attributes ); ?>>
	<?php if( $atts['icon'] <> '' && $atts['icon_position'] == 'left' ): ?>
		<i class="fa <?php echo $atts['icon']; ?>"></i>
	<?php endif; ?>
	<?php echo $content; ?>	
	<?php if( $atts['icon'] <> '' && $atts['icon_position'] == 'right' ): ?>
		<i class="<?php echo $atts['icon']; ?>"></i>
	<?php endif; ?>
</a>
<?php else: ?>
<input <?php echo implode( ' ', $attributes ); ?>>
<?php endif;
