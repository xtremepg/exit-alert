<?php
function addMenu() {
    add_menu_page("Exit Alert", "Exit Alert", 4, "ea-home", "EAmenu");
    add_submenu_page("ea-home", "Messages", "Messages", 4, "ea-messages", "EAmessages");
}

function EAmenu() {
    echo "<h1><center>Exit Alert</center></h1>";
    echo "<h2><center>Configure messages to show before the users leave your pages.</center></h2>";
}

function EAmessages() {
    loadDependencies();
    require_once __DIR__ . '/messages.php';
}