<?php
function defineDbName() {
    global $wpdb;
    define('TABLE_NAME', $wpdb->prefix . "ea_messages");
}
function EA_install() {
	global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS ". TABLE_NAME ." (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `image` varchar(255) DEFAULT NULL,
        `title` varchar(255) NOT NULL,
        `message` TEXT NOT NULL,
        `page_id` varchar(255) NOT NULL,
        `force_redirect` bit NOT NULL,
        `page_redirect` varchar(255) DEFAULT NULL,
        `show_confirm_button` BIT NOT NULL,
        `color_confirm_button` VARCHAR(255) NOT NULL,
        `btn_confirm_text` varchar(255) NOT NULL,
        `show_cancel_button` BIT NOT NULL,
        `color_cancel_button` VARCHAR(255) NOT NULL,
        `btn_cancel_text` varchar(255) NOT NULL,
        PRIMARY KEY (`id`) 
        ) $charset_collate ;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}


function EA_uninstall() {
	global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "DELETE FROM ". TABLE_NAME ."";
    $wpdb->query($sql); 
    $sql = $wpdb->get_results('SELECT id FROM '. TABLE_NAME .' LIMIT 1');
    if(empty($sql)){
    	$sql = "DROP TABLE IF EXISTS ". TABLE_NAME ."";
    	$wpdb->query($sql);
    }
}