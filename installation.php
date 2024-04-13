<?php
function fpp_activate() {
	// Register new user role
	$result = add_role(
        'fpp',
        __( 'FPP Author', 'wpspins' ),
        array(
            'read'         => false,
            'edit_posts'   => false,
            'delete_posts' => false,
        )
    );

	// Add shortcode
    $defaults = array( 'companyname', 'city', 'state', 'emailaddress' );
    if( !get_option('fpp_shortcodes') ) {
        add_option( 'fpp_shortcodes', $defaults );
    }

    // Create table for FPP
    global $wpdb;
    $table = $wpdb->prefix . FPP_TABLE;
    $table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
    // Set Charset Collation
    $charset_collate = $wpdb->get_charset_collate();

    // The DB Query
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        `id` int NOT NULL AUTO_INCREMENT,
        `company_id` int NOT NULL,
        `title` varchar(250) NOT NULL,
        `image` varchar(250) NOT NULL,
        `post` longtext NOT NULL,
        `facebook_page_id` varchar(50) NOT NULL,
        `facebook_post_id` varchar(50) NOT NULL,
        `created_date` varchar(250) NOT NULL,
        PRIMARY KEY id (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // The DB Company Query
    $sql_company = "CREATE TABLE IF NOT EXISTS $table_company (
        `id` int NOT NULL AUTO_INCREMENT,
        `title` varchar(250) NOT NULL,
        `facebook_page_id` varchar(250) NOT NULL,
        `facebook_page_name` varchar(250) NOT NULL,
        `facebook_page_token` varchar(250) NOT NULL,
        `shortcodes` longtext NOT NULL,
        `user_id` int NOT NULL,
        `created_date` varchar(250) NOT NULL,
        PRIMARY KEY id (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_company);
}
register_activation_hook( FPP_PLUGIN_FILE, 'fpp_activate' );

function success($str) {
    return '<div class="alert alert-success" role="alert">'.$str.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}

function error($str) {
    return '<div class="alert alert-danger" role="alert">'.$str.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}
