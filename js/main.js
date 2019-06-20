'use strict'
var SUCCESS = 'OK',
	IMG = '../img/iconos/',
	editor = 1


function loading(e){
	if(e != null){
		if(e){
			$('#loading').fadeIn(150)
		}else{
			$('#loading').fadeOut(150)
		}
	}else{
		$('#loading').hide()
	}
}

function getUrlImage(tema){
	console.log('tema url', tema)
	return 'docente-' + tema.id_docente + '/curso-' + tema.id_curso + '/modulo-' + tema.id_modulo + '/clase-' + tema.id_clase + '/tema-' + tema.id + '/'
}


function $_GET(q,s) {
	s = s ? s : window.location.search;
	var re = new RegExp('&'+q+'(?:=([^&]*))?(?=&|$)','i');
	return (s=s.replace(/^[?]/,'&').match(re)) ? (typeof s[1] == 'undefined' ? '' : decodeURIComponent(s[1])) : undefined;
}


function loadPage(){
	if(exists(window.location.href, 'demo')){
		var dv = $_GET('device'),
			or = $_GET('orientation'),
			clas = ''
		editor = 0
		
		switch(dv){
			// case 'desktop':
			// 	clas = 'demo-desktop'
			// break
			case 'tablet':
				if(or == 'portrait'){
					clas = 'demo-tablet-portrait'
				}else{
					clas = 'demo-tablet-landscape'
				}
				$('.container-fluid')
									.addClass('demo-border')
									.css({
										minHeight: 'inherit', 
										overflowY:'auto'
									})
			break
			case 'smartphone':
				if(or == 'portrait'){
					clas = 'demo-smartphone-portrait'
				}else{
					clas = 'demo-smartphone-landscape'
				}
				$('.container-fluid')
									.addClass('demo-border')
									.css({
										minHeight: 'inherit', 
										overflowY:'auto'
									})
			break
		}
		$('.container-fluid').addClass(clas)
		$('#content-editor').load('editor.php?editor=' + editor + '&device=' + dv + '&orientation=' + or)
	}else{
		var page = $_GET('page') !== undefined ? $_GET('page') : 'temas'
		var params = $_GET('params')
		var post = ''
		if(params != null){
			try{
				params = getJson(params)
				$.each(params, function(i, param){
					if(i == 0){
						post += '?'
					}else{
						post += '&'
					}
					post += param.name + '=' + param.value
						
				})
			}catch(e){}
		}
		ver(['page', page])
		$('#content-editor').load(page + '.php' + post)
	}

}
function goTo(page, params){
	if(exists(window.location.href, 'demo')){
		var dv = $_GET('device'),
			or = $_GET('orientation'),
			clas = ''
		editor = 0
		
		switch(dv){
			// case 'desktop':
			// 	clas = 'demo-desktop'
			// break
			case 'tablet':
				if(or == 'portrait'){
					clas = 'demo-tablet-portrait'
				}else{
					clas = 'demo-tablet-landscape'
				}
				$('.container-fluid')
									.addClass('demo-border')
									.css({
										minHeight: 'inherit', 
										overflowY:'auto'
									})
			break
			case 'smartphone':
				if(or == 'portrait'){
					clas = 'demo-smartphone-portrait'
				}else{
					clas = 'demo-smartphone-landscape'
				}
				$('.container-fluid')
									.addClass('demo-border')
									.css({
										minHeight: 'inherit', 
										overflowY:'auto'
									})
			break
		}
		$('.container-fluid').addClass(clas)
		var par = [
			{name: 'device', value: dv},
			{name: 'orientation', value: or}
		]
		window.location = 'index.html?page=editor&params=' + toJson(par)
		 //$('#content-editor').load('editor.php?editor=' + editor + '&device=' + dv + '&orientation=' + or)
	}else{

		window.location = 'index.html?page=' + page + '&params=' + toJson(params)
	}

	//loading(false)
}


















$(function(){
	editor = 1
	$('#back').click(function(){
		window.history.back()
	})
	loadPage()
})