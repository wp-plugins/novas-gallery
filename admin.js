jQuery(document).ready(function($){
 
 
    var custom_uploader;
 
 
    $('#upload_image_button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery.ajax('admin.php?page=NGAdmin.php&type=local&action=add&id='+attachment.url)
			jQuery(".media-frame").html('<h2 class="reload-msg">Please Wait for Page to Reload...</h2>')
			$(document).ajaxSuccess(function() {
				document.location.reload(true)
			})
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
 
 
});