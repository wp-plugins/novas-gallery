jQuery(document).ready(function($){
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
            title: 'Choose Images (CTRL+click to select mutiples)',
            button: {
                text: 'Choose Images'
            },
            multiple: true
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
		custom_uploader.on('select', function() {
			function addlocal(text, url) {
                id = text
				addit = '<div class="album-photo" id="local-'+id+'"><div class="gallery-photo" style="background:url('+url+');"></div><div imageid="'+id+'" class="local-delete">Remove</div></div'
				jQuery("#local").html(jQuery("#local").html()+addit)
				if(curItem==itemCount-1) {
				jQuery("#overlay").fadeOut(500)
				} else {
					curItem = curItem + 1
					loopIt()
				}
				
		}
			attachment = custom_uploader.state().get('selection').toJSON();
			itemCount = attachment.length
			curItem = 0 
			function loopIt() {
				url = attachment[curItem].url
				data = {
					'action': 'NGAdd',
					'id': url
				}
			jQuery.post(ajax_object.ajax_url, data, function(text) { addlocal(text, url)})
			}
			if(curItem!=itemCount) {
			loopIt()
			}
        });
 
        //Open the uploader dialog
 jQuery(".local-delete").live('click', event, function() {
	id = jQuery(this).attr('imageid')
	data = {
		'action':'NGRemove',
		'id': id
	}
	jQuery.post(ajax_object.ajax_url, data, function() { jQuery("#local-"+id).remove(); })
 
	})
	function newfeed (text) {
			text = jQuery(text)
			text.each(function(index, element) {
				if(index==0) {
					id = jQuery(this).text()
				}
				if(index==1) {
					types = jQuery(this).html()
				}
			})
			var addit = '<tr id="feed'+id+'"><form><td><input name="feed" type="text" value="-"></td><td>'+types+'</td><td>[NG id="'+id+'"]</td><td><input type="text" name="exclude" onclick=facebook() value="-"></td><td><input type="submit" value="Save" feedid="'+id+'"><input type="button" class="delete" value="X" feedid="'+id+'"></td></form></tr>'
			jQuery("#feeds").html(jQuery("#feeds").html()+addit);
	}
	jQuery("input[value='New Feed']").one('click', event, function() {
		data = {
			'action':'NGNew'
		}
		jQuery.post(ajax_object.ajax_url, data, function(text) { newfeed(text)})
		})
	jQuery(".delete").live('click', event, function() {
	a = confirm("This can not be undone!")
	if(a==false) {
		return
	}
	id = jQuery(this).attr('feedid')
	data = {
		'id' : id,
		'action': 'NGDelete'
	}
	jQuery.post(ajax_object.ajax_url, data, function() { jQuery("#feed"+id).remove();})
	})
	jQuery("input[value='Save']").live('click', event, function() {
		id = jQuery(this).attr('feedid')
		var feed = jQuery("#feed"+id+" input[name='feed']").val()
		var type = jQuery("#feed"+id+" select[name='type']").val()
		var exclude = jQuery("#feed"+id+" input[name='exclude']").val()
		data = {
			'action': 'NGSave',
			'id': id,
			'feed': feed,
			'type': type,
			'exclude': exclude
		}
		jQuery.post(ajax_object.ajax_url, data, function(text) { alert("Feed Saved") })
	})
})