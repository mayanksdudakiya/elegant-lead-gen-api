<?php

/**
 * Plugin Name: Elegant Lead Gen API
 * Plugin URI: https://www.elegantthemes.com/plugins/elegant-lead-gen-api
 * Description: Connect the Laravel application with WordPress
 * Version: 1.0.0
 * Author: Mayank Dudakiya
 * Author URI: https://www.elegantthemes.com
 * License: GPL3.0
 * Text Domain: elegant-lead-gen
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly.
endif;

define( 'WP_ELEGANT_LEAD_GEN_VERSION', '1.0.0' );
define( 'WP_ELEGANT_LEAD_GEN__FILE__', __FILE__ );
define( 'WP_ELEGANT_LEAD_GEN_PLUGIN_BASE', plugin_basename( WP_ELEGANT_LEAD_GEN__FILE__ ) );
define( 'WP_ELEGANT_LEAD_GEN_PATH', plugin_dir_path( WP_ELEGANT_LEAD_GEN__FILE__ ) );

