<?php
function addMenu() {
    add_menu_page("Exit Alert", "Exit Alert", 4, "ea-home", "EAhome");
    add_submenu_page("ea-home", "EA - Messages", "Messages", 4, "ea-messages", "EAmessages");
}

function EAhome() {
    loadDependencies();
    require_once __DIR__ . '/views/home.php';
}

function EAmessages() {
    loadDependencies();
    wp_enqueue_script('ea-messages-js', '/' . PLUGINDIR . '/exit-alert/assets/js/ea-messages.js');
    require_once __DIR__ . '/views/messages.php';
}