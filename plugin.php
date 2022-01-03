<?php

namespace ElegantLeadGen;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Plugin {

    private static $_instance;

    /**
     * @return Plugin
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function includes() {
        require WP_ELEGANT_LEAD_GEN_PATH . 'user-api.php';
        require WP_ELEGANT_LEAD_GEN_PATH . 'add-column-to-user.php';
    }

    private function __construct() {
        $this->includes();
    }
}

Plugin::instance();