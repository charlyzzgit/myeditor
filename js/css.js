'use strict'
function getColorChanels(rgba){
	var chanels = []
	try{
		chanels = rgba.split('(')[1].split(')')[0].split(',')
	}catch(e){
		chanels = [255, 255, 255, 1]
	}
	return {
		r: chanels[0],
		g: chanels[1],
		b: chanels[2],
		a: (chanels.length == 4) ? chanels[3]*100 : 100
	}	
	
}

function setMediaEditor(obj, name){
 		OBJ = $(obj)

 		var div = $('#media-editor')
 		div.css({
 			position: 'absolute', 
 			top:OBJ.offset().top, 
 			left:OBJ.offset().left, 
 			width:OBJ.width(),
 			height: OBJ.height(),
 			zIndex:30, 
 			background: 'rgba(0, 0, 0, .8)'
 		})
 		div.find('button').html(name)

 		div.find('button')
 			.unbind('click')
 			.click(function(evt){
 				evt.stopPropagation()
		 		setMenu(OBJ.prop('tagName').toLowerCase())
		 		$(this).parent().hide()
				openEditor(true)
 			})
 		div.mouseleave(function(){
	 			$(this).hide()
	 		}).show()
 		
 	}

function cssExists(sty, val){
	return (sty.search(val) != -1) ? true : false
}

function getShadow(shadow){
	if(shadow == null || shadow == 'none'){
		return {
			color: getColorChanels('rgba(0,0,0,1)'),
			x: 0,
			y: 0,
			blur: 0
		}
	}
	var rgba = getColorChanels(shadow),
		params = shadow.split(' '),
		sx = params[params.length - 3],
		sy = params[params.length - 2],
		sblur = params[params.length - 1]
	return {
		color: rgba,
		x: sx.split('px')[0],
		y: sy.split('px')[0],
		blur: sblur.split('px')[0]
	}
}

function getRadius(rad){
	var radius = {
		topLeft:0,
		topRight:0,
		bottomRight:0,
		bottomLeft:0,
		radius:0
	}
	try{
		var corners = rad.split(' ')
		
		switch(corners.length){
			case 1:
				radius.topLeft = corners[0].split('px')[0]
				radius.topRight = corners[0].split('px')[0]
				radius.bottomRight = corners[0].split('px')[0]
				radius.bottomLeft = corners[0].split('px')[0]
				radius.radius = corners[0].split('px')[0]
			break
			case 2:
				radius.topLeft = corners[0].split('px')[0]
				radius.topRight = corners[1].split('px')[0]
				radius.bottomRight = corners[0].split('px')[0]
				radius.bottomLeft = corners[1].split('px')[0]
				radius.radius = 0
			break
			case 3:
				radius.topLeft = corners[0].split('px')[0]
				radius.topRight = corners[1].split('px')[0]
				radius.bottomRight = corners[2].split('px')[0]
				radius.bottomLeft = corners[1].split('px')[0]
				radius.radius = 0
			break
			case 4:
				radius.topLeft = corners[0].split('px')[0]
				radius.topRight = corners[1].split('px')[0]
				radius.bottomRight = corners[2].split('px')[0]
				radius.bottomLeft = corners[3].split('px')[0]
				radius.radius = 0
			break
		}
	}catch(e){
		console.log('radius:', e)
		//alert(e)
	}
	return radius
}

function getBorder(element, side, prop){
	var obj = $(element),
		sty = null
	switch(prop){
		case 'color': 
			try{
				sty = obj.css('border-' + side + '-' + prop)
			}catch(e){
				sty = 'rgba(0, 0, 0, 1)'
			}
			if(sty == null){
				sty = 'rgba(0, 0, 0, 1)'
			}
		break
		case 'width': 
			try{
				// var w = parseInt(obj.css('border-' + side + '-' + prop).split('px')[0])
				// switch(w){
				// 	case 1: sty = 'thin'; break;
				// 	case 3: sty = 'medium'; break;
				// 	case 5: sty = 'thick'; break;
				// 	default: sty = 'none'; break;
				// }
				sty = parseInt(obj.css('border-' + side + '-' + prop).split('px')[0])

			}catch(e){
				console.log('border exception', e)
				sty = 0 //'none'
			}
			if(sty == null){
				sty = 0
			}
		break
		case 'style': 
			try{
				sty = obj.css('border-' + side + '-' + prop)
			}catch(e){
				sty = 'none'
			}
			if(sty == null){
				sty = 'none'
			}
		break
	}
	return sty
}

function getStyle(element, prop){
	var obj = $(element),
		sty = null
	switch(prop){
		case 'fontFamily': 
			try{
				sty = obj.data('font')
			}catch(e){
				sty = 0
			}
		break
		case 'fontSize': 
			try{
				sty = obj.css('fontSize').split('px')[0]
			}catch(e){
				sty = 16
			}
		break
		case 'fontStyle': 
			try{
				sty = obj.css('fontStyle')
			}catch(e){
				sty = 'normal'
			}
		break
		case 'fontWeight': 
			try{
				sty = obj.css('fontWeight')
			}catch(e){
				sty = 'normal'
			}
		break
		case 'color': 
			try{
				sty = getColorChanels(obj.css('color'))
			}catch(e){
				sty = getColorChanels(null)
			}
		break
		case 'letterSpacing': 
			try{
				sty = obj.css('letterSpacing').split('px')[0]
			}catch(e){
				sty = 0
			}
		break
		case 'lineHeight': 
			try{
				sty = obj.css('lineHeight').split('px')[0]
			}catch(e){
				sty = 1
			}
		break
		case 'textTransform': 
			try{
				sty = cssExists(obj.css('textTransform'), 'none') ? 'none': obj.css('textTransform')
			}catch(e){
				sty = 'none'
			}
		break
		case 'textDecoration': 
			try{
				sty = cssExists(obj.css('textDecoration'), 'none') ? 'none': obj.css('textDecoration')
			}catch(e){
				sty = 'none'
			}
		break
		case 'textShadow': 
			try{
				sty = getTextShadow(obj)//getShadow(obj.css('textShadow'))
			}catch(e){
				sty = getTextShadow(null)
			}
		break
		case 'boxShadow': 
			try{
				sty = getShadow(obj.css('boxShadow'))
			}catch(e){
				sty = getShadow(null)
			}
		break
		case 'borderColor': 
			try{
				sty = getColorChanels(obj.css('borderColor'))
			}catch(e){
				sty = getColorChanels(null)
			}
		break
		case 'borderWidth': 
			sty = 'thin'
			try{
				switch(parseInt(obj.css('borderWidth').split('px')[0])){
					case 1 : sty = 'thin'; break;
					case 3 : sty = 'medium'; break;
					case 5 : sty = 'thick'; break;
				}
				
			}catch(e){
				
			}
		break
		case 'borderStyle': 
			try{
				sty = obj.css('borderStyle')
			}catch(e){
				sty = 'none'
			}
		break

		case 'borderRadius': 
			
			sty = getRadius(obj.css('borderRadius'))
			
		break
		case 'backgroundColor': 
			try{
				//sty = getColorChanels(obj.css('backgroundColor'))
				sty = obj.css('backgroundColor')
			}catch(e){
				sty = 'rgba(255, 255, 255, 1)'
			}
		break
		case 'background':

			var bg = obj.css('background'),
				bkg = ''
			if(bg.indexOf('gradient') != -1){
				bkg = bg.split(' repeat')[0].split('gradient')[1]
				if(bg.indexOf('linear') != -1){
					sty = 'linear-gradient' + bkg
				}else{
					sty = 'radial-gradient' + bkg
				}
			}else{
				//console.log('sty', bg.split(')')[0] + ')')
				sty = bg.split(')')[0] + ')'
			}
			
		break
		case 'height': 
			try{
				sty = parseInt(obj.css('height').split('px')[0])
			}catch(e){
				sty = 1
			}
		break
		case 'listStyle': 
			try{
				sty = obj.css('listStyle').split(' ')[0]
			}catch(e){
				sty = getColorChanels(null)
			}
		break
		case 'textStrokeColor':
			// try{
			// 	sty = getColorChanels(obj.css('textStrokeColor'))
			// }catch(e){
			// 	sty = getColorChanels(null)
			// }
			try{
				sty = obj.css('textStrokeColor')
			}catch(e){
				sty = 'rgba(0, 0, 0, 1)'
			}
		break
		case 'textFillColor':
			// try{
			// 	sty = getColorChanels(obj.css('textFillColor'))
			// }catch(e){
			// 	sty = getColorChanels(null)
			// }
			try{
				sty = obj.css('textFillColor')
			}catch(e){
				sty = 'rgba(0, 0, 0, 1)'
			}
		break
		case 'textStrokeWidth':
			try{
				sty = obj.css('textStrokeWidth').split('px')[0]
			}catch(e){
				sty = 0
			}
		break


		
		

	}
	return sty
}

function getPadding(element, side){
	var obj = $(element)
	try{
		switch(side){
			case 'top': return parseInt(obj.css('paddingTop').split('px')[0]);
			case 'bottom': return parseInt(obj.css('paddingBottom').split('px')[0]);
			case 'left': return parseInt(obj.css('paddingLeft').split('px')[0]);
			case 'right': return parseInt(obj.css('paddingRight').split('px')[0]);
			default:
				var pd = parseInt(obj.css('paddingTop').split('px')[0]) + parseInt(obj.css('paddingBottom').split('px')[0]) + parseInt(obj.css('paddingLeft').split('px')[0]) + parseInt(obj.css('paddingRight').split('px')[0]);
				return Math.round(pd/4)

		}
	}catch(e){
		return 0
	}
}

function getMargin(element, side){
	var obj = $(element)
	try{
		switch(side){
			case 'top': return parseInt(obj.css('marginTop').split('px')[0]);
			case 'bottom': return parseInt(obj.css('marginBottom').split('px')[0]);
			case 'left': return parseInt(obj.css('marginLeft').split('px')[0]);
			case 'right': return parseInt(obj.css('marginRight').split('px')[0]);
			default:
				var pd = parseInt(obj.css('marginTop').split('px')[0]) + parseInt(obj.css('marginBottom').split('px')[0]) + parseInt(obj.css('marginLeft').split('px')[0]) + parseInt(obj.css('marginRight').split('px')[0]);
				return Math.round(pd/4)

		}
	}catch(e){
		return 0
	}
}

function getTextShadow(element){
	var obj = $(element),
		sty = obj.css('text-shadow'),
		shadow = {
			color: 'rgba(0, 0, 0, 1)',
			x: 0,
			y: 0,
			blur: 0
		}
	if(exists(sty, 'px')){
		console.log('sty:', sty)
		var parts = sty.split(') ')[1].split(' '),
			col = sty.split(') ')[0] + ')'
			shadow.color = col
			shadow.x = parts[0].split('px')[0]
			shadow.y = parts[1].split('px')[0]
			shadow.blur = parts[2].split('px')[0]
	}

	return shadow
	
}

function getBoxShadow(element){
	var obj = $(element),
		sty = obj.css('box-shadow'),
		shadow = {
			color: 'rgba(0, 0, 0, 1)',
			inset: false,
			x: 0,
			y: 0,
			blur: 0,
			spread: 0
		}
	if(exists(sty, 'px')){
		var parts = sty.split(' '),
			inset = (exists(sty, 'inset')) ? 1 : 0
		shadow.color = parts[4 + inset]
		shadow.inset = inset != 0 ? true : false
		shadow.x = parts[0 + inset].split('px')[0]
		shadow.y = parts[1 + inset].split('px')[0]
		shadow.blur = parts[2 + inset].split('px')[0]
		shadow.spread = parts[3 + inset].split('px')[0]
	}

	return shadow
	
}

// function getMargin(element, mg){
// 	var m = mg + '-0',
// 		obj = $(element)
// 	for(var i = 0; i <= 5; i++){
// 		var margin = mg + '-' + i
// 		if(obj.hasClass(margin)){
// 			m = margin
// 			break
// 		}
// 	}
// 	return m
// }

// function getPadding(element, pd){
// 	var p = pd + '-0',
// 		obj = $(element)
// 	for(var i = 0; i <= 5; i++){
// 		var padding = pd + '-' + i
// 		if(obj.hasClass(padding)){
// 			p = padding
// 			break
// 		}
// 	}
// 	return p
// }

function getImageSize(img){
	var size = 'small'
	if($(img).hasClass('medium-image')){
		size = 'medium'
	}else if($(img).hasClass('big-image')){
		size = 'big'
	}
	return size
}

function getVideoSize(img){
	var size = 'small'
	if($(img).hasClass('medium-video')){
		size = 'medium'
	}else if($(img).hasClass('big-video')){
		size = 'big'
	}
	return size
}

function addElements(elements, col, smart){
	 	$.each(elements, function(index, el){
	 		var tag = el.tag.toLowerCase(),
	 			obj = null
	 		switch(tag){
	 			case 'span':
	 			case 'h1':
		 		case 'h2':
		 		case 'h3':
		 		case 'h4':
		 		case 'h5':
		 		case 'h6':
				case 'i':
				case 'em':
				case 'small':
				case 'strong':
				case 's':
				case 'cite':
				case 'q':
				case 'u':
				case 'code':
				case 'sup':
				case 'sub':
				case 'var':
				case 'time':
				case 'mark': 
					obj = $('<' + tag + '></' + tag + '>')
					if(smart != ''){
						obj.text(el.content)
					}else{
						obj.html(el.content)
					}
					

				break
				case 'img':
					obj = $('<img>')
					obj.prop('src', el.url)
				break
				case 'a':
					obj = $('<a></a>')
					obj
						.prop('href', el.url)
						.text(el.content)
						.data('type', el.link)
						.data('url', el.url)
						.click(function(evt){
							evt.preventDefault()
							if(EDITOR == 0){
								window.open($(this).data('url'), "_blank")
							}
						})
				break
				case 'table':
					ver(['table', el.content])
					obj = getTable(el.content)
				break
				case 'ul':
					
					obj = getList(el.content)
					
				break

				case 'audio':
					obj = $('<audio controls class="audio-small d-block">\
						Su Navegador no soporta Audio.\
						</audio>')
					if(EDITOR != 0){
		 				obj.mouseenter(function(){
		 					setMediaEditor($(this), 'Editar')
		 				})
		 			}
		 			obj.prop('src', el.url)
				break
				case 'iframe':
	 				obj = $('<iframe frameborder="0" class="video video-small" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>')
	 				if(EDITOR != 0){
		 				obj.mouseenter(function(){
		 					setMediaEditor($(this), 'Editar')
		 				})
		 			}
		 			obj.prop('src', el.url)
	 			break

	 		}
	 		if(EDITOR != 0){
		 		obj
		 			.prop('id', 'element-' + el.id)
		 			.addClass('editable')
		 			.data('toggle','tooltip')
				    .prop('title', 'Click para Editar ' + obj.prop('tagName'))
				    .tooltip()
				}
			obj.addClass(el.clases)
	 		setCss(obj, el.estilos)
	 		if(tag == 'table'){
	 			var tb = obj
	 			obj = $('<div class="col-12 scroll-table"></div>')
	 			obj.append(tb)
	 		}
	 		col.append(obj)
	 	})
	 }

function getList(list){
	var ul = $('<ul></ul>')
	if(list == null){
		for(var i = 1; i <= 3; i++){
 			var li = $('<li class="flex-row-start-center"></li>')
 			li.append('<i class="fa fa-circle"></i>')
 			li.append('<span class="ml-2"></span>')
 			li.find('span').text('Item ' + i)
 			ul.append(li)
 		}
	}else{
		$.each(list.items, function(i, data){
			var li = $('<li class="flex-row-start-center"></li>')
			li.append('<i></i>')
 			li.append('<span></span>')
 			li.find('span').text(base64Decode(data.text))
 			li.find('i').addClass(data.icon)
 			ul.append(li)
		})

		setCss(ul.find('span'), list.estilos_text)
		setCss(ul.find('i'), list.estilos_icon)
		ul.find('span').addClass(list.class_text)
		ul.find('i').addClass(list.class_icon)
	}
	ul.data('elem', 'span')
	return ul
}
function getTable(tb){

	var table = $('<table class="table"><thead></thead><tbody></tbody></table>')
	if(tb == null){
		for(var i = 0; i < 4; i++){
			var tr = $('<tr></tr>')
			for(var j = 0; j < 3; j++){
				var td = i == 0 ? $('<th></th>') : $('<td></td>')
				if(i == 0){
					td.html('<span id="0">Columna ' + (j + 1) + '</span>')
				}

				tr.append(td)
			}
			if(i == 0){
				table.find('thead').append(tr)
			}else{
				table.find('tbody').append(tr)
			}
		}
	}else{
		$.each(tb, function(i, row){
			var tr = $('<tr></tr>')
			$.each(row.cells, function(j, cell){
				var td = (i == 0) ? $('<th></th>') : $('<td></td>')
				$.each(cell.elements, function(e, el){
					cell.elements[e].content = base64Decode(el.content)
				})
				addElements(cell.elements, td, 'table')
				setCss(td, cell.estilos)
				td.addClass(cell.clases)
				tr.append(td)
			})
			if(i == 0){
				table.find('thead').append(tr)
			}else{
				table.find('tbody').append(tr)
			}
		})

		if(EDITOR != 0){
				table.find('th span')
 								.addClass('editable')
 								//.prop('id', 'element-0')
					 			.data('toggle','tooltip')
								.prop('title', 'Click para Editar Texto')
								.tooltip()
								.data('only-text', 1)
					 			// .click(function(evt){
							 	// 	evt.stopPropagation()
							 	// 	OBJ = $(this)

							 	// 	setMenu('title')
							 		
									// openEditor(true)
							 	// })

 				table.find('th, td')
 								.addClass('editable')
 								//.prop('id', 'element-0')
					 			.data('toggle','tooltip')
								.prop('title', 'Click para Insertar Contenido')
								.tooltip()
					 			.click(function(evt){
							 		evt.stopPropagation()
							 		OBJ = $(this)

							 		setMenu(OBJ.prop('tagName').toLowerCase())
							 		
									openEditor(true)
							 	})
			}
	}

	return table
}

function getLink(obj){
	return {
		type: obj.data('type'), 
		text: obj.text(),
		url: obj.prop('href'),
		view: getLinkStyle(obj)
	}
}

function getLinkStyle(obj){
	var sty = null
	try{
		if($(obj).hasClass('btn-primary')){
			sty = 'primary'
		}else if($(obj).hasClass('btn-secondary')){
			sty = 'secondary'
		}else if($(obj).hasClass('btn-dark')){
			sty = 'dark'
		}else if($(obj).hasClass('btn-light')){
			sty = 'light'
		}else if($(obj).hasClass('btn-info')){
			sty = 'info'
		}else if($(obj).hasClass('btn-success')){
			sty = 'success'
		}else if($(obj).hasClass('btn-warning')){
			sty = 'warning'
		}else if($(obj).hasClass('btn-danger')){
			sty = 'danger'
		}if($(obj).hasClass('btn-outline-primary')){
			sty = 'outline-primary'
		}else if($(obj).hasClass('btn-outline-secondary')){
			sty = 'outline-secondary'
		}else if($(obj).hasClass('btn-outline-dark')){
			sty = 'outline-dark'
		}else if($(obj).hasClass('btn-outline-light')){
			sty = 'outline-light'
		}else if($(obj).hasClass('btn-outline-info')){
			sty = 'outline-info'
		}else if($(obj).hasClass('btn-outline-success')){
			sty = 'outline-success'
		}else if($(obj).hasClass('btn-outline-warning')){
			sty = 'outline-warning'
		}else if($(obj).hasClass('btn-outline-danger')){
			sty = 'outline-danger'
		}
	}catch(e){}
	return sty
}

function setCss(obj, styles){
	//alert(toJson(styles))
	try{
		for(var i = 0; i < styles.length; i++){
			if(styles[i].name == 'src'){
				$(obj).attr('src', styles[i].value)
			}else if(styles[i].name == 'href'){
				$(obj).attr('href', styles[i].value)
			
			}else if(styles[i].name == 'target'){
				$(obj).attr('target', styles[i].value)
			
			}else if(styles[i].name == 'type'){
				$(obj).attr('type', styles[i].value)
			
			}else{
				$(obj).css(styles[i].name, (styles[i].name == 'fontFamily') ? fuentes[styles[i].value] : styles[i].value)
				if(styles[i].name == 'fontFamily'){
					//alert('jijiji')
					$(obj).data('font', styles[i].value)
				}
			}
			//ver(['prop', styles[i].name, styles[i].value])
		}
		//console.log('setcss id:', $(obj).prop('id'))
	}catch(e){
		console.log('setcss error:', e)
	}
}