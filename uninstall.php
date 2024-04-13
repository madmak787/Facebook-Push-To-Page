<?php
delete_option( 'fpp_shortcodes' );

global $wpdb;
$table = $wpdb->prefix . FPP_TABLE;
$table_company = $wpdb->prefix . FPP_TABLE_COMPANY;
$sql = "DROP TABLE IF EXISTS $table";
$wpdb->query( $sql );
$sql = "DROP TABLE IF EXISTS $table_company";
$wpdb->query( $sql );