<?php
function shortcode_exit_message() {
    global $wpdb;
    loadDependencies();
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
                                type: 'question',
                                html: '<?php echo $message->message ?>',
                                backdrop: false,
                                showCloseButton: false,
                                focusConfirm: false,
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'No!',
                                confirmButtonText: 'Yes!'
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