var vsn = 0;
function browser(){
	var nav = navigator.userAgent.toLowerCase();
		var navg = '';
		
    if(nav.indexOf("msie") != -1){
        navg = "IE";
    } else if(nav.indexOf("firefox") != -1){
        navg = "Firefox";
    } else if(nav.indexOf("opera") != -1){
        navg = "Opera";
    } else if(nav.indexOf("chrome") != -1){
        navg = "Chrome";
    } else if(nav.indexOf("safari") != -1){
        navg = "Safari";
    }else {
        navg = "Navegador desconocido";
    }
	return navg;
}


function vol(id, n){
	 var v = document.getElementById(id);
  	 v.volume = n/10;	
}

function logs(msj){
	console.log(msj);
}

function validarEmail(email) {
	
	//var email = element.val();
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
        //alert("Error: La dirección de correo " + email + " es incorrecta.");
		//element.focus();
		return false;
	}else{
		return true;
	}

}

/*************************************************************************************modal*****************************************************************/


function blank(url){
	window.open(url, "_blank");
}


function modal(donde, w, h){
	$(donde).append('<div class="modal"></div>');
	var element = $('.modal');
	element.css('position', 'fixed');
	element.css('width', '100%');
	element.css('height','100%');
	element.css('background', 'rgba(0,0,0,.8)');
	element.css('top', 0);
	element.css('left', 0);
	element.css('z-index', 10000);
	var top = (100-h)*0.5; //(window.innerHeight - h)
	var left = (100-w)*0.5;  //(window.innerWidth - w)
	element.append('<div></div>');
	var inner = element.children('div');
	inner.css('position', 'absolute');
	inner.css('width', w + '%');
	inner.css('height', h + '%');
	inner.css('background-color', '#fff');
	inner.css('border-radius', '20px');
	inner.css('z-index', 11000);
	inner.css('top', top + '%');
	inner.css('left', left + '%');
	inner.append('<div></div><div></div>');
	var contenido = inner.children('div:first-child');
	var btn = inner.children('div:last-child');
	contenido.css('width', '90%');
	contenido.css('margin', '0 auto');
	contenido.css('height', '90%');
	contenido.css('overflow-x', 'hidden');
	contenido.css('overflow-y', 'auto');
	btn.css('width', '50px');
	btn.css('height', '10%');
	btn.css('float', 'right');
	btn.css('background-image', 'url(img/del.png)');
	btn.css('background-repeat', 'no-repeat');
	btn.css('background-position', 'center');
	btn.css('background-size', '50%');
	btn.css('cursor', 'pointer');
	btn.click(function(){ element.hide(); });
	element.hide();
}

/***********************************************************************************************************************************************************/
function addElement(donde, html){
	$(donde).append(html);
}

function removeElement(donde, element){
	$(donde).remove($(element));
}

function porcentaje(val, porc){
	return Math.floor(val*porc/100);
}


var normalize = (function() {
  var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç", 
      to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      mapping = {};
 
  for(var i = 0, j = from.length; i < j; i++ )
      mapping[ from.charAt( i ) ] = to.charAt( i );
 
  return function( str ) {
      var ret = [];
      for( var i = 0, j = str.length; i < j; i++ ) {
          var c = str.charAt( i );
          if( mapping.hasOwnProperty( str.charAt( i ) ) )
              ret.push( mapping[ c ] );
          else
              ret.push( c );
      }      
      return ret.join( '' );
  }
 
})();

function quitarAcentos(text){
	var acentos = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç";

    var original = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc";

    for (var i=0; i<acentos.length; i++) {

        text = text.replace(acentos.charAt(i), original.charAt(i));

    }
	return text;

}


function Fecha(){
momentoActual = new Date(); 
	var utc = momentoActual.getTimezoneOffset();//devuelve la diferencia en minutos entre la zona horaria y la pc visitante.
	var anio = momentoActual.getYear();
	var ms = momentoActual.getUTCMonth();
	var numdia = momentoActual.getDate();
	var dia = momentoActual.getDay();
    var hora = momentoActual.getUTCHours(); 
    var minuto = momentoActual.getUTCMinutes(); 
    var segundo = momentoActual.getUTCSeconds();
	switch(ms){
		case 0:
			mes = "Enero";
			break;
		case 1:
			mes = "Febrero";
			break;
		case 2:
			mes = "Marzo";
			break;
		case 3:
			mes = "Abril";
			break;
		case 4:
			mes = "Mayo";
			break;
		case 5:
			mes = "Junio";
			break;
		case 6:
			mes = "Julio";
			break;
		case 7:
			mes = "Agosto";
			break;
		case 8:
			mes = "Septiembre";
			break;
		case 9:
			mes = "Octubre";
			break;
		case 10:
			mes = "Noviembre";
			break;
		case 11:
			mes = "Diciembre";
			break;
	}
	
	switch(dia){
		case 0:
		nomdia = "Domingo";
		break;
		case 1:
		nomdia = "Lunes";
		break;
		case 2:
		nomdia = "Martes";
		break;
		case 3:
		nomdia = "Miércoles";
		break;
		case 4:
		nomdia = "Jueves";
		break;
		case 5:
		nomdia = "Viernes";
		break;
		case 6:
		nomdia = "Sábado";
		break;
	}
	anio = anio + 1900;
	if(minuto < 10){
		cadmin = '0' + minuto;
	}else{
		cadmin = minuto;
	}
	var dif = momentoActual.getTimezoneOffset()/60;
	if(dif < 0){
		dif = -1*dif;
	}
	hora = hora - dif; 
	if(hora < 0){
		hora = hora + 24;
	}
	
	this.tiempo = nomdia + "  " + numdia + " de " + mes + " de " + anio + " / " + hora + ":" + cadmin;
	
	this.dia = nomdia;
	this.numdia = miFormat(numdia, 2);
	this.mes = mes;
	this.nummes = miFormat(ms + 1, 2);
	this.anio = anio;
	this.hora = miFormat(hora, 2);
	this.minuto = miFormat(minuto, 2);
	this.segundo = miFormat(segundo, 2);
	this.calendario = nomdia + "  " + numdia + " de " + mes;
	this.reloj = hora + ":" + cadmin;
	
}

function miFormat(num, digitos){
	var r = '';
	switch(digitos){
		case 2: if(num < 10){ r = '0' + num; }else{ r = num; } break;
		case 3: if(num < 10){ r = '00' + num; }else if(num < 100){ r = '0' + num; }else{ r = num; } break;
	}
	return r;
}


function transicion(id_contenedor, id_generico, vector_fondos, segundos_en_pantalla, segundos_de_transicion){
	var set;
	var pos = 0;
	var ant;
	var id = '';
	var zindex = 100;
	var	maximo = vector_fondos.length;
	for(i = 0; i < maximo; i++){
		id = id_generico + i;
		$('#' + id_contenedor).append('<div id="' + id + '"></div>');
		$('#' + id).css('width','100%');
		$('#' + id).css('height','100%');
		$('#' + id).css('position','absolute');
		$('#' + id).css('top','0');
		$('#' + id).css('left','0');
		$('#' + id).css('background-repeat', 'no-repeat');
		$('#' + id).css('background-position', 'center');
		$('#' + id).css('background-size', 'cover');
		$('#' + id).css('background-image', 'url(img/' + vector_fondos[i] + ')');
		$('#' + id).css('z-index', zindex);
		$('#' + id_generico + i).fadeToggle(0);
		zindex--;
	}
	$('#' + id_generico + '0').fadeToggle(0);
	clearInterval(set);
	set = setInterval(function(){
		ant = pos;
		pos++;
		if(pos >= maximo){
			pos = 0;
		}
		$('#' + id_generico + ant).fadeToggle(1000*segundos_de_transicion);
		$('#' + id_generico + pos).fadeToggle(500*segundos_de_transicion);
	}, 1000*segundos_en_pantalla);
}

function resetTimers(){
	clearInterval(loopknows);
	clearInterval(loopdisp);
	clearInterval(loopdisp1);
	clearInterval(loopdisp2);
	clearInterval(loopdisp3);
	clearInterval(loopdisp4);
	clearInterval(loopdisp5);
	clearInterval(loopservicios);
	
}

function irA(accion){
	//$('.container')
}

function loadPage(r){
	$('.contenedor-ajax').fadeTo(250, 0, function(){
		$('.contenedor-ajax').html(r);
		$('.contenedor-ajax').fadeTo(500, 1);
	});
}




function colorPiker(clase_contenedor_muestra_color, muestra_width, muestra_height, color_default_muestra, funcion_recibe_color){
	//logs('col = ' + color_default_muestra);
	$('.minicolors-swatch-color').css('background-color', color_default_muestra);
	$('.minicolors-theme-bootstrap .minicolors-swatch').css('width', muestra_width + 'px !important');
	$('.minicolors-theme-bootstrap .minicolors-swatch').css('height', muestra_height + 'px !important');
	logs('pik = ' + $('.minicolors-swatch-color').css('background-color'));
	$('.' + clase_contenedor_muestra_color).each( function() {
                $(this).minicolors({
                    control: $(this).attr('data-control') || 'hue',
                    defaultValue: $(this).attr('data-defaultValue') || '',
                    format: $(this).attr('data-format') || 'hex',
                    keywords: $(this).attr('data-keywords') || '',
                    inline: $(this).attr('data-inline') === 'true',
                    letterCase: $(this).attr('data-letterCase') || 'lowercase',
                    opacity: $(this).attr('data-opacity'),
                    position: $(this).attr('data-position') || 'bottom left',
                    change: function(value, opacity) {
						
                        if( !value ) return;
						var col = value;
                        if( opacity ) value += ', ' + opacity;
                        if( typeof console === 'object' ) {
                            console.log('color = ' + col);
							funcion_recibe_color(col);
                        }
                    },
                    theme: 'bootstrap'
                });
			});
}


function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h}
function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16)}
function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16)}
function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16)}
	
	
function isNumeric(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}


function rgb_hex(orig){
 var rgb = orig.replace(/\s/g,'').match(/^rgba?\((\d+),(\d+),(\d+)/i);
 return (rgb && rgb.length === 4) ? "#" +
  ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
  ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
  ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : orig;
}



function tdh(element, h){
	$(element).attr('height', h);
}

function logs(msj){
	console.log(msj);
}


function fontSize(obj, size){
	$(obj).css('font-size', porcentaje(window.innerWidth, size) + 'px');
}

function truncarTxt(txt, cant){
	var r = txt;
	var w = txt.length - cant;
	if(w > 0){
		r = jQuery.trim(txt).substring(0, cant) + "..."
	}
	return r;
	
}

// function abreviar(t, cant){
// 	if(t.length - cant > 0){
// 		var v = t.split(' ');
// 		if(v.length > 1){
// 			//for(i = 1; i < v.length; i++){
// 				var st = v[0];
// 				v[0] = st[0] + '.';
// 			//}
// 			t = v.join(' ');
// 		}
// 	}
// 	return t;
// }

function abreviar(text, lng){
	var res = text
	if(text.length > lng){
		var aux = text.split(' ')
		if(aux[0].length > 3){
			res = aux[0].substring(0,3) + '. '
		}else{
			res = aux[0] + ' '
		}
		
		for(var i = 1; i < aux.length; i++){
			var space = ''
			if(i != 1){
				space = ' '
			}
			res += space + aux[i]
		}
	}

	if(res.length > lng){
		res = aux[0].substring(0,1) + '. '
		for(var i = 1; i < aux.length; i++){
			var space = ''
			if(i != 1){
				space = ' '
			}
			res += space + aux[i]
		}
	}
	return res
}

function colores(c, _3d, _6d, rgb){
	this.col = c;
	this.d3 = _3d;
	this.d6 = _6d;
	this.rgb = hexRgb(_6d);
}

function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h}
function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16)}
function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16)}
function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16)}

function hexRgb(col){
	return  hexToR(col) + ', ' + hexToG(col) + ', ' + hexToB(col);
}

function hex2num(hex) {
	if(hex.charAt(0) == "#") hex = hex.slice(1); //Remove the '#' char - if there is one.
	hex = hex.toUpperCase();
	var hex_alphabets = "0123456789ABCDEF";
	var value = new Array(3);
	var k = 0;
	var int1,int2;
	for(var i=0;i<6;i+=2) {
		int1 = hex_alphabets.indexOf(hex.charAt(i));
		int2 = hex_alphabets.indexOf(hex.charAt(i+1)); 
		value[k] = (int1 * 16) + int2;
		k++;
	}
	return(value);
}

function paleta(){
	var c = 0;
	var vcolor = new Array();
		vcolor[c++]= new colores("rojo",'#F00', "#FF0000");
		vcolor[c++]= new colores("azul",'#00F', "#0000FF");
		vcolor[c++]= new colores("verde","#060", "#006600");
		vcolor[c++]= new colores("amarillo","#EBA80C", "#F9B528");
		vcolor[c++]= new colores("naranja","#F60", "#FF4A1E");
		vcolor[c++]= new colores("celeste","#06F", "#0066FF");
		vcolor[c++]= new colores("verdeclaro","#0C0", "#669900");
		vcolor[c++]= new colores("crema","#FF9", "#FFFF99");
		vcolor[c++]= new colores("rosa","#F39", "#FF3399");
		vcolor[c++]= new colores("azuloscuro","#006", "#000066");
		vcolor[c++]= new colores("verdeoscuro","#030", "#002800");
		vcolor[c++]= new colores("violeta","#609", "#660099");
		vcolor[c++]= new colores("marron","#630", "#572C00");
		vcolor[c++]= new colores("negro","#000", "#000000");
		vcolor[c++]= new colores("blanco","#FFF", "#FFFFFF");
		vcolor[c++]= new colores("gris","#666", "#666666");
		vcolor[c++]= new colores("marronclaro","#AF7907", "#BF6000");
		vcolor[c++]= new colores("cielo","#B7FFFF", "#C1EBFF");
		vcolor[c++]= new colores("morado","#330", "#302903");
		vcolor[c++]= new colores("grana","#8D0535", "#770029");
		vcolor[c++]= new colores("marronoscuro","#2D0000", "#2D0000");
		vcolor[c++]= new colores("btn","#EDEDED", "#EDEDED");
		return vcolor;
}

var vcol = paleta();

function color(col){
	var r = 'transparent';
	for(i = 0; i < vcol.length; i++){
		if(col == vcol[i].col){
			r = vcol[i].d3;
			break;
		}
	}
	
	return r;
}

function color6(col){
	for(i = 0; i < vcol.length; i++){
		if(col == vcol[i].col){
			r = vcol[i].d6;
			break;
		}
	}
	return r;
}


function getRgb(col){
	for(i = 0; i < vcol.length; i++){
		if(col == vcol[i].col){
			r = vcol[i].rgb;
			break;
		}
	}
	return r;
}


function setRgb(r, g, b){
	return 'rgb(' + r + ', ' + g + ', ' + b + ')'
}

function setRgba(obj, r, g, b, a){
	$(obj).css('background', 'rgb(' + r + ', ' + g + ', ' + b + ', ' + a + ')')
}

function colText(obj, a, b, borde){
	$(obj).css('text-fill-color', color(a));
	$(obj).css('text-stroke-color', color(b));
	$(obj).css('text-stroke-width', borde + 'px');
}


function getIpLocal(){
	var r = '';
	var RTCPeerConnection = /*window.RTCPeerConnection ||*/ window.webkitRTCPeerConnection || window.mozRTCPeerConnection;

	if (RTCPeerConnection) (function () {
		var rtc = new RTCPeerConnection({iceServers:[]});
		if (1 || window.mozRTCPeerConnection) {      // FF [and now Chrome!] needs a channel/stream to proceed
			rtc.createDataChannel('', {reliable:false});
		};
		
		rtc.onicecandidate = function (evt) {
			// convert the candidate to SDP so we can run it through our general parser
			// see https://twitter.com/lancestout/status/525796175425720320 for details
			if (evt.candidate) grepSDP("a="+evt.candidate.candidate);
		};
		rtc.createOffer(function (offerDesc) {
			grepSDP(offerDesc.sdp);
			rtc.setLocalDescription(offerDesc);
		}, function (e) { console.warn("offer failed", e); });
		
		
		var addrs = Object.create(null);
		addrs["0.0.0.0"] = false;
		function updateDisplay(newAddr) {
			if (newAddr in addrs) return;
			else addrs[newAddr] = true;
			var displayAddrs = Object.keys(addrs).filter(function (k) { return addrs[k]; });
			r = displayAddrs.join(" or perhaps ") || "n/a";
		}
		
		function grepSDP(sdp) {
			var hosts = [];
			sdp.split('\r\n').forEach(function (line) { // c.f. http://tools.ietf.org/html/rfc4566#page-39
				if (~line.indexOf("a=candidate")) {     // http://tools.ietf.org/html/rfc4566#section-5.13
					var parts = line.split(' '),        // http://tools.ietf.org/html/rfc5245#section-15.1
						addr = parts[4],
						type = parts[7];
					if (type === 'host') updateDisplay(addr);
				} else if (~line.indexOf("c=")) {       // http://tools.ietf.org/html/rfc4566#section-5.7
					var parts = line.split(' '),
						addr = parts[2];
					updateDisplay(addr);
				}
			});
		}
	})(); else {
		r = "<code>ifconfig | grep inet | grep -v inet6 | cut -d\" \" -f2 | tail -n1</code>";
		//alert("In Chrome and Firefox your IP should display automatically, by the power of WebRTCskull.");
	}
	return r;
}

function reloj(){
	var fec = new Fecha();
	$('.fecha').html(fec.tiempo);
	setInterval(function(){
		fec = new Fecha();
		$('.fecha').html(fec.tiempo);
	}, 1000);
}

function fondo(obj, img){
	$(obj).css('background-image', 'url(' + img + ')');
}

function unir(txt){
	return txt.split(' ').join('').toLowerCase();
}

function separar(cadena){
	return cadena.split('270')[0].split('%20').join(' ');
}

function buscarCategoria(id, vec){
	var reg = null;
	for(var i = 0; i < vec.length; i++){
		if(vec[i].id == id){
			reg = vec[i];
			break;
		}
	}
	return reg;
}

function buscarPlato(id, vec){
	var reg = null;
	for(var i = 0; i < vec.length; i++){
		for(var j = 0; j < vec[i].platos.length && reg == null; j++){
			if(vec[i].platos[j].id == id){
				reg = vec[i].platos[j];
				break;
			}
		}
	}
	return reg;
}

function hideShow(obj, h){
	if(h > 0){
		$(obj).css('visibility', 'visible');
	}else{
		$(obj).css('visibility', 'hidden');
	}
	
}


function itemPedido(mesa, idp, idt, foto, precio, nom){
	this.mesa = mesa;
	this.idplato = idp;
	this.iditem = idt;
	this.nom = nom;
	this.cant = 0;
	this.foto = foto;
	this.precio = precio;
	this.total = 0;
	this.sug = '';
	this.calcular = function(cant){
						this.cant = cant;
						this.total = cant*this.precio;
					}
	this.sugerir = function(sug){
						this.sug = sug;
					}
}

function noRepe(vp, p){
	var n = -1;
	for(var i = 0; i < vp.length; i++){
		if(vp[i].idp == p.idp){
			n = i;
			break;
		}
	}
	return n;
}

function Mesa(n){
	this.num = n;
	this.sel = 0;
	this.estado = 0;
	this.idped = -1;
	this.col = function(est){
		switch(est){
			case 0: v = ['btn', 'blanco']; break;
			case 1: v = ['rojo', 'naranja']; break;
			case 2: v = ['verde', 'verdeclaro']; break;
		}
		return v;
	}
	this.setIdp = function(idp){
		this.idped = idp;
	}
}

function mozo(id, nom){
	this.nom = nom;
	this.id = id;
}

function getFechaFormat(){
	 var fec = new Fecha();
	 return fec.nummes + '/' + fec.numdia + '/' + fec.anio + ' ' + fec.hora + ':' + fec.minuto + ':' + fec.segundo;
}

function buscarPlato(nom){
	var im = '';
	f = 0;
	for(var i = 0; i < datos.length && f == 0; i++){
		for(var j = 0; j < datos[i].plat.length && f == 0; j++){
			//alert(datos[i].plat[j].nom + ' = ' + nom);
			if(datos[i].plat[j].nom == nom){
				im = datos[i].plat[j].foto;
				f++;
			}
		}
	}
	return im;
}

function rd(d, h){
		f = 0;
		while(f == 0){
			r = Math.floor(Math.random() * h) + d;
			if(r >= d && r <= h){
				break;
			}
		}
		return r;
	}

function cache(){
	return '?' + rd(0, 1000) + '.' + rd(0, 1000) + '.' + rd(0, 1000) + '.';
}

function bisiesto(anio){
	var r = null;
	if(anio % 4== 0 && anio % 100 != 0 || anio % 400 ==0){
		r = true;
	}else{
		r = false;
	}
	
	return r;
}


function swapVersion(){
	if(vsn == 0){
		hideShow($('.full'), 0);
		$('.fullx').hide();
	}else{
		hideShow($('.full'), 1);
		$('.fullx').show();
	}
}


function buscador(clave, reg){
	var r = false;
	var s = clave.split(' ');
	for(var i = 0; i < s.length; i++){
		if(s[i].length > 3){
			if(normalize(reg.cat.toLowerCase()).search(normalize(s[i].toLowerCase())) != - 1 || normalize(reg.nom.toLowerCase()).search(normalize(s[i].toLowerCase())) != - 1 || normalize(reg.ing.toLowerCase()).search(normalize(s[i].toLowerCase())) != - 1){
				r = true;
				break;
			}
		}
	}
	return r;	
}

function encontrado(clave, vec){
	var r = false;
	for(var i = 0; i < vec.length; i++){
		if(buscador(clave, vec[i])){
			r = true;
			break;
		}
	}
	return r;
}

function ancla(an){
	document.location.href = "#" + an;

}

function setPie(t){
		$('footer').find('.link-pie').each(function(index, element) {
            if($(this).html() == t){
				$('footer').find('.link-pie').css({ 'color': '#fff'});
				$(this).css('color','rgba(0,0,0,.5)');
			}
			
        });
	}
	
function ir(url){
	window.location = url;
}


function getAjax(cad, subcad){
	var res = false;
	if(cad.search(subcad) != -1){
		res = true;
	}
	return res;
}


function flotante(obj, obj_container, div_sup, div_inf, topabs, topfix, width_obj){
	$(window).scroll(function(){
			var entre = $(document).height() - ($(div_sup).height() + $(div_inf).height());
			var newtop = entre - $(obj).height() + $(div_sup).height();
			if($(window).scrollTop()> $(div_sup).position().top + $(div_sup).height() && $(obj).offset().top + $(obj).height() < $($(div_inf)).offset().top || $(window).scrollTop() < $(div_inf).offset().top){
				$(obj).css('position', 'fixed');
				$(obj).css({'top': topfix + 'px','width': width_obj + 'px'});
			}
			
			if($(window).scrollTop() <= $(div_sup).position().top + $(div_sup).height()){
				$(obj).css('position', 'absolute');
				$(obj).css('top', topabs + 'px');
			}
			
			if($(obj).offset().top + $(obj).height() > $(div_inf).offset().top){
				$(obj).css('position', 'absolute');
				var newtop = $(obj_container).height() - 20 - $(obj).height();
				$(obj).css('top', newtop + 'px');
				
				
				
			}
		});
}


function toJson(reg){
	return JSON.stringify(reg);
}

function getJson(jsonObject){
	if(jsonObject == null){
		return null;
	}
	return JSON.parse(jsonObject);
}

function jsonEscape(str)  {
    return str.replace(/\n/g, "\\\\n").replace(/\r/g, "\\\\r").replace(/\t/g, "\\\\t");
}


function menuSel(sel){
	if(sel == 'home'){
		sel = 'inicio';
	}
	$('menu').find('.menu-item').each(function(index, element) {
		
        if(normalize($(this).html().toLowerCase()) == sel){
			$(this).css('background', '#f2f2f2');
			$(this).mouseout(function(){
				$(this).css('background', '#f2f2f2');
			});
		}
    });
}

function unirVec(a, b, oa, ob){
	
	if(oa != 1){
		a = a.reverse()
	}
	if(ob != 1){
		b = b.reverse()
	}
	return a.concat(b)
}


function loadVideo(lista_videos, id_video, url){
	vol(id_video, 0);
	var vds = JSON.parse(lista_videos);
	var actual = 0;
	if(vds != null){
		 var reproductor = document.getElementById(id_video),
		  videos = vds;
		  videos.sort(function() { return 0.5 - Math.random() });
		 reproductor.src = url + videos[actual];
		 reproductor.play();
		 reproductor.addEventListener("ended", function() {
			 actual++;
			if(actual == videos.length){
				actual = 0;
			}
			this.src = url + videos[actual];
			this.play();
		}, false);
	}
		  
}




function base64Encode(data){
	return btoa(data)
}

function base64Decode(data){
	return atob(data)
}


function setVisibility(obj, v){
	if(v){
		$(obj).css('visibility', 'visible')
	}else{
		$(obj).css('visibility', 'hidden')
	}
}

function setBg(obj, col){
	if(col != null){
		$(obj).css('background', 'rgb(' + col.r + ', ' + col.g + ', ' + col.b + ')')
	}else{
		$(obj).css('background', 'transparent')
	}
	
}

function bgCristal(obj, col){
	$(obj).css('background', 'rgba(' + col.r + ', ' + col.g + ', ' + col.b + ', .5)')
}

function setCristalDuo(obj, cola, colb){

	var rgbaA = [cola.r, cola.g, cola.b, .5],
		rgbaB = [colb.r, colb.g, colb.b, .5]
	$(obj).css('background', 'linear-gradient(0deg, rgba(' + rgbaA.join(', ') + '), rgba(' + rgbaB.join(', ') + '))')
}

function setBackDuo(obj, cola, colb){

	var rgbaA = [cola.r, cola.g, cola.b, 1],
		rgbaB = [colb.r, colb.g, colb.b, 1]
	$(obj).css('background', 'linear-gradient(0deg, rgba(' + rgbaA.join(', ') + '), rgba(' + rgbaB.join(', ') + '))')
}



function setGradient(obj, angle, colores, I){
	var bg = 'linear-gradient('
	bg += angle + 'deg'
	for(var i = 0; i < colores.length; i++){
		var col = colores[i]
		bg += ', rgba(' + col.r + ', ' + col.g + ', ' + col.b + ', 1) ' + I[i] + '%'
	}

	bg += ')'
	
	$(obj).css('background', bg)
}

function radialGradient(obj, a, b){
	 var bg = 'radial-gradient(circle,'
	 	 
	bg += 'rgba(' + b.r + ', ' + b.g + ', ' + b.b + ' , 1) 0%, rgba(' + a.r + ', ' + a.g + ', ' + a.b + ' , 1) 80%)'

	$(obj).css('background', bg)
}

function textColor(obj, a, b, borde){
	$(obj).css('text-fill-color', setRgb(a.r, a.g, a.b));
	$(obj).css('text-stroke-color', setRgb(b.r, b.g, b.b));
	$(obj).css('text-stroke-width', borde + 'px');
}

function colBorde(obj, col){
	if(col != null){
		$(obj).css('border-color', setRgb(col.r, col.g, col.b));
	}else{
		$(obj).css('border-color', 'transparent');
	}
}

function getImg(eq, name){
	return 'img/equipos/' + eq.dir + '/' + name + '.png'
}

function setImg(img, eq, name){
	$(img).attr('src', 'img/equipos/' + eq.dir + '/' + name + '.png').error(function(){
		$(this).attr('src', 'img/equipos/' + eq.dir + '/' + name + '.jpg').error(function(){
			$(this).attr('src', 'img/equipos/' + eq.dir + '/' + name + '.gif').error(function(){
				//logs('Error al Cargar Imagen ' + name + ' de ' + eq.name)
				$(this).attr('src', 'img/equipos/' + name + '.png')
			})
		})
	})


	
	
		
	
	
}


function getColorGrupo(gp){
	if(gp == 100){
		gp = 22
	}else if(gp == 200){
		gp = 12
	}
	var col = [
		['negro', 'gris'], // 0 - tab gral
		['rojo', 'naranja'], // 1
		['azul', 'celeste'], // 2
		['verde', 'verdeclaro'], // 3
		['amarillo', 'crema'], // 4
		['naranja', 'piel'], // 5
		['celeste', 'cielo'], // 6
		['verdeclaro', 'morado'], // 7
		['crema', 'blanco'], // 8
		['grana', 'rosa'], // 9
		['azuloscuro', 'azul'], // 10
		['verdeoscuro', 'verde'], // 11
		['marron', 'marronclaro'], // 12
		['rosa', 'violeta'], // 13
		['cielo', 'gris'], // 14
		['morado', 'amarillo'], // 15
		['marronclaro', 'crema'], // 16
		['bordo', 'rojo'], // 17
		['violeta', 'violetaclaro'], // 18
		['turquesa', 'verdeoscuro'], // 19
		['blanco', 'gris'], // 20
		['marronoscuro', 'marron'], // 21
		['violetaclaro', 'rosa'], // 22
		['negro', 'gris'], // 23
		['gris', 'blanco'] // 24
		
	]
	return col[parseInt(gp)]
}

function getColorFase(fs){
	var col =  [
		['verdeclaro', 'verde'],
		['naranja', 'piel'],
		['celeste', 'cielo'],
		['amarillo', 'crema'],
		['verde', 'verdeclaro'],
		['azul', 'celeste'],
		['rojo', 'naranja'],
		['negro', 'gris'], //tb gral
		['violeta', 'rosa'] //candidatos
		['marron', 'marronclaro'], // 9
	]
	
	return col[parseInt(fs) + 1]
}


function getFase(copa, fase){
	var fs = ''
	switch(copa){
		case 'recopa': 
			if(fase == 5){
				fs = 'final';
			}
		break;
		case 'sudamericana':
			switch(parseInt(fase)){
				case -1: fs = 'fase preliminar'; break;
				case 0: fs = '2ª fase'; break;
				case 1: fs = '3ª fase'; break;
				case 2: fs = 'octavos de final'; break;
				case 3: fs = 'cuartos de final'; break;
				case 4: fs = 'semifinales'; break;
				case 5: fs = 'final'; break;
			}
		break;
		case 'libertadores':
			switch(parseInt(fase)){
				case 0: fs = 'repechaje'; break;
				case 1: fs = 'fase de grupos'; break;
				case 2: fs = 'octavos de final'; break;
				case 3: fs = 'cuartos de final'; break;
				case 4: fs = 'semifinales'; break;
				case 5: fs = 'final'; break;
			}
		break;
	}
	return fs
}

function cantGrupos(grupos){
	var c = grupos.length/2

	if(grupos.length != 8){
		if(c < 1){
			c = 1
		}
	}else{
		
	}
	if(grupos[0].copa == 'libertadores' && grupos[0].fase == 1){
		c = grupos.length/4

	}
	return c
}


function getKeyGrup(copa, fase){
	return (copa == 'libertadores' && fase == 1) ? 'grupo' : 'llave'
}

function getIV(copa, fase, fecha){
	return (copa == 'libertadores' && fase == 1) ? fecha + 'ª fecha' : ((fecha == 1) ? 'partido de ida' : 'partido de vuelta')
}

function getImgCup(copa){
	switch(copa){
		case 'libertadores': return 'img/copa_libertadores.png'
		case 'sudamericana': return 'img/copa_sudamericana.png'
		default: return 'img/recopa.png'
	}
}

function setFlag(obj, liga){
	$(obj).attr('src', 'img/ligas/' + liga + '.png')
}

function similColor(col, list){
	var simil = false
	//alert(list[0])
	for(var i = 0; i < list.length; i++){
		console.log(list[i], col)
		if(list[i] == col){
			simil = true;
			break;
		}
	}
	return simil
}

function getArquero(col_loc, col_vis, list_loc, list_vis, a_loc){
	var fin = false,
		a = '',
		c = 0
	while(!fin){
		a = ARQUEROS[rd(0, ARQUEROS.length - 1)]

		if(a != a_loc && a != col_loc && a != col_vis && !similColor(a, list_loc) && !similColor(a, list_vis)){
			break;
		}
		
	}
	return a
}

function getJuez(col_loc, col_vis, list_loc, list_vis, a_loc, a_vis){
	var fin = false,
		j = '',
		c = 0
	while(!fin){
		j = JUECES[rd(0, JUECES.length - 1)]
		//logs('juez: ' + j)
		//console.log(a_loc, a_vis, col_loc, col_vis, similColor(j, list_loc), similColor(j, list_vis))
		if(j != a_loc && j != a_vis && j != col_loc && j != col_vis && !similColor(j, list_loc) && !similColor(j, list_vis)){
			break;
		}
		c++
		if(c > 100){
			j = 'default'
			fin = true
		}

	}
	return j
}


function vestuario(loc, vis, loc_ab, vis_ab){
 	// var loc_ab = getColor(loc.ab),
 	// 	vis_ab = getColor(vis.ab),
 	//alert(toJson(getJson(loc_ab.list)))
 	var loc_list = getJson(loc_ab.list),
 		vis_list = getJson(vis_ab.list),
 		local = 'local',
 		visitante = 'local',
 		arqloc, arqvis, juez,
 		colvis = vis_ab
 	if(loc.ab == vis.ab){
 		visitante = 'visitante'
 		colvis = getColor(vis.vis_a)
 	}else{
 		//console.log('simils', similColor(loc.ab, vis_list), similColor(vis.ab, loc_list))
 		if(similColor(loc.ab, vis_list) || similColor(vis.ab, loc_list)){
 			visitante = 'visitante'
 			colvis = vis.vis_a
 		}
 	}

 	arqloc = getArquero(loc_ab.name, colvis.name, loc_list, vis_list, null)
 	arqvis = getArquero(loc_ab.name, colvis.name, loc_list, vis_list, arqloc)

 	juez = getJuez(loc_ab.name, colvis.name, loc_list, vis_list, arqloc, arqvis)

 	return {loc: local, vis: visitante, aloc: arqloc, avis: arqvis, juez: juez}
}
	
function report(vars){
	console.log(vars.join(','))
}

function allJ(eqs){
	j = 0;
	for(i = 0; i < eqs.length; i++){
		if(eqs[i].j == 6){
			j++;
		}
	}
	return j;
}

function clasiEstado(eqs, eq){
	est = 0;
	if(eqs.length == 2){
		if(eq.j == 2){
			if(eq.pos == 1){
				est = 2;
			}else{
				est = -2;
			}
		}
	}else{
		clasi = 0;
		eli = 0;
		all = allJ(eqs);
		sudclasi = false;
		
			if(all < 4){
				for(i = 0; i < eqs.length; i++){
				
					if(eqs[i].id != eq.id){
						if(parseInt(eq.pts) > parseInt(eqs[i].pts) + (6 - parseInt(eqs[i].j))*3){
							clasi++;
						}
						//logs(eqs[i].name + ' pts = ' + eqs[i].pts + ' > ' + eq.name + ' pts = ' + (parseInt(eq.pts) + (6 - parseInt(eq.j))*3))
						if(parseInt(eqs[i].pts) > parseInt(eq.pts) + (6 - parseInt(eq.j))*3){
							eli++;
						}

						if(i == 3){
							if(parseInt(eq.pts) > parseInt(eqs[i].pts) + (6 - parseInt(eqs[i].j))*3){
								sudclasi = true;
							}
						}
					}
				}
				if(clasi >= 2){
					est = 1;
				}else{ // if(eli >= 2)
					if(eli == 2){
						if(sudclasi){
							est = -1;
						}
						
					}else if(eli == 3){
						est = -2;
					}
				}
			}else{
				var e = -1;
				for(var i = 0; i < eqs.length; i++){
					if(eqs[i].name == eq.name){
						e = i;
						break;
					}
				}
				
					if(e < 2){
						est = 1;
					}else if(e == 2){
						est = -1;
					}else{
						est = -2;
					}
				
			}
		

	}

	return est;
}

function ver(logs){
 	console.log(logs)
 }

 function exists(cadena, subcadena){
 	if(cadena.indexOf(subcadena) != -1){
 		return true
 	}
 	return false
 }

 function isMobile(){
	
	var mobile = {
      Android: function() {
        return navigator.userAgent.match(/Android/i);
      },
      BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
      },
      iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
      },
      Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
      },
      Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
      },
      any: function() {
        return (mobile.Android() || mobile.BlackBerry() || mobile.iOS() || mobile.Opera() || mobile.Windows());
      }
    }

    if(mobile.any() != null){
    	return true
    }

    return false

}

function getRootLocation(dir){
	return window.location.href.split(dir)[0] + dir
}


function unirHasta(vec, n){
	var aux = []
	$.each(vec, function(i, e){
		if(i < n){
			aux.push(e)
		}
	})
	return aux
}

function flexAlign(clas){
	var flex = [
			{name: 'flex-row-start-start', align: 'start', valign: 'start'},
			{name: 'flex-row-start-center', align: 'start', valign: 'center'}, 
			{name: 'flex-row-start-end', align: 'start', valign: 'end'}, 
			{name: 'flex-row-center-start', align: 'center', valign: 'start'},
			{name: 'flex-row-center-center', align: 'center', valign: 'center'}, 
			{name: 'flex-row-center-end',  align: 'center', valign: 'end'},
			{name: 'flex-row-end-start', align: 'end', valign: 'start'},
			{name: 'flex-row-end-center', align: 'end', valign: 'center'}, 
			{name: 'flex-row-end-end', align: 'end', valign: 'end'}, 
			{name: 'flex-row-between-start', align: 'between', valign: 'start'},
			{name: 'flex-row-between-center', align: 'between', valign: 'center'}, 
			{name: 'flex-row-between-end', align: 'between', valign: 'end'}, 
			{name: 'flex-row-around-start', align: 'around', valign: 'start'},
			{name: 'flex-row-around-center', align: 'around', valign: 'center'}, 
			{name: 'flex-row-around-end', align: 'around', valign: 'end'}, 
			{name: 'flex-col-start-start', align: 'start', valign: 'start'}, 
			{name: 'flex-col-start-center', align: 'center', valign: 'start'}, 
			{name: 'flex-col-start-end', align: 'end', valign: 'start'}, 
			{name: 'flex-col-start-between', align: 'between', valign: 'start'},
			{name: 'flex-col-start-around', align: 'around', valign: 'start'},  
			{name: 'flex-col-center-start', align: 'start', valign: 'center'}, 
			{name: 'flex-col-center-center', align: 'center', valign: 'center'}, 
			{name: 'flex-col-center-end', align: 'end', valign: 'center'}, 
			{name: 'flex-col-center-between', align: 'between', valign: 'center'}, 
			{name: 'flex-col-center-around', align: 'around', valign: 'center'}, 
			{name: 'flex-col-end-start',  align: 'start', valign: 'end'},
			{name: 'flex-col-end-center', align: 'center', valign: 'end'}, 
			{name: 'flex-col-end-end', align: 'end', valign: 'end'}, 
			{name: 'flex-col-end-between', align: 'between', valign: 'end'}, 
			{name: 'flex-col-end-around',  align: 'around', valign: 'end'},
			
		]

	for(var i = 0; i < flex.length; i++){
		if(exists(clas, flex[i].name)){
			return flex[i]
		}
	}
	return null
}

