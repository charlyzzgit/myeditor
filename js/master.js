'use strict'
var MODAL,
	SUCCESS = '__OK__',
	EXISTS = '__EXISTS__',
	SCREEN = true,
	EQUIPOS = [],
	LIGAS = [
		{ name: 'BRASIL', num: 1, cola: 'amarillo', colb: 'verde', colc: 'azul'},
		{ name: 'ARGENTINA', num: 2, cola: 'celeste', colb: 'blanco', colc: 'negro'},
		{ name: 'COLOMBIA', num: 3, cola: 'amarillo', colb: 'azul', colc: 'rojo'},
		{ name: 'URUGUAY', num: 4, cola: 'celeste', colb: 'negro', colc: 'blanco'},
		{ name: 'PARAGUAY', num: 5, cola: 'rojo', colb: 'blanco', colc: 'azul'},
		{ name: 'CHILE', num: 6, cola: 'rojo', colb: 'azul', colc: 'blanco'},
		{ name: 'ECUADOR', num: 7, cola: 'amarillo', colb: 'rojo', colc: 'azul'},
		{ name: 'BOLIVIA', num: 8, cola: 'verde', colb: 'amarillo', colc: 'rojo'},
		{ name: 'PERU', num: 9, cola: 'blanco', colb: 'rojo', colc: 'rojo'},
		{ name: 'VENEZUELA', num: 10, cola: 'grana', colb: 'amarillo', colc: 'amarillo'}
	],
	JUECES = [
		'rojo',
		'azul',
		'verde',
		'amarillo',
		'naranja',
		'celeste',
		'violeta',
		'negro',
		'gris',
		'blanco'
	],
	ARQUEROS = [
		'rojo',
		'azul',
		'verde',
		'amarillo',
		'naranja',
		'celeste',
		'verdeclaro',
		'violeta',
		'negro',
		'gris',
		'blanco'
	],
	colores = [],
	MAIN = null,
	TIMERS = [],
	FINPARTIDO = ''

function closeModal(){
	
	$('#f-modal').fadeOut(150, function(){
		$(modal).remove()
		
	});
	$('body').css('overflow', 'auto')
	
}
		
function setModal(size, bar, url, btnclose){

	MODAL = new Modal('', size, url);
	if(!btnclose){
		MODAL.hideClose();
	}
	$('body').css('overflow', 'hidden')
	MODAL.setTitleBar(bar)
	MODAL.openModal();

}


function setTittle(tit, colors){
	var a, 
		b = getColor('blanco')
	$('.titulo').html(tit)
	if(getAjax(tit, 'repechaje')){
		$('.lg-left').attr('src', 'img/copa_sudamericana.png')
		$('.lg-right').attr('src', 'img/copa_libertadores.png')
		a = getColor('naranja')
	}else if(getAjax(tit, 'recopa')){
		$('.logo').attr('src', 'img/recopa.png')
		a = getColor('naranja')
	}else if(getAjax(tit, 'sudamericana')){
		$('.logo').attr('src', 'img/copa_sudamericana.png')
		a = getColor('gris')
	}else if(getAjax(tit, 'libertadores')){
		$('.logo').attr('src', 'img/copa_libertadores.png')
		a = getColor('amarillo')
	}else{
		$('.logo').attr('src', 'img/conmebol.png')
	}
	textColor($('.titulo'), a, b, 2)
}

function getMain(){
	var aj = new AjaxFull()
	aj.addVar('accion', 'main')
	aj.send('master.php', function(r){
		//alert(r)
		MAIN = new main(getJson(r))
		if(FINPARTIDO == 1){
			postPartido()
		}
		
	})
}

	
function main(reg){
	this.anio = reg.anio
	this.copa = reg.copa
	this.fase = reg.fase
	this.fecha = reg.fecha
	this.partido = reg.partido
	this.index = reg.indice
	this.manager = function(avanzar){
		var i = parseInt(this.index),
			aj = new AjaxFull()
			//alert(FINPARTIDO)
		if(FINPARTIDO == 0){

			if(avanzar){
				i++

				switch(i){
					case 0: 
						loading(true)
						aj.addVar('accion', 'newTemporada')
						aj.send('master.php', function(r){
							if(getAjax(r, SUCCESS)){
								irA('ligas', []); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
						

					break;
					case 1:
						loading(true)
						getMain()
						aj.addVar('accion', 'setRecopa')
						aj.send('master.php', function(r){
							if(getAjax(r, SUCCESS)){

								irA('copa', [{clave:'copa', valor:'recopa'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;
					case 2:  //preliminar ida
						loading(true)
						getMain()
						aj.addVar('accion', 'sorteosSudRepe')
						aj.send('master.php', function(r){
							if(getAjax(r, SUCCESS)){

								irA('copa', [{clave:'copa', valor:'sudamericana'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;
					case 3: //repechaje ida
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'libertadores'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;
					case 4: //preliminar vuelta
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'sudamericana'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;
					case 5: //repechaje vuelta
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'libertadores'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;
					case 6: 
						loading(true) //clasificados lib sud
						//getMain()
						aj.addVar('accion', 'clasificadosLibSud')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								//setFooter(res.partido)
								irA('clasificacion', [{clave: 'sudLib', valor: 1}, {clave:'copa', valor:'libertadores'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;
					case 7: //sorteo sud 2/3 - fase de grupos
						loading(true)
						//getMain()
						aj.addVar('accion', 'sud2Grupos')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){

								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'libertadores'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;
					case 8:  //sudamericana fase 2 ida
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'sudamericana'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;

					case 9:  //libertadores 2º fecha
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'libertadores'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})

					break;

					case 10:  //sudamericana fase 2 vuelta
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'sudamericana'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;

					case 11:  //libertadores 3º fecha
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'libertadores'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})

					break;

					case 12:  //libertadores 4º fecha
						loading(true)
						//getMain()
						aj.addVar('accion', 'sud3')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'libertadores'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})

					break;

					case 13:  //sudamericana fase 3 ida
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'sudamericana'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;

					case 14:  //libertadores 5º fecha
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'libertadores'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})

					break;

					case 15:  //sudamericana fase 3 vuelta
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'sudamericana'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;

					case 16:  //libertadores 6º fecha
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'libertadores'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})

					break;

					case 17: //octavos
						loading(true)
						//getMain()
						aj.addVar('accion', 'faseFinal')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){

								setFooter(res.partido)
								irA('segFase', [{clave: 'fase', valor: 2}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;

					case 18:  //sudamericana octavos ida
						loading(true)
						//getMain()
						aj.addVar('accion', 'sigCopa')
						aj.addVar('index', i)
						aj.send('master.php', function(r){
							var res = getJson(r)
							if(getAjax(res.ok, SUCCESS)){
								setFooter(res.partido)
								irA('copa', [{clave:'copa', valor:'sudamericana'}]); 
							}else{
								alert('Error: ' + r)
								loading(false);
							}
						})
					break;


					default: loading(false); break;
				}
			}else{
				switch(i){
					case 0: irA('ligas', []); break;
					case 1: irA('copa', [{clave:'copa', valor:'recopa'}]); break;
					case 2: case 3: case 4: case 5: case 7: case 8: 
					case 9: case 10: case 11: case 12: case 13: case 14:
					case 15: case 16: case 18:
						irA('copa', [{clave:'copa', valor:this.partido.copa}]); 

					break;
					case 6:
						irA('clasificacion', [{clave: 'sudLib', valor: 1}, {clave:'copa', valor:'libertadores'}]); 
					break;
					case 17:
						irA('segFase', [{clave: 'fase', valor: 2}]);  
					break;
					
				}
			}
		}
		
		if(this.partido != null){
			setFooter(this.partido)
		}else{
			ir('index.php?finPartido=1')
		}
		
	}
}

function getParamsUrl(loc){
	var params = []
 	if(loc.indexOf('?') > 0){
        var url = loc.split('?')[1].split('&')
		for(var i = 0; i < url.length; i++){
			params.push({name: url[i].split('=')[0], val: url[i].split('=')[1]})
		}


    }
	return params
}

function getParam(name, params){
	var val = null
	for(var i = 0; i < params.length; i++){
		if(params[i].name == name){
			val = params[i].val;
			break;
		}
	}
	return val
}

function clearTimers(){
	TIMERS.forEach(function(e){
		clearInterval(e)
	})
}


function irA(page, params){
	clearTimers()
	$('.sub-menu').slideUp(150)
	var aj = new AjaxFull()
	loading(true)
	aj.addVar('params', toJson(params))
	aj.send('pages/' + page + '.php', function(r){
		$('#ajax').html(r)
		//loading(false)
	})
}


function loading(view){
	if(view){
		$('.loading').fadeIn(150)
	}else{
		$('.loading').fadeOut(150)
	}
}

function getColor(name){
	var col = null
	for(var i = 0; i < colores.length; i++){
		if(colores[i].name == name){
			col = colores[i];
			break;
		}
	}
	return col
}

function readColores(){
	var aj = new AjaxFull()
	aj.addVar('accion', 'readColores')
	aj.send('master.php', function(r){
		colores = getJson(r)
		setMenu()
	})
}

function setEvents(obj, a, b){
	setGradient($(obj), 0, [a, b, a], [0, 50, 100])
	$(obj).mouseover(function(){
		setGradient($(this), 0, [b, a, b], [0, 50, 100])
	}).mouseout(function(){
		setGradient($(this), 0, [a, b, a], [0, 50, 100])
	}).click(function(evt){
		evt.stopPropagation()
		$(this).parent().slideUp(150)
		var copa = $(this).parent().data('cup'),
			text = $(this).html().toLowerCase()
		irACopa(copa, text)
	})
}

function irACopa(copa, text){
	switch(copa){
		case 'liga':
			if(getAjax(text, 'sudamericana')){
				irA('clasificacion', [{clave: 'copa', valor: 'sudamericana'}])
			}else if(getAjax(text, 'repechaje')){
				irA('clasificacion', [{clave: 'copa', valor: 'repechaje'}])
			}else if(getAjax(text, 'libertadores')){
				irA('clasificacion', [{clave: 'copa', valor: 'libertadores'}])
			}
		break;
	}
}


function setMenu(){
	var ca, cb
	$('menu .menu-item').each(function(){
		$(this).find('i').click(function(evt){
			evt.stopPropagation()
			var parent = $(this).parent(),
				submenu = parent.find('.sub-menu')
			if(submenu.css('display') == 'none'){
				$('.sub-menu').hide()
				submenu.slideDown(250)
			}else{
				submenu.slideUp(250)
			}
		})
		

		if(getAjax($(this).find('b').html().toLowerCase(), 'ligas')){
			ca = getColor('amarillo');
			cb = getColor('crema');
		}else if(getAjax($(this).find('b').html().toLowerCase(), 'recopa')){
			ca = getColor('verde');
			cb = getColor('verdeclaro');
		}else if(getAjax($(this).find('b').html().toLowerCase(), 'sudamericana')){
			ca = getColor('azul');
			cb = getColor('celeste');
		}else if(getAjax($(this).find('b').html().toLowerCase(), 'libertadores')){
			ca = getColor('rojo');
			cb = getColor('naranja');
		}

		setGradient($(this), 180, [ca, cb, ca], [0, 50, 100])
		$(this).data('a', toJson(ca)).data('b', toJson(cb)).mouseover(function(){
			var ca = getJson($(this).data('a')),
				cb = getJson($(this).data('b'))
			setGradient($(this), 180, [cb, ca, cb], [0, 50, 100])
		}).mouseout(function(){
			var ca = getJson($(this).data('a')),
				cb = getJson($(this).data('b'))
			setGradient($(this), 180, [ca, cb, ca], [0, 50, 100])
		}).click(function(evt){
			var text = $(this).find('b').html()
			evt.stopPropagation()
			if(getAjax(text, 'ligas')){
				irA('ligas', [])
			}else if(getAjax(text, 'recopa')){
				irA('copa', [{clave:'copa', valor:'recopa'}]);
			}else if(getAjax(text, 'sudamericana')){
				irA('copa', [{clave:'copa', valor:'sudamericana'}]);
			}else if(getAjax(text, 'libertadores')){
				irA('copa', [{clave:'copa', valor:'libertadores'}]);
			}
			
		})
	}).mouseleave(function(){
		//$('.sub-menu').slideUp(150)
	})
	$('.sub-menu li').each(function(){
		var text = $(this).html().toLowerCase(),
		    b = null,
		    a = null
		if(getAjax(text, 'preliminar') || getAjax(text, 'repechaje')){
			a = getColor('naranja')
			b = getColor('amarillo')
		}else if(getAjax(text, '2')){
			a = getColor('verdeoscuro')
			b = getColor('verde')
		}else if(getAjax(text, '3') || getAjax(text, 'grupos')){
			a = getColor('azuloscuro')
			b = getColor('azul')
		}else if(getAjax(text, 'octavos')){
			a = getColor('amarillo')
			b = getColor('crema')
		}else if(getAjax(text, 'cuartos')){
			a = getColor('verde')
			b = getColor('verdeclaro')
		}else if(getAjax(text, 'semifinal')){
			a = getColor('azul')
			b = getColor('celeste')
		}else if(getAjax(text, 'final') && !getAjax(text, 'semi')){
			a = getColor('rojo')
			b = getColor('naranja')
		}else if(getAjax(text, 'goleadores')){
			a = getColor('celeste')
			b = getColor('cielo')
		}else if(getAjax(text, 'candidatos')){
			a = getColor('violeta')
			b = getColor('rosa')
		}else if(getAjax(text, 'competencia')){
			a = getColor('marron')
			b = getColor('marronclaro')
		}else if(getAjax(text, 'temporada')){
			a = getColor('azul')
			b = getColor('verdeclaro')
		}else if(getAjax(text, 'sudamericana')){
			a = getColor('azul')
			b = getColor('celeste')
		}else if(getAjax(text, 'repechaje')){
			a = getColor('naranja')
			b = getColor('rojo')
		}else if(getAjax(text, 'libertadores')){
			a = getColor('rojo')
			b = getColor('naranja')
		}
		if(a != null && b != null){
			setEvents($(this), a, b)
		}

		$(this).click(function(evt){
			evt.stopPropagation()
			var cup = $(this).parent().data('cup')
			if(getAjax(text, 'preliminar')){
				irA('copa', [{clave:'copa', valor:cup}, {clave:'fase', valor:-1}]);
			}else if(getAjax(text, '2º fase')){
				irA('copa', [{clave:'copa', valor:cup}, {clave:'fase', valor:0}]);
			}else if(getAjax(text, '3º fase')){
				irA('copa', [{clave:'copa', valor:cup}, {clave:'fase', valor:1}]);
			}else if(getAjax(text, 'repechaje')){
				irA('copa', [{clave:'copa', valor:cup}, {clave:'fase', valor:0}]);
			}else if(getAjax(text, 'grupos')){
				irA('copa', [{clave:'copa', valor:cup}, {clave:'fase', valor:1}]);
			}else if(getAjax(text, 'octavos')){
				irA('copa', [{clave:'copa', valor:cup}, {clave:'fase', valor:2}]);
			}else if(getAjax(text, 'cuartos')){
				irA('copa', [{clave:'copa', valor:cup}, {clave:'fase', valor:3}]);
			}else if(getAjax(text, 'semifinales')){
				irA('copa', [{clave:'copa', valor:cup}, {clave:'fase', valor:4}]);
			}else if(getAjax(text, 'final')){
				irA('copa', [{clave:'copa', valor:cup}, {clave:'fase', valor:5}]);
			}else if(getAjax(text, 'goleadores')){
				irA('goleadores', [{clave:'copa', valor:cup}]);
			}else if(getAjax(text, 'general')){
				irA('grupo', [{clave:'grupo', valor:0}, {clave:'copa', valor:cup}, {clave:'fase', valor:1}]);
			}else if(getAjax(text, 'candidatos')){
				irA('grupo', [{clave:'grupo', valor:100}, {clave:'copa', valor:cup}, {clave:'fase', valor:0}]);
			}else if(getAjax(text, 'competencia')){
				irA('competencia', [{clave:'copa', valor:cup}]);
			}
		})
		
	})
}


function readVideos(id_video, url){
	var aj = new AjaxFull()
	aj.addVar('accion', 'readVideos')
	aj.send('master.php', function(r){
		
		var vds = getJson(r),
		    actual = 0
		vol(id_video, 0)
		if(vds != null){
			 var reproductor = document.getElementById(id_video),
			  videos = vds;
			  videos.sort(function() { return 0.5 - Math.random() });
			 reproductor.src = url + videos[actual];
			 try{
			 	reproductor.play();
			 }catch(e){}
			 
			 reproductor.addEventListener("ended", function() {
				 actual++;
				if(actual == videos.length){
					actual = 0;
				}
				this.src = url + videos[actual];
				this.play();
			}, false);
		}
	})
}

function readLigas(liga){

	$('#ligas').empty()
	var aj = new AjaxFull()
	aj.addVar('accion', 'readEquipos')
	aj.addVar('liga', liga)
	aj.send('master.php', function(r){
			//alert(r)
		EQUIPOS = getJson(r)
		swapEscudos()
	})
}

function isRepe(eqs, e){
	var r = false
	for(var i = 0; i < eqs.length; i++){
		if(e.escudo == eqs[i]){
			r = true;
			break;
		}
	}
	return r
}

function getEscudo(eqs){
	var e = EQUIPOS[rd(0, EQUIPOS.length - 1)]
	while(isRepe(eqs, e)){
		e = EQUIPOS[rd(0, EQUIPOS.length - 1)]
		//logs(toJson(e))
	}
	return e
}

function swapEscudos(){
	setInterval(function(){
		var eqs = []
		$('#slider-escudos').fadeOut(150, function(){
			$('#slider-escudos').empty()
			for(var i = 0; i < 10; i++){
				var e = getEscudo(eqs).escudo
				//logs(e)
				eqs.push(e)
				$('#slider-escudos').append('<img class="img-slider" src="' + e + '">')
			}
		}).fadeIn(150)
	}, 5000)
}





function setFooter(partido){
	logs(toJson(partido))
	var balon = '',
		estado = 0,
		colgp = null,
		colfs = null,
		fec,
		grupo
	MAIN.partido = partido
	
	if(partido.finfecha == 0){ //partido != null
		colgp = getColorGrupo(partido.grupo),
		colfs = getColorFase(partido.fase),
		$('.footer-partido').show()
		$('.footer-sig').hide()
		
		balon = 'verde'
		estado = 0
		setLocVis($('.footer-loc'), partido.dataloc, partido)
		setLocVis($('.footer-vis'), partido.datavis, partido)
		if(partido.copa == 'libertadores' && partido.fase == 1){
			fec = partido.fecha + 'ª fecha '
			grupo = 'grupo ' + partido.grupo
		}else{
			grupo = 'llave ' + partido.grupo
			if(partido.fecha == 1){
				fec = 'partido de ida'
			}else{
				fec = 'partido de vuelta'
			}
		}

		$('.footer-gp').html(grupo + '<br/>' + fec)
		try{
			setGradient($('.footer-gp'), 180, [getColor(colgp[0]), getColor(colgp[1]), getColor(colgp[0])], [0, 50, 100])
		}catch(e){
			ir('index.php?finPartido=1')
		}
		
		$('.footer-gp, .footer-fs').css('text-shadow', '2px 2px rgba(0, 0, 0, .2)')
		$('.footer-fs').html(getFase(partido.copa, partido.fase))
		setGradient($('.footer-fs'), 180, [getColor(colfs[0]), getColor(colfs[1]), getColor(colfs[0])], [0, 50, 100])
	}else{
		var left, right,
			sigs = $('#footer').find('.footer-sig')
		$('.footer-partido').hide()
		$('.footer-sig').show()
		balon = 'rojo'
		estado = 1

		switch(parseInt(MAIN.index)){
			case 1:
				left = 'sorteo'
				right = 'sudamericana - repechaje - libertadores';
			break;
			case 2:
				left = 'copa libertadores'
				right = 'repechaje - ida';
				setGradient(sigs[0], 180, [
					getColor('rojo'), 
					getColor('naranja'), 
					getColor('rojo')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('naranja'), 
					getColor('amarillo'), 
					getColor('naranja')], 
					[0, 50, 100])
			break;
			case 3:
				left = 'copa sudamericana'
				right = 'fase preliminar - vuelta';
				setGradient(sigs[0], 180, [
					getColor('azul'), 
					getColor('celeste'), 
					getColor('azul')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('verdeclaro'), 
					getColor('verde'), 
					getColor('verdeclaro')], 
					[0, 50, 100])
			break;
			case 4:
				left = 'copa libertadores'
				right = 'repechaje - vuelta';
				setGradient(sigs[0], 180, [
					getColor('rojo'), 
					getColor('naranja'), 
					getColor('rojo')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('naranja'), 
					getColor('amarillo'), 
					getColor('naranja')], 
					[0, 50, 100])
			break;
			case 5:
				left = 'clasificados'
				right = 'libertadores - sudamericana';
				setGradient(sigs[0], 180, [
					getColor('negro'), 
					getColor('gris'), 
					getColor('negro')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('negro'), 
					getColor('gris'), 
					getColor('negro')], 
					[0, 50, 100])
			break;
			case 6:
				left = 'copa libertadores'
				right = 'fase de grupos';
				setGradient(sigs[0], 180, [
					getColor('rojo'), 
					getColor('naranja'), 
					getColor('rojo')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('azuloscuro'), 
					getColor('azul'), 
					getColor('azuloscuro')], 
					[0, 50, 100])
			break;
			case 7:
				left = 'copa sudamericana'
				right = '2ª fase - partido de ida';
				setGradient(sigs[0], 180, [
					getColor('azul'), 
					getColor('celeste'), 
					getColor('azul')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('naranja'), 
					getColor('rojo'), 
					getColor('naranja')], 
					[0, 50, 100])
			break;
			case 8:
				left = 'copa libertadores'
				right = 'fase de grupos - 2ª fecha';
				setGradient(sigs[0], 180, [
					getColor('rojo'), 
					getColor('naranja'), 
					getColor('rojo')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('azuloscuro'), 
					getColor('azul'), 
					getColor('azuloscuro')], 
					[0, 50, 100])
			break;
			case 9:
				left = 'copa sudamericana'
				right = '2ª fase - partido de vuelta';
				setGradient(sigs[0], 180, [
					getColor('azul'), 
					getColor('celeste'), 
					getColor('azul')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('naranja'), 
					getColor('rojo'), 
					getColor('naranja')], 
					[0, 50, 100])
			break;
			case 10:
				left = 'copa libertadores'
				right = 'fase de grupos - 3ª fecha';
				setGradient(sigs[0], 180, [
					getColor('rojo'), 
					getColor('naranja'), 
					getColor('rojo')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('azuloscuro'), 
					getColor('azul'), 
					getColor('azuloscuro')], 
					[0, 50, 100])
			break;
			case 11:
				left = 'copa libertadores'
				right = 'fase de grupos - 4ª fecha';
				setGradient(sigs[0], 180, [
					getColor('rojo'), 
					getColor('naranja'), 
					getColor('rojo')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('azuloscuro'), 
					getColor('azul'), 
					getColor('azuloscuro')], 
					[0, 50, 100])
			break;
			case 12:
				left = 'copa sudamericana'
				right = '3ª fase - partido de ida';
				setGradient(sigs[0], 180, [
					getColor('azul'), 
					getColor('celeste'), 
					getColor('azul')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('celeste'), 
					getColor('azul'), 
					getColor('celeste')], 
					[0, 50, 100])
			break;

			case 13:
				left = 'copa libertadores'
				right = 'fase de grupos - 5ª fecha';
				setGradient(sigs[0], 180, [
					getColor('rojo'), 
					getColor('naranja'), 
					getColor('rojo')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('azuloscuro'), 
					getColor('azul'), 
					getColor('azuloscuro')], 
					[0, 50, 100])
			break;

			case 14:
				left = 'copa sudamericana'
				right = '3ª fase - partido de vuelta';
				setGradient(sigs[0], 180, [
					getColor('azul'), 
					getColor('celeste'), 
					getColor('azul')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('celeste'), 
					getColor('azul'), 
					getColor('celeste')], 
					[0, 50, 100])
			break;

			case 15:
				left = 'copa libertadores'
				right = 'fase de grupos - 6ª fecha';
				setGradient(sigs[0], 180, [
					getColor('rojo'), 
					getColor('naranja'), 
					getColor('rojo')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('azuloscuro'), 
					getColor('azul'), 
					getColor('azuloscuro')], 
					[0, 50, 100])
			break;

			case 16:
				left = 'clasificacion 2º fase'
				right = 'sudamericana - libertadores';
				setGradient(sigs[0], 180, [
					getColor('amarillo'), 
					getColor('crema'), 
					getColor('amarillo')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('rojo'), 
					getColor('azul'), 
					getColor('rojo')], 
					[0, 50, 100])
			break;

			case 17:
				left = 'copa sudamericana'
				right = 'octavos de final - partido de ida';
				setGradient(sigs[0], 180, [
					getColor('azul'), 
					getColor('celeste'), 
					getColor('azul')], 
					[0, 50, 100])
				setGradient(sigs[1], 180, [
					getColor('amarillo'), 
					getColor('crema'), 
					getColor('amarillo')], 
					[0, 50, 100])
			break;
		}

	//alert(MAIN.index)
		$(sigs[0]).find('b').html(left)
		$(sigs[1]).find('b').html(right)
		TIMERS.push(setInterval(arrows, 500))
		
	}
	$('#go').data('estado', estado)
	$('#go').attr('src', 'img/balls/' + balon + '.png')

}

function arrows(){
	var left = $('.i-arrow-right').css('left')
	
	if(left == '20px'){
		$('.i-arrow-left').animate({right: 50}, 250)
		$('.i-arrow-right').animate({left: 50}, 250)
	}else{
		$('.i-arrow-left').animate({right: 20}, 250)
		$('.i-arrow-right').animate({left: 20}, 250)
	}
}

function setLocVis(obj, eq, part){
	try{
		var a = getColor(eq.loc_a),
			b = getColor(eq.loc_b),
			c = getColor(eq.loc_c)
 		obj.find('b').html(eq.name)
 		setImg(obj.find('.footer-jug'), eq, 'local')
 		setImg(obj.find('.footer-escudo'), eq, 'escudo')

		colBorde(obj, b)
		setGradient(obj, 180, [b, a, a, c], [0, 20, 80, 100])
		if(b != c){
			textColor(obj.find('b'), b, c, 1)
		}else{
			textColor(obj.find('b'), b, a, 1)
		}
		
		
		$(obj).data('partido', toJson(part)).unbind('click').click(function(){
			var par = getJson($(this).data('partido'))
			irA('grupo', [{clave:'copa', valor:par.copa}, {clave:'fase', valor:par.fase}, {clave:'grupo', valor:par.grupo}])
		})
	}catch(e){
		console.log(e)
	}
}

function entrar(){
	$('#contenedor').fadeIn(150)
	$(this).hide()
	MAIN.manager(false)
}

function postPartido(){
	$('#contenedor').fadeIn(150)
	$(this).hide()
	MAIN.manager(false)

	irA('post_partido', []); 
}

function openModalPos(pos, data, obj){
	var reg = getJson(data),
		a = getColor(reg.loc_a),
		b = getColor(reg.loc_b),
		c = getColor(reg.loc_c)
	$('#pos-gral').css({
		top: obj.offset().top - obj.height(),
		left:obj.offset().left + obj.width()
	})

	setImg($('#pos-gral').find('img'), reg, 'escudo')
	$('#pos-gral').find('b').html(pos)
	radialGradient($('#pos-gral'), a, b)
	colBorde($('#pos-gral'), b)
	textColor($('#pos-gral').find('b'), b, c, 2)
	if(b == c){
		textColor($('#pos-gral').find('b'), b, a, 2)
	}
	$('#pos-gral').show()
}

function closeModalPos(){
	$('#pos-gral').hide()
}


$(document).ready(function(){

	getMain()
	readColores()
	
	readLigas('')
	$('.loading, #contenedor, .sub-menu, #progress-bar, #pos-gral').hide()
	

	$(document).keyup(function(e) {

	  if (e.keyCode == 122){ 
	  	entrar()
  	  }
	})

	// $('#enter').click(function(){

	// 	if(!SCREEN){
	// 		var el = document.documentElement, rfs = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen
	// 		rfs.call(el)
	// 		SCREEN = true
	// 		$('#contenedor').fadeIn(150)
	// 		$(this).hide()
	// 		MAIN.manager(false)
	// 	}else{
	// 		SCREEN = false		
	// 		readVideos('reproductor-video', 'videos/')
					
	// 	}
				
	// });
			
	$('#go').click(function(){
		var estado = parseInt($(this).data('estado'))
			
		if(estado == 1){
			MAIN.manager(true)
		}else{

			irA('pre_partido', [{clave:'idp', valor:MAIN.partido.id}]); 
		}
		
	})

	$('.lg-right').click(function(){
		ir('admin/')
	})

	readVideos('reproductor-video', 'videos/')



	//$('#enter').trigger('click')
		
})