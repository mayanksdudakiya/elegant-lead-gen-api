<?php

namespace ElegantLeadGen;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class UserApi {

    private static $_instance;

    /**
     * @return UserApi
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}

UserApi::instance();