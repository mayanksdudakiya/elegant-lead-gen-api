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
            'permission_callback' => [ $this, 'check_access' ],
            'args' => [
                'username' => [
                    'required' => true
                ],
                'password' => [
                    'required' => true
                ],
                'name' => [
                    'required' => true,
                    'type' => 'string',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                'phone_number' => [
                    'required' => true,
                    'type' => 'string',
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                'email_address' => [
                    'required' => true,
                    'type' => 'string',
                    'validate_callback' => 'is_email',
                    'sanitize_callback' => 'sanitize_email'
                ],
                'budget' => [
                    'required' => true,
                    'validate_callback' => function($value, $request, $param) {
                        return is_numeric($value) && (is_int($value) && $value > 0);
                    },
                    'sanitize_callback' => 'sanitize_text_field'
                ],
                'message' => [
                    'required' => true,
                    'type' => 'string',
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ]
        ], true);
    }

    // Check who can access the rest api
    public function check_access(\WP_REST_Request $request) {

        $username = $request->get_param('username');

        $password = $request->get_param('password');

        // Check username & password are correct & valid
        $user = wp_authenticate($username, $password);

        if ( is_wp_error($user) ) {
            return false;
        }

        // allow only admin to do this
        if ( !user_can($user->ID, 'manage_options') ) {
            return false;
        }
        
        return true;
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