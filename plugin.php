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
}

Plugin::instance();