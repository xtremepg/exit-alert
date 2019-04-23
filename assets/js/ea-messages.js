let editor;
jQuery(function($){
    $(document).ready(function() {
        /** CKEditor 5 Init */
        ClassicEditor.create( document.querySelector( '#message' ), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                ]
            }
        })
        .then(newEditor => {
            editor = newEditor
        })
        .catch( error => {
            console.error( error );
        });
        /** //CKEditor 5 Init */
        /** Page Select Init */
        $('#page_id').append('<option value="0">All pages</option>')
        $('#page_id').addClass("form-control");
        /** //Page Select Init */
        /** Form Submit */
        $('#messageForm').submit(function(e) {
            var message = editor.data.get();
            if (message != null && message != '') {
                $(this).submit();
            } else {
                e.preventDefault();
                Swal.fire({
                    position: 'top-middle',
                    type: 'warning',
                    title: 'You need to inform a message',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
        /** //Form Submit */
        /** Select Image */
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        /** Select Image */
    });
});
function deleteMessage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            window.location.href = 'admin.php?page=ea-messages&action=delete&id=' + id;
        }
    })
}
function editMessage(message) {        
    $('#id').val(message.id);
    $('#page_id').val(message.page_id);
    $('#title').val(message.title);
    editor.data.set(message.message);
    $('#page_redirect').val(message.page_redirect);
    $('#btn-confirm-text').val(message.btn_confirm_text);
    $('#btn-cancel-text').val(message.btn_cancel_text);
}