<?php 
	error_reporting(1);
	require '../php/scripts.php';
	$request = $_REQUEST;
	$editor = getPost($request, 'editor', 0);
	
	$id = getPost($request, 'id', 0);;
	$tema = getTema($id);

	$estilos = getEstilos($tema->id_docente);

	
 ?>

<style>
	
	.main, .columnas{
		list-style: none;
	}

	

	.col-content{
		min-height: 100px;
		padding: 10px;
	}

	.fila{
		padding: 10px;
		margin-bottom: 10px
		border: dotted thin gray;
	}

	

	.info-edit{
		border:dotted thin red;
		height: 20px
	}

	.info-sel{
		border: dotted thin lime;
		height: 20px
	}

	
	#tema{
		padding: 10px;
		min-height: 100vh;
		<?php if($editor != 0){ ?>
			min-height: calc(100vh + 400px);
		<?php } ?>
	}

	

	#modal-galery{
		width:100%;
		height:100%;
		position:fixed;
		top:0;
		left:0;
		background:rgba(0, 0, 0, .9);
		z-index:10000;
		display:none;
	}

	#modal-galery-close{
		position: absolute;
		top:20px;
		right:20px;
		font-size:40px;
		cursor: pointer;
		opacity: .5;
		
	}

	#box-galery{
		height:100%;
	}

	#box-galery img{
		max-width: 80%;
		max-height: 80%;
	}

	#box-galery .fas{
		font-size: 50px;
		opacity: .5;
	}

	#modal-galery-close:hover, #box-galery .fas:hover{
		opacity: 1;
	}

	

	<?php
		
		foreach ($estilos as $key => $estilo) { 
			$important = $estilo->important == 1 ? ' !important' : '';
			print('.'.$estilo->name.'{');
			
			foreach ($estilo->estilos as $key => $css) {
				
				if(!(strpos($css['name'], 'textFill') === false) || !(strpos($css['name'], 'textStroke') === false)){
					print('-webkit-'.toCss($css['name']).': '.$css['value'].$important.'; ');
				}else if(!(strpos($css['name'], 'Family') === false)){
					print(toCss($css['name']).': '.getFontFamily($css['value']).$important.'; ');
			    }else{
					print(toCss($css['name']).': '.$css['value'].$important.'; ');
				}
			}
			print('}');
		}


	?>


</style>
<div id="modal-galery">
	<div id="box-galery" class="col-12 flex-row-between-center p-4">
		<i id="modal-galery-close" class="fa fa-times text-white"></i>
		<i class="arrow fas fa-angle-left text-white" data-dir="-1"></i>
		<img>
		<iframe class="video-gal-medium" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		<i class="arrow fas fa-angle-right text-white" data-dir="1"></i>
	</div>
	
</div>

<div id="tema" class="tema col-12 flex-col-start-start">
	<div class="col-12 flex-row-between-center">
		<h1 id="titulo-tema" class="editable">Titulo Tema</h1>
		
	</div>
	<ul id="filas" class="main col-12 flex-col start-center m-0"></ul>
</div>




 <script>
	var OBJ = null,
		BOX = null,
		ESTILOS = getJson('<?php print(toJson($estilos)); ?>'),
		GALERY = [],
		TEMA = getJson('<?php print(toJson($tema)); ?>'),
		FILES = [] //imagenes y archivos para limpiar en el server
		
	
 	

 	
	 
	 function getColumna(column, n, cols){
	 	var col = $('<li class="column">\
				 		<div class="col-content column-hover col-12 flex-row-start-start flex-wrap"></div>\
				 	</li>'),
	 		id = (column != null) ? column.id : 0,
	 		elements = (column != null) ? column.elements : [],
	 		col_n = ''
	 	col.data('num', (column != null) ? column.numero : n)
	 	col.find('.col-content').data('align', (column != null) ? column.align : 'start')
	 	col.find('.col-content').data('valign', (column != null) ? column.valign : 'start')
	 	col.find('.col-content').data('distribution', (column != null) ? column.distribution : 'wrap')
	 	col.find('.title-col').html('Columna ' + n)
	 	col.data('visible', (column != null) ? column.visible : 1)
	 	col.find('.col-content').prop('id', 'col-' + id)
	 	ver(['column: ', column])
	 	col.find('.edit-col')
	 				   .data('toggle','tooltip')
			           .prop('title', 'Editar Propiedades Columna')
			           .tooltip()
			           .click(function(){
			           		OBJ = $(this).closest('.column').find('.col-content')
			           		BOX = OBJ
			           		setMenu('column')
			           		openEditor(true)
			           })

		col.find('.reset-col')
	 				   .data('toggle','tooltip')
			           .prop('title', 'Restablecer Columna')
			           .tooltip()
			           .click(function(){
			           		OBJ = $(this).closest('.column').find('.col-content')
			           		modalReset.openModal('tools/modalReset.php')
			           })
			
		col.find('.del-col')
	 				   .data('toggle','tooltip')
			           .prop('title', 'Vaciar Columna')
			           .tooltip()
			           .click(function(){
			           		OBJ = $(this).closest('.column').find('.col-content')
			           		var id = OBJ.prop('id')

	 						modalDelete.openModal('modalDelete.php?id=' + id + '&del=column')
			           })
		
		
		
		
		
		
		if(n > cols){
			col.hide()
		}

		if(column != null){	  
			ver(['content', base64Decode(column.content)])        
			col.find('.col-content').html(base64Decode(column.content)) 
	 		setCss(col.find('.col-content'), column.estilos)

	 	}

	 	if(EDITOR != 0){
			setElements(col.find('.col-content'))
		}

	 	if(EDITOR == 0){
	 		col.find('.column-toolbar').remove()
	 	}
	 	return col
	 }

	 function configCols(fila){
	 	var cols = 0,
	 		col_n = 'col-12'
	 	$(fila).find('.column').each(function(){

	 		cols += parseInt($(this).data('visible'))

	 	})
	 	
	 	switch(cols){
			case 1:
				col_n = 'col-12'
			break
			case 2:
				col_n = 'col-12 col-md-6 col-lg-6'
			break
			case 3:
				col_n = 'col-12 col-md-4 col-lg-4'
			break
			case 4:
				col_n = 'col-12 col-md-6 col-lg-3'
			break 
			
		}

		$(fila).find('.column').each(function(){
	 		var col = $(this),
	 			vis = parseInt(col.data('visible'))
	 		col.removeClass('col-md-4 col-md-6 col-lg-3 col-lg-4 col-lg-6')	
	 		if(vis == 0){
	 			col.hide()
	 		}else{
	 			col.show()
	 		}
	 	
			col.addClass(col_n)
			
			
		})
	 }

	 function getFila(fila, num){
	 	var row = $('<li class="fila col-12 flex-col-start-start">\
				 		<div class="fila-content col-12 flex-col-start-start">\
		 					<div class="col-12 flex-row-between-center">\
					 			<h3 class="title titulo-fila">Título Fila</h3>\
					 		</div>\
					 		<ul class="columnas col-12 flex-row-start-start flex-wrap m-0"></ul>\
					 	</div>\
				 	</li>'),
	 		columns = (fila != null) ? fila.columns : [null, null, null, null],
	 		
	 		id = (fila != null) ? fila.id : 0,
	 		title = (fila != null) ? fila.titulo : 'Título Fila ' + num,
	 		cols = (fila != null) ? fila.columnas : 4,
	 		estilosTitulo = (fila != null) ? fila.estilos_titulo : []
	 	row.prop('id', 'fila-' + id)
	 	row.data('num', num)
	 	row.data('cols', cols)
	 	row.find('.title').html(title)
	 	setCss(row.find('.title'), estilosTitulo)
	 	if(EDITOR != 0){
	 		row.find('.title').addClass('editable')
	 	}
	 	$.each(columns, function(i, col){
	 		row.find('.columnas').append(getColumna(col, i + 1, cols))
	 	})
	 	
	 	configCols(row)
	 	row.find('.fila-edit').data('toggle','tooltip')
			           .prop('title', 'Editar Fila')
			           .tooltip()
			           .click(function(){
			           		OBJ = $(this).closest('.fila').find('.fila-content')
			           		setMenu('fila')
			           		openEditor(true)
			           })

		row.find('.fila-reset')
					  
					   .data('toggle','tooltip')
			           .prop('title', 'Restablecer Fila')
			           .tooltip()
			           .click(function(){
			           		OBJ = $(this).closest('.fila').find('.fila-content')
			           		modalReset.openModal('tools/modalReset.php')
			           })

		

		row.find('.fila-del')
					   .data('id', id)
					   .data('index', num - 1)
					   .data('toggle','tooltip')
			           .prop('title', 'Eliminar Fila')
			           .tooltip()
			           .click(function(){
			           		var id = $(this).data('id'),
			           			index = $(this).data('index')
			           		 modalDelete.openModal('modalDelete.php?id=' + id + '&index=' + index + '&del=fila')
			           })


		//ver(['css', fila.estilos])
		if(fila != null){	           
	 		setCss(row.find('.fila-content'), fila.estilos)
	 	}

	 	
	 row.find('.fila-toolbar').remove()
	 	

	 	return row
	 }

	
	 function getCss(obj){
	 	var tag,
	 		css = []
	 	if(obj.hasClass('tema')){
	 		tag = 'root'
	 	}else if(obj.hasClass('fila-content')){
	 		tag = 'fila'
	 	}else if(obj.hasClass('col-content')){
	 		tag = 'column'
	 	}else if(obj.hasClass('editable')){
	 		tag = obj.prop('tagName').toLowerCase()
	 	}
	 	
	 	if(obj.prop('id') == 'class-preview'){
	 		tag = 'css'
	 		//ver(['getcss', tag, obj.text(), obj.css('color')])
	 	}
	 	
	 	ver(['css', tag , obj.html()])
	 	switch(tag){

	 		case 'root':
	 			css.push({name: 'background', value: obj.css('background')})
	 			css.push({name: 'paddingTop', value: obj.css('paddingTop')})
	 			css.push({name: 'paddingBottom', value: obj.css('paddingBottom')})
	 			css.push({name: 'paddingLeft', value: obj.css('paddingLeft')})
	 			css.push({name: 'paddingRight', value: obj.css('paddingRight')})	
	 		break
	 		case 'fila': case 'column':
	 			css.push({name: 'background', value: obj.css('background')})
	 			css.push({name: 'borderTopColor', value: obj.css('borderTopColor')})
	 			css.push({name: 'borderTopWidth', value: obj.css('borderTopWidth')})
	 			css.push({name: 'borderTopStyle', value: obj.css('borderTopStyle')})
	 			css.push({name: 'borderBottomColor', value: obj.css('borderBottomColor')})
	 			css.push({name: 'borderBottomWidth', value: obj.css('borderBottomWidth')})
	 			css.push({name: 'borderBottomStyle', value: obj.css('borderBottomStyle')})
	 			css.push({name: 'borderLeftColor', value: obj.css('borderLeftColor')})
	 			css.push({name: 'borderLeftWidth', value: obj.css('borderLeftWidth')})
	 			css.push({name: 'borderLeftStyle', value: obj.css('borderLeftStyle')})
	 			css.push({name: 'borderRightColor', value: obj.css('borderRightColor')})
	 			css.push({name: 'borderRightWidth', value: obj.css('borderRightWidth')})
	 			css.push({name: 'borderRightStyle', value: obj.css('borderRightStyle')})
	 			css.push({name: 'paddingTop', value: obj.css('paddingTop')})
	 			css.push({name: 'paddingBottom', value: obj.css('paddingBottom')})
	 			css.push({name: 'paddingLeft', value: obj.css('paddingLeft')})
	 			css.push({name: 'paddingRight', value: obj.css('paddingRight')})
	 			css.push({name: 'boxShadow', value: obj.css('boxShadow')})
	 			css.push({name: 'borderRadius', value: obj.css('borderRadius')})		
	 			
	 		break
	 		case 'css':

	 			css.push({name: 'fontFamily', value: getFontIndex(obj.css('fontFamily'))})
				css.push({name: 'fontSize', value: obj.css('fontSize')})
				css.push({name: 'letterSpacing', value: obj.css('letterSpacing')})
				css.push({name: 'fontWeight', value: obj.css('fontWeight')})
				css.push({name: 'textFillColor', value: obj.css('textFillColor')})
				css.push({name: 'textShadow', value: obj.css('textShadow')})
				css.push({name: 'textStrokeColor', value: obj.css('textStrokeColor')})
				css.push({name: 'textStrokeWidth', value: obj.css('textStrokeWidth')})
				css.push({name: 'fontStyle', value: obj.css('fontStyle')})
				css.push({name: 'textTransform', value: obj.css('textTransform')})
				css.push({name: 'textDecoration', value: obj.css('textDecoration')})
				css.push({name: 'marginTop', value: obj.css('marginTop')})
	 			css.push({name: 'marginBottom', value: obj.css('marginBottom')})
	 			css.push({name: 'marginLeft', value: obj.css('marginLeft')})
	 			css.push({name: 'marginRight', value: obj.css('marginRight')})
	 			css.push({name: 'boxShadow', value: obj.css('boxShadow')})
	 			css.push({name: 'borderRadius', value: obj.css('borderRadius')})
	 			css.push({name: 'background', value: obj.css('background')})
	 			css.push({name: 'borderTopColor', value: obj.css('borderTopColor')})
	 			css.push({name: 'borderTopWidth', value: obj.css('borderTopWidth')})
	 			css.push({name: 'borderTopStyle', value: obj.css('borderTopStyle')})
	 			css.push({name: 'borderBottomColor', value: obj.css('borderBottomColor')})
	 			css.push({name: 'borderBottomWidth', value: obj.css('borderBottomWidth')})
	 			css.push({name: 'borderBottomStyle', value: obj.css('borderBottomStyle')})
	 			css.push({name: 'borderLeftColor', value: obj.css('borderLeftColor')})
	 			css.push({name: 'borderLeftWidth', value: obj.css('borderLeftWidth')})
	 			css.push({name: 'borderLeftStyle', value: obj.css('borderLeftStyle')})
	 			css.push({name: 'borderRightColor', value: obj.css('borderRightColor')})
	 			css.push({name: 'borderRightWidth', value: obj.css('borderRightWidth')})
	 			css.push({name: 'borderRightStyle', value: obj.css('borderRightStyle')})
	 			css.push({name: 'paddingTop', value: obj.css('paddingTop')})
	 			css.push({name: 'paddingBottom', value: obj.css('paddingBottom')})
	 			css.push({name: 'paddingLeft', value: obj.css('paddingLeft')})
	 			css.push({name: 'paddingRight', value: obj.css('paddingRight')})
	 		break
	 		default:

	 			css.push({name: 'fontFamily', value: getFontIndex(obj.css('fontFamily'))})
				css.push({name: 'fontSize', value: obj.css('fontSize')})
				css.push({name: 'letterSpacing', value: obj.css('letterSpacing')})
				css.push({name: 'fontWeight', value: obj.css('fontWeight')})
				css.push({name: 'textFillColor', value: obj.css('textFillColor')})
				css.push({name: 'textShadow', value: obj.css('textShadow')})
				css.push({name: 'textStrokeColor', value: obj.css('textStrokeColor')})
				css.push({name: 'textStrokeWidth', value: obj.css('textStrokeWidth')})
				css.push({name: 'fontStyle', value: obj.css('fontStyle')})
				css.push({name: 'textTransform', value: obj.css('textTransform')})
				css.push({name: 'textDecoration', value: obj.css('textDecoration')})
				css.push({name: 'marginTop', value: obj.css('marginTop')})
	 			css.push({name: 'marginBottom', value: obj.css('marginBottom')})
	 			css.push({name: 'marginLeft', value: obj.css('marginLeft')})
	 			css.push({name: 'marginRight', value: obj.css('marginRight')})
	 			css.push({name: 'boxShadow', value: obj.css('boxShadow')})
	 			css.push({name: 'borderRadius', value: obj.css('borderRadius')})		

	 		break
	 		
	 	}

	 

	 	return css
	 	
	 }

	 


	 
	 function setElements(col){
	 	col.children().each(function(index){
	 		var obj = $(this),
	 			tag = obj.prop('tagName').toLowerCase()
	 			
		 		switch(tag){
		 		
					
					case 'p':
						if(obj.html() != ''){
							obj.addClass('multi-text')
						}else{
							obj.remove()
						}
					break	

					
					
				

					case 'div':
						if(obj.hasClass('media-box')){
							obj.find('.media-click').click(function(evt){
									evt.stopPropagation()
									OBJ = $(this).closest('.media-box').find('.media')
									setMenu(OBJ.prop('tagName').toLowerCase())
									$(this).parent()
									openEditor(true)
								})
						}
						if(obj.hasClass('scroll-table')){
							obj = obj.find('table')
							var thead = obj.find('thead'), 
								tbody = obj.find('tbody')
							thead.find('tr th').each(function(){
								var obj = $(this)
								setTooltip(obj)
								obj.children().each(function(){
									$(this).addClass('th') //sacar despues de corregir el add en insert
									setTooltip($(this))
								})
							})
							tbody.find('tr td').each(function(){
								var obj = $(this)
								setTooltip(obj)
								obj.children().each(function(){
									
									setTooltip($(this))
								})
							})
							
						}



					break
					

		 		}

		 		setTooltip(obj)
		 		
			 
	 	})
	 }

	 function getFiles(col){
	 	var files = []
	 	col.find('img, audio, a').each(function(){
	 		var obj = $(this), 
	 			src = obj.prop('src')
	 		if(src != null){
	 			if(src != ''){
	 				var dir = null
	 				if(exists(src, 'myeditor/img')){
	 					dir = 'img'
	 				}else if(exists(src, 'myeditor/files')){
	 					dir = 'files'
	 				}
	 				if(dir != null){
	 					var v = src.split('/')
	 					files.push({
	 						dir: dir, 
	 						file: v[v.length - 1]
	 					})
	 				}
	 			}
	 		}
	 	
	 	})
	 	return files
	 }

	 

	 

	 function clearTable(table){
	 	table.find('tr, th, td').removeClass('editable selected')
	 	table.find('th').children().removeClass('editable selected')
	 	table.find('td').children().removeClass('editable selected')
	 }

	 
	 function openModalGalery(medio){
	 	var tag = medio.prop('tagName')
	 	$('#modal-galery').find('img, iframe').hide()
	 	if(tag == 'IMG'){
	 		$('#modal-galery').find('img').prop('src', medio.prop('src')).show()
	 	}else if(tag == 'IFRAME'){
	 		$('#modal-galery').find('iframe').prop('src', medio.prop('src')).show()
	 	}
	 	$('#modal-galery').fadeIn(150)
	 }

	 function setAntSigGalery(){
	 	$('#modal-galery').find('.arrow').click(function(){
	 		var dir = parseInt($(this).data('dir')),
	 			pos = parseInt($('#modal-galery').data('pos'))
	 		if(dir > 0){
	 			pos++
	 			if(pos >= GALERY.length){
	 				pos = 0
	 			}
	 		}else{
	 			pos--
	 			if(pos < 0){
	 				pos = GALERY.length - 1
	 			}
	 		}
	 		$('#modal-galery').data('pos', pos)
	 		if($('#modal-galery').find('img').css('display') != 'none'){
	 			$('#modal-galery').find('img').prop('src', GALERY[pos])
	 		}else if($('#modal-galery').find('iframe').css('display') != 'none'){
	 			$('#modal-galery').find('iframe').prop('src', GALERY[pos])
	 		}
	 		

	 	})
	 }

	 function setTema(){
	 	setCss($('#titulo-tema'), TEMA.estilos_titulo)
	 	setCss($('#tema'), TEMA.estilos)
	 	$('#titulo-tema').html(TEMA.titulo)
	 	var filas = TEMA.filas
	 	$.each(filas, function(i, fila){
	 		ver(['columnas', fila.columns])
	 		$('#filas').append(getFila(fila, i))
	 	})
	 	
	 	$('#modal-galery').find('#modal-galery-close').click(function(){
	 		$('#modal-galery').fadeOut(150)
	 	})
	 	setAntSigGalery()
	 	$('.galery').each(function(){
	 		$(this).find('img').each(function(index){
	 			$(this)
	 				.data('pos', index)
	 				.click(function(evt){
	 					evt.stopPropagation()
	 					$('#modal-galery').data('pos', $(this).data('pos'))
	 					GALERY = []
	 					$(this).closest('.galery').find('img').each(function(){
	 						GALERY.push($(this).prop('src'))
	 					})
	 					openModalGalery($(this))
	 				})
	 		})
	 	})

	 	$('.video-galery').each(function(){
	 		$(this).find('.box-gal').each(function(index){
	 			$(this)
	 				.data('pos', index)
	 				.click(function(evt){
	 					evt.stopPropagation()
	 					$('#modal-galery').data('pos', $(this).data('pos'))
	 					GALERY = []
	 					$(this).closest('.video-galery').find('.box-gal').each(function(){
	 						GALERY.push($(this).find('iframe').prop('src'))
	 					})
	 					openModalGalery($(this).find('iframe'))
	 				})
	 		})
	 	})
	 				
	 	
	 	
	 	 	$('.col-content').removeClass('column-hover')


	 	 
	 	
	 	 loading(false)
	 }

	 

	 setTema()
	 
	

 </script>



