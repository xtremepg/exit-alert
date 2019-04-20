<?php
/*
Plugin Name: Exit Alert
Plugin URI:
Description: A Plugin to show an alert before users exit the page
Author: Rogerio Batista
Author URI: https://www.facebook.com/rogeriobatistadev/
Version: 1.0
*/

function loadjQuery() {
    ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <?php
}

function loadSwal2() {
    ?>
    <style>
        .swal2-title:before {
            content: none;
        }
    </style>
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5/dist/sweetalert2.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5/dist/sweetalert2.min.js"></script>
    <?php
}

function loadBootstrap4() {
    ?>
     <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 
    <?php
}

function loadFontAwesome5() {
    ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <?php
}

function install_exit_alert() {
	global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . "exit_alert_messages";
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
register_activation_hook( __FILE__, 'install_exit_alert' );

function uninstall_exit_alert() {
	global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix."exit_alert_messages";
    $sql = "DELETE FROM $table_name";
    $wpdb->query($sql); 
    $sql = $wpdb->get_results('SELECT id FROM '.$table_name.' LIMIT 1');
    if(empty($sql)){
    	$sql = "DROP TABLE IF EXISTS $table_name";
    	$wpdb->query($sql);
    }
}
register_deactivation_hook(__FILE__, 'uninstall_exit_alert');

function addMenu() {
    add_menu_page("Exit Alert", "Exit Alert", 4, "exit-alert", "exitAlertMenu");
    add_submenu_page("exit-alert", "Messages", "Messages", 4, "messages", "messagesMenu");
}

function exitAlertMenu() {
    echo "<h1><center>Exit Alert</center></h1>";
    echo "<h2><center>Configure messages to show before the users leave your pages.</center></h2>";
}

function messagesMenu() {
    loadBootstrap4();
    loadFontAwesome5();
    loadSwal2();
    require_once __DIR__ . '/messages.php';
}

add_action("admin_menu", "addMenu");

function shortcode_exit_message() {
    global $wpdb;
    loadjQuery();
    loadSwal2();
    $page_id = get_queried_object_id();
    $charset_collate = $wpdb->get_charset_collate();
    $page_name = $wpdb->prefix . "exit_alert_messages";
    $sql = "SELECT * FROM $page_name WHERE page_id=$page_id LIMIT 1";
    $message = $wpdb->get_results($sql)[0];

    if ($message != null) {
        ?>
            <script>
                jQuery(function($){
                    $(document).ready(function() {
                        var messageDisplayed = false;
                        $('body').mouseleave(function(event) {
                            if (event.clientY <= 0 && !Swal.isVisible() && !messageDisplayed) {
                                Swal.fire({
                                    title: '<?php echo $message->title ?>',
                                    text: '<?php echo $message->message ?>',
                                    type: 'question',
                                    backdrop: false,
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    cancelButtonText: 'Não!',
                                    confirmButtonText: 'Sim!'
                                    }).then((result) => {
                                    if (result.value) {
                                        var page_redirect = '<?php echo $message->page_redirect ?>';
                                        if (page_redirect != null && page_redirect != '') {
                                            if (page_redirect.indexOf('http') == -1) {
                                                page_redirect = 'http://' + page_redirect;
                                            }
                                            window.location.href = page_redirect;
                                        }
                                    } else {
                                        messageDisplayed = true;
                                    }
                                });
                            }
                        })
                    })
                });
            </script>
        <?php
    }
}

add_shortcode('exitMessage', 'shortcode_exit_message');