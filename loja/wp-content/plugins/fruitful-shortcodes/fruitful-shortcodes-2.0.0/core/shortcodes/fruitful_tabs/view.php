<?php
$atts    = $data['atts'];
$content = $data['content'];

$additional_attributes = apply_filters( 'ff_shortcodes_shortcode_wrap_attrs', [], $data );
?>
<div class="ff-root fruitful_tabs type-<?php echo esc_attr( $atts['type'] ); ?> from-shortcodes" data-type="<?php echo esc_attr( $atts['type'] ); ?>"
	 data-break="<?php echo absint( $atts['resp_break'] ); ?>" <?php echo implode( ' ', $additional_attributes ); ?>>
	<?php echo do_shortcode( $content ); ?>
</div>