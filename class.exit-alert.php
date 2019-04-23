<?php

class ExitAlert {

    public static function getAllMessages() {
        global $wpdb;
        $sql = "SELECT * FROM ". TABLE_NAME ."";
        return $wpdb->get_results($sql);
    }

    public static function getMessageByPageId($page_id) {
        global $wpdb;
        $sql = "SELECT * FROM ". TABLE_NAME ." WHERE page_id=$page_id LIMIT 1";
        return $wpdb->get_results($sql)[0];
    }

    public static function getMessageToShow($page_id) {
        global $wpdb;
        $message = ExitAlert::getMessageByPageId($page_id);
        if ($message == null) {
            $message = ExitAlert::getMessageByPageId(0);
        }
        return $message;
    }

    public static function saveMessage() {
        global $wpdb;

        $id = $_POST['id'];
        $page_id = $_POST['page_id'];
        $title = $_POST['title'];
        $message = $_POST['message'];
        $page_redirect = $_POST['page_redirect'];
        $btn_confirm_text = $_POST['btn-confirm-text'];
        $btn_cancel_text = $_POST['btn-cancel-text'];
        $image = NULL;

        if (!ExitAlert::checkIfPageAlreadyHaveMessage($id, $page_id)) {
            if ($_FILES['image']['name'] != '') {
                $image = ExitAlert::upload_file($_FILES);
            }
            if (!empty($id)) {
                $wpdb->update(TABLE_NAME, array(
                    'title' => $title,
                    'message' => $message,
                    'page_id' => $page_id,
                    'page_redirect' => $page_redirect,
                    'btn_confirm_text' => $btn_confirm_text,
                    'btn_cancel_text' => $btn_cancel_text),
                    array('id' => $id)
                );
                if ($image != null) {
                    ExitAlert::updateImage($id, $image);
                }
            } else{
                $wpdb->insert(TABLE_NAME, array(
                    'image' => $image,
                    'title' => $title,
                    'message' => $message,
                    'page_id' => $page_id,
                    'page_redirect' => $page_redirect,
                    'btn_confirm_text' => $btn_confirm_text,
                    'btn_cancel_text' => $btn_cancel_text)
                );
            }
        }
    }

    public static function updateImage($id, $image) {
        global $wpdb;
        $wpdb->update(TABLE_NAME, array('image' => $image), array('id' => $id));
    }

    public static function checkIfPageAlreadyHaveMessage($id, $page_id) {
        $message = ExitAlert::getMessageByPageId($page_id);
        if ($message != null && $message->id != $id) {
            ?>
            <script>
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'You already have a message for this page! Please select other page to continue.',
                })
            </script>
            <?php
            return true;
        }
        return false;
    }

    public static function deleteMessage() {
        global $wpdb;
        $id = $_GET['id'];
        $wpdb->delete(TABLE_NAME, array('id' => $id));
        echo "<script>window.location.href = 'admin.php?page=ea-messages';</script>";
    }

    public static function upload_file($files) {
        $target_dir = wp_upload_dir()['path'] . '/';
        $target_file = $target_dir . basename($files["image"]["name"]);
        move_uploaded_file($files["image"]["tmp_name"], $target_file);
        return wp_upload_dir()['url'] . '/' . basename($files["image"]["name"]);
    }
}