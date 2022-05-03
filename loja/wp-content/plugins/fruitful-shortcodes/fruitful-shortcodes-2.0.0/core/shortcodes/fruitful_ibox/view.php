<?php
	$atts = $data['atts'];
	$content = $data['content'];
	$col = 12;

	switch( $atts['column'] ) {
		case 'ffs-two-one':
			$col = 6;
		break;
		case 'ffs-three-one':
			$col = 4;
		break;
		case 'ffs-four-one':
			$col = 3;
		break;
		case 'ffs-three-two':
			$col = 8;
		break;
		case 'ffs-four-three':
			$col = 9;
		break;
		case 'ffs-five-one':
			$col = 0;
		break;
	}

	$attributes = $classes = array();

	$classes[] = 'ff-col-md-' . $col;
	$classes[] = 'ff-col-elem';

	if( $atts['column'] == 'ffs-five-one' ) {
		$classes[] = 'ff-one-five-col';
	}

	$align = isset( $data['atts']['align'] ) ? $data['atts']['align'] : '';
	$image = isset( $data['atts']['image'] ) ? $data['atts']['image'] : null;
    $icon = isset( $data['atts']['icon'] ) ? $data['atts']['icon'] : 'fa-check-square-o';

    $icon_position = isset($data['atts']['icon_position']) ? sanitize_html_class($data['atts']['icon_position']):'';

    $styleicon = !empty($data['atts']['styleicon']) ?  ' style="'.esc_attr($data['atts']['styleicon']).'"':'';
    $styletitle = !empty($data['atts']['styletitle']) ?  ' style="'.esc_attr($data['atts']['styletitle']).'"':'';
    $styletext = !empty($data['atts']['styletext']) ?  ' style="'.esc_attr($data['atts']['styletext']).'"':'';

	$classes[] = 'text-align-' . $align;

	$attributes[] = 'class="' . implode( ' ', $classes ) . '"';


?>
<div <?php echo implode( ' ', $attributes ); ?>>

    <div class="ffs-info-box <?php echo $icon_position; ?>">
        <div class="ffs-icon-box">
            <?php if( $image ) { ?>
                <div class="ff-col-image">
                    <?php if( is_numeric( $image ) ): ?>
                        <img src="<?php echo wp_get_attachment_url( $image ); ?>" alt="">
                    <?php else: ?>
                        <img src="<?php echo $image; ?>" alt="">
                    <?php endif; ?>
                </div>
            <?php } else { ?>
                <?php if ($icon) { ?>
                    <span class="ffs-icon-container"><i class="fa <?php echo $icon; ?>"<?php echo $styleicon; ?>></i></span>
                <?php } ?>
            <?php } ?>
        </div>

        <div class="ffs-content-box">
            <?php if( $atts['title'] <> '' ): ?>
                <h2 class="ff-col-title"<?php echo $styletitle; ?>><?php echo $atts['title']; ?></h2>
            <?php endif; ?>

            <div <?php echo $styletext; ?>>
                <?php echo do_shortcode( $content ); ?>
            </div>
        </div>
    </div>

</div>
