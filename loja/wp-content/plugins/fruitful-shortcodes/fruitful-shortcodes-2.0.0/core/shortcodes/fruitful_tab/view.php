<?php
	$atts = $data['atts'];
	$content = $data['content'];
?>
<div class="fruitful_tabs_tab">
	<div class="ff-inside">
		<?php if( $atts['title'] <> '' ): ?>
			<h4 class="ff-title"><?php echo $atts['title']; ?></h4>
		<?php endif; ?>
		<div class="ff-tab-content">
			<?php echo do_shortcode( $content ); ?>
		</div>
	</div>
</div>