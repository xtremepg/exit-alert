<?php
/*
Plugin Name: Exit Alert
Plugin URI:
Description: A Plugin to show an alert before users exit the page
Author: Rogerio Batista
Author URI: https://www.facebook.com/rogeriobatistadev/
Version: 1.0
*/

add_action("admin_menu", "addMenu");

function addMenu() {
    add_menu_page("Exit Alert", "Exit Alert", 4, "exit-alert", "exitAlertMenu");
    add_submenu_page("exit-alert", "Messages", "Messages", 4, "messages", "messagesMenu");
}

function exitAlertMenu() {
    echo "Exit Message";
}

function messagesMenu() {
    echo "Messages";
}

function shortcode_exit_message($atts) {
    $title = $atts['title'];
    $message = $atts['message'];
    ?>
        <style>
            .swal2-title:before {
                content: none;
            }
        </style>
        <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5/dist/sweetalert2.min.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5/dist/sweetalert2.min.js"></script>
        <script>
            jQuery(function($){
                $(document).ready(function() {
                    var messageDisplayed = false;
                    $('body').mouseleave(function(event) {
                        if (event.clientY <= 0 && !Swal.isVisible() && !messageDisplayed) {
                            Swal.fire({
                                title: '<?php echo $title ?>',
                                text: '<?php echo $message ?>',
                                type: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'Não!',
                                confirmButtonText: 'Sim!'
                                }).then((result) => {
                                if (!result.value) {
                                    // Usuário decidiu ficar na página
                                }
                            });
                            messageDisplayed = true;
                        }
                    })
                })
            });
        </script>
    <?php
    return;
}

add_shortcode('exitMessage', 'shortcode_exit_message');