<?php
function loadDependencies() {
    wp_enqueue_style('ea-font-awesome', 'https://use.fontawesome.com/releases/v5.7.0/css/all.css');
    wp_enqueue_style('ea-swal-css', 'https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5/dist/sweetalert2.min.css');
    wp_enqueue_style('ea-bootstrap4-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
    wp_enqueue_style('ea-custom-css', '/' . PLUGINDIR . '/exit-alert/assets/css/ea-custom.css');
    wp_enqueue_style('ea-color-picker-css', '/' . PLUGINDIR . '/exit-alert/vendors/color-picker/css/bootstrap-colorpicker.min.css');

    wp_enqueue_script('ea-jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js');
    wp_enqueue_script('ea-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js');
    wp_enqueue_script('ea-bootstrap4', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
    wp_enqueue_script('ea-swal2', 'https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5/dist/sweetalert2.min.js');
    wp_enqueue_script('ea-ckeditor5', 'https://cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js');
    wp_enqueue_script('ea-color-picker', '/' . PLUGINDIR . '/exit-alert/vendors/color-picker/js/bootstrap-colorpicker.min.js');
}