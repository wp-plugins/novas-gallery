var gallery = function() {
	$("#gallery").html('<div id="album" class="gallery-page"></div><div id="big" style="position:fixed; top:0px; width:100%;"></div>')
	$("#album").hide()
	$("#big").hide()
	openAlbum(id)
}
var openAlbum = function(data) {
		data = data.split(',');
		objectCount = data.length
		curObject = 0
		output = ''
		while(curObject!=objectCount) {
			if (data[curObject].width < data[curObject].height) {
				style = 'background-size:100% auto; background-image:url('+data[curObject]+');'
			} else {
				style = 'background-size:auto 100%; background-image:url('+data[curObject]+');'
			}
			output = output + '<div class="album-photo" onclick=supersize("'+curObject+'") id="'+curObject+'" style="'+style+'"></div>'
			curObject = curObject +1
		}
		$("#album").html(output)
		
		$("#album").fadeIn(1000)
		
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