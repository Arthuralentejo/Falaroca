<?php

class FruitfulShortcodes_Stats extends FruitfulStatistic {
	
	public $product_type = 'plugin';
	
    public $product_option_name = 'fruitful-shortcodes';
    
	/**
	 * Constructor
	 **/
	public function __construct( $root_file ) {
		parent::__construct( $root_file );
		
		$this->data['stats_path'] = plugin_dir_path( $this->root_file ) . '/core/vendor/';
		$this->data['stats_uri'] = plugin_dir_url( $this->root_file )  . '/core/vendor/';
	}
    
    /**
	 * Function update fruitful theme customizer option from general ffc statistic option
	 * (individual for each product)
	 */
	public function product_stats_settings_update() {
	}
	
	public function general_stats_option_update( $value, $old_value ) {
	}
}
