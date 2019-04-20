<?php
function EA_install() {
	global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . "ea_messages";
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `message` TEXT NOT NULL,
        `page_id` varchar(255) NOT NULL,
        `page_redirect` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`id`) 
        ) $charset_collate ;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}


function EA_uninstall() {
	global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix."ea_messages";
    $sql = "DELETE FROM $table_name";
    $wpdb->query($sql); 
    $sql = $wpdb->get_results('SELECT id FROM '.$table_name.' LIMIT 1');
    if(empty($sql)){
    	$sql = "DROP TABLE IF EXISTS $table_name";
    	$wpdb->query($sql);
    }
}