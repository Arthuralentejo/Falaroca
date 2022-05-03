<?php

use ffshortcodes\helper\admin_options;

// get config 
require 'config.php';

// print shortcode form
admin_options::print_form( $cfg );