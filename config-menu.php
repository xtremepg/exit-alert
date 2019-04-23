<?php
function addMenu() {
    add_menu_page("Exit Alert", "Exit Alert", 4, "ea-home", "EAmenu");
    add_submenu_page("ea-home", "EA - Messages", "Messages", 4, "ea-messages", "EAmessages");
}

function EAmenu() {
    loadDependencies();
    ?>
    <div class="row">
        <div class="container">
            <div class="d-flex justify-content-center mb-5 mt-5">
                <img src="<?php echo plugin_dir_url('exit-alert') . 'exit-alert/exit-alert-logo.png' ?>" class="responsive-image"/>
            </div>
            <h1 class="text-center">Exit Alert</h1>
            <h2 class="text-center">Configure messages to show before the users leave your pages.</h2>
        </div>
    </div>
    <?php
}

function EAmessages() {
    loadDependencies();
    require_once __DIR__ . '/messages.php';
}