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
    public function check_access(\WP_REST_Request $request): bool {

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
        
        $params = $request->get_params();

        // Final check email already exists or not
        if ( email_exists( $params['email_address'] ) ) {
            return [
                'code' => 'rest_user_already_exists',
                'message' => __('Sorry, This user has already been registered', 'elegant-lead-gen'),
                'data' => [
                    'status' => 400,
                    'params' => [
                        'email_address' => 'User already exists'
                    ]
                ]
            ];
        }

        // Allow create user without password
        $userdata = [
            'user_nicename' => $params['name'],
            'display_name'  => $params['name'],
            'user_login'    => $params['email_address'],
            'user_email'    => $params['email_address'],
            'user_pass'     =>  NULL,
            'role'          => 'subscriber',
            'description'   => $params['message']
        ];

        $user_id = wp_insert_user($userdata);

        // Add extra piece of information in user
        add_user_meta($user_id, 'budget', $params['budget']);
        
        add_user_meta($user_id, 'phone_number', $params['phone_number']);
        
        add_user_meta($user_id, 'crm_id', $params['id']);

        add_user_meta($user_id, 'crm_profile_url', $params['profile_url']);

        $response = [
            'status' => 200,
            'message' => __('User successfully created', 'elegant-lead-gen'),
            'data' => [
                'wp_user_id' => $user_id
            ]
        ];

        return new \WP_REST_Response($response, 200);
    }

    private function setup_hooks() {
        add_action( 'rest_api_init', [ $this, 'register_apis' ] );
    }

    private function __construct() {
        $this->setup_hooks();
    }
}

UserApi::instance();