<!-- Messages Save, Edit and Delete -->
<?php
    if (ISSET($_GET['action']) && $_GET['action'] == 'delete') {
        ExitAlert::deleteMessage();
    } else if (ISSET($_POST['page_id'])) {
        ExitAlert::saveMessage();
    }
?>
<!-- /Messages Save, Edit and Delete -->
<!-- Messages Form -->
<div class="row m-0 ea">
    <div class="container">
        <div class="col-md-12">
            <h1 class="mb-2">Messages</h1>
            <form class="form" method="post" id="messageForm" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" />
                <div class="form-group">
                    <label for="page_id" class="label-control">Page *</label>
                    <?php wp_dropdown_pages() ?>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="force_redirect" class="control-label">Force Redirect</label>
                            <select class="form-control text-center" name="force_redirect" id="force_redirect">
                                <option value="true">Yes</option>
                                <option value="false" selected>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label" for="page_redirect">Page to redirect</label>
                            <input type="text" name="page_redirect" id="page_redirect" class="form-control" placeholder="www.somesite.com/somepage">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image" class="control-label">Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">Title *</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label" for="message">Message *</label>
                    <textarea name="message" id="message" class="form-control"></textarea>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Confirm Button</label>
                        <div class="row text-center">
                            <div class="col">
                                <div class="form-group">
                                    <label for="show_confirm_button" class="control-laabel">Show</label>
                                    <select class="form-control text-center" name="show_confirm_button" id="show_confirm_button">
                                        <option value="true" selected>Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="color_confirm_button" class="control-laabel">Color</label>
                                    <input id="color_confirm_button" name="color_confirm_button" type="text" class="form-control color-picker" value="rgb(25, 61, 224)" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="btn_confirm_text" class="control-label">Text *</label>
                                    <input type="text" id="btn_confirm_text" name="btn_confirm_text" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label>Cancel Button</label>
                        <div class="row text-center">
                            <div class="col">
                                <div class="form-group">
                                    <label for="show_cancel_button" class="control-label">Show</label>
                                    <select class="form-control text-center" name="show_cancel_button" id="show_cancel_button">
                                        <option value="true" selected>Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="color_cancel_button" class="control-laabel">Color</label>
                                    <input id="color_cancel_button" name="color_cancel_button" type="text" class="form-control color-picker" value="rgb(240, 17, 17)" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="btn_cancel_text" class="control-label">Text *</label>
                                    <input type="text" id="btn_cancel_text" name="btn_cancel_text" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row m-0 mt-5 ea">
    <div class="container">
        <div class="col-md-12">
            <h1 class="mb-2">Your messages</h1>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Page</th>
                        <th>Page Redirect</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach(ExitAlert::getAllMessages() as $message) {
                        ?>
                            <tr>
                                <td><?php echo $message->id ?></td>
                                <td>
                                    <?php
                                        if ($message->image != null && $message->image != '') {
                                            echo '<img class="img-fluid img-thumbnail" src="'. $message->image .'" width="100" height="100"/>';
                                        } else {
                                            echo 'No image';
                                        }
                                    ?>
                                </td>
                                <td><?php echo $message->title ?></td>
                                <td><?php echo $message->message ?></td>
                                <td>
                                    <?php if($message->page_id > 0) {
                                        ?>
                                            <a target="_BLANK" href="<?php echo get_post($message->page_id)->guid ?>"><?php echo get_post($message->page_id)->post_name ?></a>
                                        <?php
                                    } else {
                                        echo 'All pages';
                                    }?>
                                </td>
                                <td>
                                    <?php if ($message->page_redirect != null && $message->page_redirect != '') {
                                        ?>
                                            <a target="_BLANK" href="http://<?php echo $message->page_redirect ?>" class="btn btn-sm btn-success external-link"><i class="fas fa-external-link-alt"></i></a>
                                        <?php
                                    } else {
                                        echo 'No redirect';
                                    }?>
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
<!-- /Messages Form -->