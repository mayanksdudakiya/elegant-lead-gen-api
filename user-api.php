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

        register_rest_route('el/v1', 'user', [
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => [ $this, 'create_user' ],
            'permission_callback' => [ $this, 'check_access' ]
        ], true);
    }

    public function check_access(\WP_REST_Request $request) {

    }

    public function create_user(\WP_REST_Request $request) {
    
    }

    private function setup_hooks() {
        add_action( 'rest_api_init', [ $this, 'register_apis' ] );
    }

    private function __construct() {
        $this->setup_hooks();
    }
}

UserApi::instance();