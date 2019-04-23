<?php
function show_ea_message() {
    wp_enqueue_style('ea-swal-css', 'https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5/dist/sweetalert2.min.css');
    wp_enqueue_style('ea-custom-css', '/' . PLUGINDIR . '/exit-alert/assets/css/ea-custom.css');
    wp_enqueue_script('ea-swal2', 'https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5/dist/sweetalert2.min.js');
    $page_id = get_queried_object_id();
    $message = ExitAlert::getMessageToShow($page_id);
    if ($message != null) {
    ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            jQuery(function($){
                var messageDisplayed = false;
                $('body').mouseleave(function(event) {
                    if (event.clientY <= 0 && !Swal.isVisible() && !messageDisplayed) {
                        $('body').append('<div id="overlay"></div>');
                        overlayOn();
                        Swal.fire({
                            title: '<?php echo $message->title ?>',
                            type: 'question',
                            html: '<?php echo $message->message ?>',
                            imageUrl: '<?php echo $message->image ?>',
                            imageHeight: 150,
                            backdrop: false,
                            showCloseButton: false,
                            focusConfirm: false,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: '<?php echo $message->btn_cancel_text ?>',
                            confirmButtonText: '<?php echo $message->btn_confirm_text ?>'
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
                            overlayOff();
                            $('#overlay').remove();
                        });
                    }
                })
            });

            function overlayOn() {
                document.getElementById("overlay").style.display = "block";
            }

            function overlayOff() {
                document.getElementById("overlay").style.display = "none";
            } 
        </script>
    <?php
    }
}