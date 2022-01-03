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

    /**
     * Register all APIs end points here
     * @return void
     */
    public function register_apis(): void {

    }

    private function setup_hooks() {
        add_action( 'rest_api_init', [ $this, 'register_apis' ] );
    }

    private function __construct() {
        $this->setup_hooks();
    }
}

UserApi::instance();