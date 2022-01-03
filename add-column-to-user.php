<?php

namespace ElegantLeadGen;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class AddColumnToUsers {

    private static $_instance;

    /**
     * @return AddColumnToUsers
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function add_crm_link_column_to_users_table($columns) {

    	$columns['crm_profile_url'] = 'CRM Profile Link';
    	
    	return $columns;
    }

    public function add_content_to_new_crm_link_column( $val, $column_name, $user_id ) {
	    switch ($column_name) {
	        case 'crm_profile_url' :
	        	$link = get_user_meta($user_id, 'crm_profile_url', true);
                
                if (!empty($link)) {
                    return sprintf('<a href="%s">CRM Profile</a>', $link);
                } 

                return '-';
	        default:
	    }
	    return $val;
	}

    private function setup_hooks() {
        add_filter( 'manage_users_columns', [ $this, 'add_crm_link_column_to_users_table' ] );
        add_filter( 'manage_users_custom_column', [ $this, 'add_content_to_new_crm_link_column' ], 10, 3 );
    }

    private function __construct() {
        $this->setup_hooks();
    }

}

AddColumnToUsers::instance();