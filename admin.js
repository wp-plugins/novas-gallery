jQuery(document).ready(function($){
 	    function reload() {
		jQuery("#overlay").fadeOut(500)
    var custom_uploader;
 
 
    $('#upload_image_button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
	})
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
		custom_uploader.on('select', function() {
			function addlocal(text, url) {
			var text = jQuery(text)
			text.find('response').each(function(index, element) {
                id = jQuery(this).text()
				addit = '<div class="album-photo"><div class="gallery-photo" style="background:url('+url+');"></div><a href="#" imageid='+id+'" class="local-delete">Remove</a></div'
				jQuery("#local").html(jQuery("#local").html()+addit)
				if(curItem==itemCount-1) {
				jQuery("#overlay").fadeOut(500)
				} else {
					curItem = curItem + 1
					loopIt()
				}
				
            });
		}
			attachment = custom_uploader.state().get('selection').toJSON();
			itemCount = attachment.length
			curItem = 0 
			function loopIt() {
				url = attachment[curItem].url
			jQuery.ajax('admin.php?page=NGAdmin.php&type=local&action=add&id='+url, {async:true, beforeSend: function() { jQuery(".media-modal-close").click(); jQuery("#overlay").fadeIn(500); }, success: function(text) { addlocal(text, url)}})
			}
			if(curItem!=itemCount) {
			loopIt()
			}
        });
 
        //Open the uploader dialog
 jQuery(".local-delete").live('click', event, function() {
	id = jQuery(this).attr('imageid')
	jQuery.ajax('admin.php?page=NGAdmin.php&type=local&action=delete&id='+id, {async:true, beforeSend: function() {jQuery("#overlay").fadeIn(500) }, success: function() { jQuery("#local-"+id).remove(); jQuery("#overlay").fadeOut(500); }
		})
 
	})
	function newfeed (text) {
	var text = jQuery(text)
			text.find('response').each(function(index, element) {
                id = jQuery(this).text()
			})
			text.find('response-types').each(function(index, element) {
                types = jQuery(this).html()
			})
			var addit = '<tr id="feed'+id+'"><form><td><input name="feed" type="text" value="-"></td><td>'+types+'</td><td>[NG id="'+id+'"]</td><td><input type="text" name="exclude" onclick=facebook() value="-"></td><td><input type="submit" value="Save" feedid="'+id+'"><input type="button" class="delete" value="X" feedid="'+id+'"></td></form></tr>'
			jQuery("#feeds").html(jQuery("#feeds").html()+addit);
			reload()
	}
	jQuery("input[value='New Feed']").one('click', event, function() {
		jQuery.ajax('admin.php?page=NGAdmin.php&type=feed&action=new', { async:true, beforeSend: function() { jQuery("#overlay").fadeIn(500) }, success: function(text) { jQuery("#overlay").fadeOut(500);  newfeed(text)}})
		})
	}
	jQuery(".delete").live('click', event, function() {
	id = jQuery(this).attr('feedid')
	jQuery.ajax('admin.php?page=NGAdmin.php&type=feed&action=delete&id='+id, { async:true, beforeSend: function() { jQuery("#overlay").fadeIn(500); }, success: function() { jQuery("#feed"+id).remove(); jQuery("#overlay").fadeOut(500)}})
	})
	jQuery("input[value='Save']").live('click', event, function() {
		id = jQuery(this).attr('feedid')
		var feed = jQuery("#feed"+id+" input[name='feed']").val()
		var type = jQuery("#feed"+id+" select[name='type']").val()
		alert(type)
		var exclude = jQuery("#feed"+id+" input[name='exclude']").val()
		jQuery.ajax('admin.php?page=NGAdmin.php&type=feed&action=save&id='+id+'&feed='+feed+'&source='+type+'&exclude='+exclude, {async:true, beforeSend: function() { jQuery("#overlay").fadeIn(500) }, success: function(text) { jQuery("#overlay").fadeOut(500); console.log(text) }})
	})
	reload()
})