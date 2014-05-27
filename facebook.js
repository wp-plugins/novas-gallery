var gallery = function() {
	$("#gallery").html('<div onclick=back() class="gallery-back" id="gallery-back">Back</div><div id="albums" class="gallery-page"></div><div id="album" class="gallery-page"></div><div id="big" style="position:fixed; top:0px; width:100%;"></div>')
	$("#album").hide()
	$("#big").hide()
	$("#albums").hide()
	$("#gallery-back").hide()
	$.getJSON("http://graph.facebook.com/"+id+"/albums?fields=name,cover_photo", function(data) {
		objectCount = data.data.length
		curObject = 0
		output = ''
		while (curObject !=objectCount) {
			if (exclude.indexOf(data.data[curObject].name)==-1) {
				output = output + '<div id="'+data.data[curObject].id+'" onclick=openAlbum("'+data.data[curObject].id+'") ); class="gallery-album"></div>'
				$("#albums").html(output);
				getCover(data.data[curObject].id,data.data[curObject].cover_photo,data.data[curObject].name)
			}
			curObject = curObject + 1
		}
	})
$("#albums").fadeIn(1000)
}
var getCover = function (id,cover,name) {
	$.getJSON("http://graph.facebook.com/"+cover+"/photo?fields=source,width,height", function (source) {
		output = $("#"+id).html()
		if (source.data[0].width < source.data[0].height) {
				style = 'background-size:100% auto; background-image:url('+source.data[0].source+');'
			} else {
				style = 'background-size:auto 100%; background-image:url('+source.data[0].source+');'
			}
		output = output + '<div class="gallery-photo" style="'+style+'"><div class="title">'+name+'</div></div>'
		$("#"+id).html(output)
	})

}
var openAlbum = function(id) {
	$.getJSON("http://graph.facebook.com/"+id+"/photos?fields=source,width,height&limit=50", function (data) {
		objectCount = data.data.length
		curObject = 0
		output = ''
		while(curObject!=objectCount) {
			if (data.data[curObject].width < data.data[curObject].height) {
				style = 'background-size:100% auto; background-image:url('+data.data[curObject].source+');'
			} else {
				style = 'background-size:auto 100%; background-image:url('+data.data[curObject].source+');'
			}
			output = output + '<div class="album-photo" onclick=supersize("'+curObject+'") id="'+curObject+'" style="'+style+'"></div>'
			curObject = curObject +1
		}
		$("#album").html(output)
		
		$("#albums").fadeOut(1000, function () { $("#album").fadeIn(2000), $("#gallery-back").fadeIn(2000) })
		$(document).scrollTop(0);
		
	})
}
var back = function () {
	$("#gallery-back").fadeOut(1000)
	$("#album").fadeOut(1000, function() { $("#albums").fadeIn(2000) })
	$(document).scrollTop(0);
}
var supersize = function (id) {
	if (id==curObject) {
		id=0
	}
	if (id==-1) {
		id = curObject - 1
	}
	source = $("#"+id).css("background-image")
	source = source.replace("url(","")
	source =source.replace(")","")
	source =source.replace('"','')
	source =source.replace('"','')
	next = parseFloat(id) + 1
	last = parseFloat(id) - 1
	$("#big").html('<div class="gallery-big"><div class="big-container"><div class="small" onclick=small()> X </div><input type="button" class="gallery-last" value="<" onclick=supersize("'+last+'")><input type="button" class="gallery-next" value=">" onclick=supersize("'+next+'")><img id="big-image" class="gallery-big" alt="Loading..."></div></div>')
	$("#big-image").attr('src',source)
	$(document).one("keydown",  function (event) {
		if($(".gallery-big").css('display')=='none') {
			return
		}
		if(event.keyCode==39) {
			supersize(next)
		}
		if(event.keyCode==37) {
			supersize(last)
		}
		if (event.keyCode==27) {
			small();
		}
	})	
	$("#big").fadeIn(1000)
}
var small = function () {
	$("#big").fadeOut(1000)
}