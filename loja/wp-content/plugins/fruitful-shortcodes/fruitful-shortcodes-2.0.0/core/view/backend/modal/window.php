<?php
	use ffshortcodes\helper\utils;
?>
<div class="ff-shortcodes-overlay"></div>

<div id="ff-shortcodes-modal-window" class="<?php echo $data['is_pro'] ? 'ff-pro-active' : ''; ?>">
	
	<header id="ff-shortcodes-modal-head">
		
		<a href="javascript:;" class="ff-shortcodes-back"></a>

		<h4><?php _e( 'Fruitful Shortcodes', 'ff_shortcodes'); ?></h4>

		<a href="javascript:;" class="ff-shortcodes-rollup"></a>
		<a href="javascript:;" class="ff-shortcodes-close"></a>

	</header>

	<section id="ff-shortcodes-modal-content">
		
		<div class="shortcodes-list">

			<form method="post" action="javascript:;" class="search-shortcodes">
				<input type="text" autocomplete="off" id="ff-search-shortcodes" class="search" name="search" value="" placeholder="<?php echo esc_attr( __( 'Search', 'ff_shortcodes') ); ?>">
				<a href="javascript:;" id="ff-search-clear" class="clear-search"></a>
			</form>

			<div id="ff-shortcodes-list" class="list">

				<?php
					foreach( $data['shortcodes'] as $shortcode => $cfg ):
						$is_pro  = filter_var( $cfg['is_pro'], FILTER_VALIDATE_BOOLEAN );
						$a_href   = ! empty( $cfg['direct_link'] ) ? esc_url( $cfg['direct_link'] ) : 'javascript:;';
						$a_class  = ! empty( $cfg['direct_link'] ) ? 'shortcode-elem-direct_link' : 'shortcode-elem';
						$a_target = ! empty( $cfg['direct_link'] ) ? ' target="_blank" ' : '';
					
				?>
				<div class="elem <?php if( $is_pro ): ?>pro<?php endif; ?> <?php if( $is_pro && ! utils::is_pro() ): ?>promo<?php endif; ?>">
					<a href="<?php echo $a_href ?>" data-shortcode="<?php echo esc_attr( $shortcode ); ?>" class="<?php echo $a_class ?>" <?php echo $a_target ?> >
						<img src="<?php echo $cfg['icon']; ?>" alt="" class="icon">
						<div class="desc">
							<h4><?php echo $cfg['title']; ?></h4>
							<span><?php echo $cfg['desc']; ?></span>
						</div>
					</a>
				</div>
				<?php endforeach; ?>

			</div>

		</div>

	</section>


</div>