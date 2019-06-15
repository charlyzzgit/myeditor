'use strict'
var SUCCESS = 'OK',
	IMG = '../img/iconos/'


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






















$(function(){
	var editor = 1
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
		 
	}
	loading(null)
	$('#content-editor').load('editor.php?editor=' + editor + '&device=' + dv + '&orientation=' + or)
})