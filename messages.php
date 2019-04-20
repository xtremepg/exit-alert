<style>
h1 {
    font-size: 23px;
    font-weight: 400;
    margin: 0;
    padding: 9px 0 4px 0;
    line-height: 29px;
}
a {
    margin: 2.5px;
}
.external-link {
    margin-left: 25%;
}
</style>
<?php
global $wpdb;

if (ISSET($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $page_name = $wpdb->prefix . "exit_alert_messages";
    $wpdb->delete($page_name, array('id' => $id));
    echo "<script>window.location.href = 'admin.php?page=messages';</script>";
}

if (ISSET($_POST['page_id'])) {
    $id = $_POST['id'];
    $page_id = $_POST['page_id'];
    $title = $_POST['title'];
    $message = $_POST['message'];
    $page_redirect = $_POST['page_redirect'];
    $table_name = $wpdb->prefix . "exit_alert_messages";
    if(!empty($id)){
        $wpdb->update($table_name, array('title' => $title, 'message' => $message, 'page_id' => $page_id, 'page_redirect' => $page_redirect), array('id' => $id));
    }else{
        $sql = $wpdb->get_results('SELECT id FROM '.$table_name.' WHERE page_id='.$page_id.' LIMIT 1');
        if(empty($sql)) {
            $wpdb->insert($table_name, array('title' => $title, 'message' => $message, 'page_id' => $page_id, 'page_redirect' => $page_redirect));
        } else {
            ?>
                <script>
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You already have a message for this page! Please select other page to continue.',
                    })
                </script>
            <?php
        }
    }
}
?>
<div class="row">
    <div class="container">
        <div class="col-md-12">
            <h1 class="mb-2">Messages</h1>
            <form class="form" method="post">
                <input type="hidden" name="id" id="id" />
                <div class="form-group">
                    <label for="page_id" class="label-control">Page</label>
                    <?php wp_dropdown_pages() ?>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label" for="message">Message</label>
                    <textarea name="message" id="message" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label" for="page_redirect">Page to redirect</label>
                    <input type="text" name="page_redirect" id="page_redirect" class="form-control">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="container">
        <div class="col-md-12">
            <h1 class="mb-2">Your messages</h1>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Page</th>
                        <th>Page Redirect</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $charset_collate = $wpdb->get_charset_collate();
                            $page_name = $wpdb->prefix . "exit_alert_messages";
                            $sql = "SELECT * FROM $page_name";
                            $messages = $wpdb->get_results($sql);
                            foreach($messages as $message) {
                                ?>
                                    <tr>
                                        <td><?php echo $message->title ?></td>
                                        <td><?php echo $message->message ?></td>
                                        <td><?php echo get_post($message->page_id)->post_name ?></td>
                                        <td>
                                            <a target="_BLANK" href="http://<?php echo $message->page_redirect ?>" class="btn btn-sm btn-success external-link"><i class="fas fa-external-link-alt"></i></a>
                                        </td>
                                        <td>
                                            <a href="#" onClick='editMessage(<?php print_r(json_encode($message)) ?>)' class="btn btn-sm btn-info"><i class="far fa-edit"></i></a>
                                            <a href="#" onClick="deleteMessage(<?php echo $message->id ?>)" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#page_id').addClass("form-control");
    });

    function deleteMessage(id) {
        window.location.href = 'admin.php?page=messages&action=delete&id=' + id;
    }

    function editMessage(message) {        
        $('#id').val(message.id);
        $('#page_id').val(message.page_id);
        $('#title').val(message.title);
        $('#message').val(message.message);
        $('#page_redirect').val(message.page_redirect);
    }
</script>