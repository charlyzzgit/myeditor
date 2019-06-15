<?php 
	error_reporting(1);
	require '../php/scripts.php';
	$request = $_REQUEST;
	//$editor = getPost($request, 'editor', 0);
	$device = getPost($request, 'device', NULL);
	$orientation = getPost($request, 'orientation', 'portrait');
	$id = 1;
	$tema = getTema($id);

	


	
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

	.column-hover{
		border: dotted thin lightgray;
	}

	

	.icon{
		font-size: 20px
	}

	.big-icon{
		font-size: 30px;

	}

	.editable:hover{
		border:dotted medium red;
		cursor: pointer;
		
	}

	.selected{
		border: dotted medium lime;
		cursor: pointer;
	}

	.info-edit{
		border:dotted thin red;
		height: 20px
	}

	.info-sel{
		border: dotted thin lime;
		height: 20px
	}

	#modal-edit{
		position: fixed;
		bottom: -500px;
		left: 0;
		z-index: 50;
		box-shadow: 0 -2px 10px 2px rgba(0, 0, 0, .2)
	}

	#tools{
		height: 300px
	}

	#menu-bar{
		list-style: none;
	}

	#menu-bar li{
		border-left: solid thin white;
		border-right: solid thin white;
		cursor: pointer;
	}
	#menu-bar li:first-child{
		border-left:none;
	}
	#menu-bar li:last-child{
		border-right:none;
	}

	#tema{
		padding: 10px;
		min-height: 100vh;
		<?php if($editor != 0){ ?>
			min-height: calc(100vh + 400px);
		<?php } ?>
	}

	


</style>
<div id="media-editor" class="flex-row-center-center"><button class="btn btn-warning"></button></div>
<div id="modal-edit" class="col-12 flex-col-start-start bg-white">
	<div class="header bg-primary col-12 flex-row-between-center text-white p-1">
		<span class="name">Elemento</span>
		<div class="flex-row-center-center bg-white p-1 pl-3 pr-3">
			<div class="info-edit flex-row-center-center mr-3 text-dark p-1">Elemento Seleccionado</div>
			<div class="info-sel flex-row-center-center ml-3 text-dark p-1">Elemento en Edicion</div>
		</div>
		<i class="fa fa-times mr-2 hand cerrar"></i>
	</div>
	<menu id="menu-bar" class="col-12 flex-row-start-center m-0">
		
	</menu>
	<div id="tools" class="col-12 flex-row-start-start flex-wrap">
		
	</div>
</div>
<div id="tema" class="tema col-12 flex-col-start-start">
	<div class="col-12 flex-row-between-center">
		<h1 id="titulo-tema" class="editable">Titulo Tema</h1>
		
		<div id="tool-tema" class="flex-row-start-center">
			<i class="ver-demo fa fa-desktop text-dark hand mr-2 big-icon"></i>
			<i class="tema-edit fa fa-pen-square text-success hand mr-2 big-icon"></i>
			<i class="add-fila fa fa-plus-square text-primary hand mr-2 big-icon"></i>
			<i class="save fa fa-save text-warning hand mr-2 big-icon"></i>
			
		</div>
	
	</div>
	<ul id="filas" class="main col-12 flex-col start-center m-0"></ul>
</div>




 <script>
	var OBJ = null,
		BOX = null,
		//EDITOR = '<?php print($editor); ?>',
		device = '<?php print($device); ?>',
		orientation = '<?php print($orientation); ?>',
		TEMA = getJson('<?php print(toJson($tema)); ?>'),

		modalInsert, modalTextos, modalDelete, modalDevice, modalIcons,
		menu = [
			{name: 'texto', value:'text'},
			{name: 'fondo', value:'background'},
			{name: 'borde', value:'border'},
			{name: 'sombra', value:'shadow'},
			{name: 'margen', value:'margin'},
			{name: 'relleno', value:'padding'},
			{name: 'tamaño', value:'size'},
			{name: 'alineacion', value:'align'},
			{name: 'insertar', value:'insert'},
			{name: 'distribucion', value:'distribution'}
		]
	ver(['tema = ', TEMA])
	if(modalDelete == null){
		modalDelete = new Modal({
        	title: 'Eliminar',
        	size: 'small',
        	bg: 'bg-danger'
      	})
	}

	if(modalDevice == null){
		modalDevice = new Modal({
        	title: 'Dispositivos',
        	size: 'medium',
        	bg: 'bg-primary'
      	})
	}

	if(modalIcons == null){
		modalIcons = new Modal({
        	title: 'Iconos',
        	size: 'big',
        	bg: 'bg-primary'
      	})
	}

	ver(['tema', TEMA])	
	function setMenu(tag){

		$('#menu-bar').empty()
		switch(tag){
			case 'root':
				menu = [
					{name: 'fondo', value:'background'},
					{name: 'relleno', value:'padding'}
					]
			break
			case 'fila':
				menu = [
					{name: 'columnas', value:'columns'},
					{name: 'fondo', value:'background'},
					{name: 'borde', value:'border'},
					{name: 'relleno', value:'padding'},
					{name: 'sombra', value:'shadow'},
					{name: 'Redondear', value:'radius'}
				]
			break
			case 'column':
				menu = [
					{name: 'alineacion', value:'align'},
					{name: 'fondo', value:'background'},
					{name: 'borde', value:'border'},
					{name: 'relleno', value:'padding'},
					{name: 'insertar', value:'insert'}
	
				]
			break
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
				menu = [
					{name: 'texto', value:'text'},
					{name: 'fondo', value:'background'},
					{name: 'borde', value:'border'},
					{name: 'margen', value:'margin'},
					{name: 'relleno', value:'padding'},
					{name: 'sombra', value:'shadow'},
					{name: 'Redondear', value:'radius'},
					//{name: 'flotación', value:'float'},
					{name: 'insertar', value:'insert'},
					{name: 'eliminar', value:'delete'},
					
				]

				if(OBJ.hasClass('icon-editor')){
					menu = [
						{name: 'icono', value:'icon'},
						{name: 'texto', value:'text'},
						{name: 'margen', value:'margin'},
						{name: 'sombra', value:'shadow'},
						{name: 'insertar', value:'insert'},
						{name: 'eliminar', value:'delete'},
						
					]
				}

			break
			case 'p':
				menu = [
					{name: 'texto', value:'text'},
					{name: 'multitexto', value:'textEditor'},
					{name: 'fondo', value:'background'},
					{name: 'borde', value:'border'},
					{name: 'margen', value:'margin'},
					{name: 'relleno', value:'padding'},
					{name: 'sombra', value:'shadow'},
					{name: 'insertar', value:'insert'},
					{name: 'eliminar', value:'delete'},
				]
			break
			case 'img':
				menu = [
					{name: 'imagen', value:'image'},
					{name: 'borde', value:'border'},
					{name: 'margen', value:'margin'},
					{name: 'fondo', value:'background'},
					{name: 'sombra', value:'shadow'},
					{name: 'Redondear', value:'radius'},
					//{name: 'flotación', value:'float'},
					{name: 'insertar', value:'insert'},
					{name: 'eliminar', value:'delete'}
					]
			break
			case 'a':
				menu = [
					{name: 'link', value:'link'},
					{name: 'texto', value:'text'},
					{name: 'fondo', value:'background'},
					{name: 'borde', value:'border'},
					{name: 'margen', value:'margin'},
					{name: 'relleno', value:'padding'},
					{name: 'sombra', value:'shadow'},
					{name: 'Redondear', value:'radius'},
					//{name: 'flotación', value:'float'},
					{name: 'insertar', value:'insert'},
					{name: 'eliminar', value:'delete'}
					
				]
			break
			case 'table':
				menu = [
					{name: 'estructura', value:'table'},
					{name: 'alineacion', value:'align'},
					{name: 'Ancho', value:'size'},
					{name: 'fondo', value:'background'},
					{name: 'predefinido', value:'table_style'},
					{name: 'borde', value:'border'},
					{name: 'margen', value:'margin'},
					//{name: 'flotación', value:'float'},
					{name: 'eliminar', value:'delete'},
					
	
				]
			break
			case 'title':
				menu = [
					{name: 'texto', value:'text'}

				]
			break
			case 'th':
				menu = [
					{name: 'alineacion', value:'align'},
					{name: 'Ancho', value:'size'},
					{name: 'fondo', value:'background'}
					
	
				]
			break
			case 'td':
				menu = [
					{name: 'alineacion', value:'align'},
					{name: 'fondo', value:'background'},
					{name: 'insertar', value:'insert'}
	
				]
			break

			case 'ul':
				menu = [
					{name: 'texto', value:'ul-text'},
					{name: 'icono', value:'ul-icon'},
					{name: 'Lista', value:'list'},
					{name: 'fondo', value:'background'},
					{name: 'borde', value:'border'},
					{name: 'margen', value:'margin'},
					{name: 'relleno', value:'padding'},
					{name: 'sombra', value:'shadow'},
					//{name: 'flotación', value:'float'},
					{name: 'insertar', value:'insert'},
					{name: 'eliminar', value:'delete'},
					
				]
			break

			case 'audio':
				menu = [
					{name: 'audio', value:'audio'},
					{name: 'borde', value:'border'},
					{name: 'margen', value:'margin'},
					{name: 'relleno', value:'padding'},
					{name: 'sombra', value:'shadow'},
					{name: 'Redondear', value:'radius'},
					{name: 'insertar', value:'insert'},
					{name: 'eliminar', value:'delete'}
				]
			break

			case 'iframe':
				menu = [
					{name: 'video', value:'video'},
					{name: 'borde', value:'border'},
					{name: 'margen', value:'margin'},
					{name: 'sombra', value:'shadow'},
					{name: 'Redondear', value:'radius'},
					{name: 'insertar', value:'insert'},
					{name: 'eliminar', value:'delete'}
				]
			break



		}
		$('#modal-edit').find('.name').text('Editando ' + getActual(tag))
		var size = menu.length
	 	$.each(menu, function(i, l){
	 		var li = $('<li class="menu-item"><b></b></li>'),
	 			sel = (l.value != 'delete' && l.value != 'empty') ? 'bg-info' : 'bg-danger',
	 			over = (l.value != 'delete' && l.value != 'empty') ? 'bg-dark' : 'bg-danger'
	 		li.css('width', (100/size) + '%')
	 		li.find('b').html(l.name.toUpperCase())
	 		li.addClass('flex-row-center-center bg-secondary text-white')
	 		li.data('type', l.value)
	 		li.mouseover(function(){
	 			$(this).removeClass('bg-secondary bg-dark bg-info bg-danger').addClass(over)
	 		}).mouseout(function(){
	 			var active = parseInt($(this).data('active')),
	 				bg = (active == 1) ? sel : 'bg-secondary'
	 			$(this).removeClass('bg-secondary bg-dark bg-info bg-danger').addClass(bg)
	 		}).click(function(){

	 			$('.menu-item').removeClass('bg-secondary bg-dark bg-info bg-danger').addClass('bg-secondary').data('active', 0)
	 			$(this).removeClass('bg-secondary bg-dark bg-info bg-danger').addClass(sel).data('active', 1)
	 			var tool = $(this).data('type')
	 			if(tool != 'delete'){
	 				var e = ''
	 				if(OBJ.prop('tagName') == 'UL'){
	 					if(tool == 'ul-text'){
	 						e = 'span'
	 						tool = 'text'
	 					}else if(tool == 'ul-icon'){
	 						e = 'i'
	 						tool = 'text'
	 					}
	 					
	 				}
	 				$('#tools').load('tools/' + tool + '.php?elem=' + e)
	 			}else{
	 				var id = OBJ.prop('id')
	 					
	 				 modalDelete.openModal('modalDelete.php?id=' + id + '&del=element')
	 			}
	 		})
	 		$('#menu-bar').append(li)
	 	})
	 	$('#tools').empty()
	}
 	function openEditor(op){
 		var mod = $('#modal-edit')
 		
 		if(op){
 			$('.editable').removeClass('selected')
 			
 			OBJ.addClass('selected').fadeTo(0, 1)
 			mod.animate({bottom: '-500px'}, 150, function(){
 				mod.animate({bottom: 0})
 			})
 		}else{
 			$('.editable').removeClass('selected')
 			
 			mod.animate({bottom: '-500px'}, 150)
 		}
 	}

 	function config(){
 		$('#modal-edit').find('.cerrar').click(function(){
 			openEditor(false)
 		})

 		$('.ver-demo').data('toggle','tooltip')
			           .prop('title', 'Vista Previa')
			           .tooltip()
			           .click(function(){
			           		modalDevice.openModal('modalDevice.php')
			           })
 		
 		$('.tema-edit').data('toggle','tooltip')
			           .prop('title', 'Editar Estilo general del Tema')
			           .tooltip()
			           .click(function(){
			           		OBJ = $('#tema')
			           		setMenu('root')
			           		openEditor(true)
			           })

		$('.add-fila').data('toggle','tooltip')
			           .prop('title', 'Insertar Bloque')
			           .tooltip()
			           .click(function(){
			           	  $('#filas').append(getFila(null))
			           })

		$('.save').data('toggle','tooltip')
			           .prop('title', 'Guardar Todo')
			           .tooltip()
			           .click(function(){
			           		save()
			           })
 		

 		$('.column-toolbar').hide()
 		
			           		

	 	$('.column').mouseover(function(evt){
	 		evt.stopPropagation()
	 		//$(this).addClass('column-hover')
	 		$(this).find('.column-toolbar').show()
	 	
	 	}).mouseout(function(evt){
	 		evt.stopPropagation()
	 		//$(this).removeClass('column-hover')
	 		$(this).find('.column-toolbar').hide()
	 	})

	 	
	 	$('#tema').css('min-height', '150vh')

	 }

	 function setEditables(){
	 	$('.editable').click(function(evt){
	 		evt.stopPropagation()
	 		OBJ = $(this)
	 		var tag = OBJ.prop('tagName').toLowerCase()
	 		ver(['no text', OBJ.data('only-text')])
	 		if(OBJ.data('only-text') != null){
	 			tag = 'title'
	 		}
	 		setMenu(tag)
	 		
			openEditor(true)
	 	})
	 }

	 function getColumna(column, n, cols){
	 	var col = $('<li class="column">\
				 		<div class="column-toolbar col-12 flex-row-between-center bg-light elevation-1 p-1 pl-2 pr-2">\
				 			<h6 class="m-0 title-col"></h6>\
				 			<div class="flex-row-start-center">\
				 				<i class="edit-col fa fa-pen text-success hand"></i>\
				 				<i class="del-col fa fa-trash text-danger hand ml-2"></i>\
				 			</div>\
				 		</div>\
				 		<div class="col-content column-hover col-12 flex-row-start-start flex-wrap"></div>\
				 	</li>'),
	 		id = (column != null) ? column.id : 0,
	 		elements = (column != null) ? column.elements : [],
	 		col_n = ''
	 	
	 	col.find('.col-content').data('align', (column != null) ? column.align : 'start')
	 	col.find('.col-content').data('valign', (column != null) ? column.valign : 'start')
	 	col.find('.col-content').data('distribution', (column != null) ? column.distribution : 'wrap')
	 	col.find('.title-col').html('Columna ' + n)
	 	col.find('.col-content').prop('id', 'col-' + id)

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
		col.find('.del-col')
	 				   .data('toggle','tooltip')
			           .prop('title', 'Vaciar Columna')
			           .tooltip()
			           .click(function(){
			           		OBJ = $(this).closest('.column').find('.col-content')
			           		var id = OBJ.prop('id')

	 						modalDelete.openModal('modalDelete.php?id=' + id + '&del=column')
			           })
		//ver(['cols', cols])
		switch(parseInt(cols)){
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

		if(EDITOR != 0){
			col.addClass(col_n)
		}else{

			if(!isMobile()){
				var w = 100

				switch(device){
					case 'desktop':
						switch(parseInt(cols)){
							case 1:
								w = 100
							break
							case 2:
								w = 50
							break
							case 3:
								w = 100/3

							break
							case 4:
								100/4

							break 
							
						}

					break
					case 'tablet':
						
						if(orientation == 'portrait'){
							w = 100
						}else{
							switch(parseInt(cols)){
								case 1:
									w = 100
								break
								case 2:
									w = 50
								break
								case 3:
									w = 100/3
								break
								case 4:
									100/4
								break 
								
							}
						}
					break
					case 'smartphone':
						w = 100
					break
				}

			col.css('width', w + '%')
			}else{
				col.addClass(col_n)
			}
		}

		addElements(elements, col.find('.col-content'), '')
		//col.find('.col-content').html(base64Decode(column.content))

		if(n > cols){
			col.hide()
		}

		if(column != null){	           
	 		setCss(col.find('.col-content'), column.estilos)
	 	}

	 	if(EDITOR == 0){
	 		col.find('.column-toolbar').remove()
	 	}
	 	return col
	 }



	 function getFila(fila){
	 	var row = $('<li class="fila col-12 flex-col-start-start">\
	 					<div class="fila-toolbar col-12 flex-row-between-center bg-light elevation-1 p-1 pl-2 pr-2">\
				 			<h6 class="m-0 title-fila"></h6>\
				 			<div class="flex-row-start-center">\
				 				<i class="fila-edit fa fa-pen-square text-success hand mr-2 big-icon"></i>\
				 				<i class="fila-del fa fa-window-close text-danger hand mr-2 big-icon"></i>\
				 			</div>\
				 		</div>\
				 		<div class="fila-content col-12 flex-col-start-start">\
		 					<div class="col-12 flex-row-between-center">\
					 			<h3 class="title">Título Fila</h3>\
					 		</div>\
					 		<ul class="columnas col-12 flex-row-start-start flex-wrap m-0"></ul>\
					 	</div>\
				 	</li>'),
	 		columns = (fila != null) ? fila.columns : [
	 			{titulo: 'Columna 1'},
	 			{titulo: 'Columna 2'},
	 			{titulo: 'Columna 3'},
	 			{titulo: 'Columna 4'}
	 		],
	 		num = $('.fila').length + 1,
	 		id = (fila != null) ? fila.id : 0,
	 		title = (fila != null) ? fila.titulo : 'Título Fila ' + num,
	 		cols = (fila != null) ? fila.columnas : 4
	 	row.prop('id', 'fila-' + id)
	 	row.data('cols', cols)
	 	row.find('.title').html(title)
	 	if(EDITOR != 0){
	 		row.find('.title').addClass('editable')
	 	}
	 	$.each(columns, function(i, col){
	 		row.find('.columnas').append(getColumna(col, i + 1, cols))
	 	})
	 	

	 	row.find('.fila-edit').data('toggle','tooltip')
			           .prop('title', 'Editar Fila')
			           .tooltip()
			           .click(function(){
			           		OBJ = $(this).closest('.fila').find('.fila-content')
			           		setMenu('fila')
			           		openEditor(true)
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

	 	if(EDITOR == 0){
	 		row.find('.fila-toolbar').remove()
	 	}

	 	return row
	 }

	 function updateFilas(){
	 	$('.fila').each(function(index){
	 		$(this).find('.fila-del').data('index', index)
	 	})
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
	 	}else if(obj.hasClass('editable') || obj.hasClass('media')){
	 		tag = obj.prop('tagName').toLowerCase()
	 	}
	 	
	 		//ver(['getcss', tag, obj.text(), obj.css('color')])
	 	
	 	
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
			case 'a':
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
	 		case 'img':
	 			css.push({name: 'marginTop', value: obj.css('marginTop')})
	 			css.push({name: 'marginBottom', value: obj.css('marginBottom')})
	 			css.push({name: 'marginLeft', value: obj.css('marginLeft')})
	 			css.push({name: 'marginRight', value: obj.css('marginRight')})
	 			css.push({name: 'boxShadow', value: obj.css('boxShadow')})
	 			css.push({name: 'borderRadius', value: obj.css('borderRadius')})
	 			css.push({name: 'width', value: obj.css('width')})

	 		break

	 		case 'th': case 'td':
	 			css.push({name: 'textAlign', value: obj.css('textAlign')})
	 			css.push({name: 'verticalAlign', value: obj.css('verticalAlign')})
	 			css.push({name: 'background', value: obj.css('background')})
	 			
	 		break

	 		case 'audio':
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
	 			css.push({name: 'marginTop', value: obj.css('marginTop')})
	 			css.push({name: 'marginBottom', value: obj.css('marginBottom')})
	 			css.push({name: 'marginLeft', value: obj.css('marginLeft')})
	 			css.push({name: 'marginRight', value: obj.css('marginRight')})
	 			css.push({name: 'boxShadow', value: obj.css('boxShadow')})
	 			css.push({name: 'borderRadius', value: obj.css('borderRadius')})		
	 		break

	 		case 'iframe':
	 			
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
	 			css.push({name: 'marginTop', value: obj.css('marginTop')})
	 			css.push({name: 'marginBottom', value: obj.css('marginBottom')})
	 			css.push({name: 'marginLeft', value: obj.css('marginLeft')})
	 			css.push({name: 'marginRight', value: obj.css('marginRight')})
	 			css.push({name: 'boxShadow', value: obj.css('boxShadow')})
	 			css.push({name: 'borderRadius', value: obj.css('borderRadius')})		
	 		break
	 	}

	 	//ver(['family', obj.css('fontFamily'), getFontIndex(obj.css('fontFamily'))])

	 	return css
	 	
	 }

	 function getContent(obj){

	 	var tag = obj.prop('tagName').toLowerCase()
	 	//alert(tag + ' = ' + obj.text())
	 	switch(tag){
	 		case 'table': 
	 			return ''
	 		case 'ul':
	 			var list = {
	 				items: [], 
	 				
	 				class_i: obj.find('i').prop('class'),
	 				class_text: obj.find('span').prop('class'), 
	 				estilos_icon: [],
	 				estilos_text: [], 
	 			}
	 			
	 			obj.find('li').each(function(index){
	 				var li = $(this)
	 				list.items.push({
	 					icon: li.find('i').prop('class'), 
	 					text: base64Encode(li.find('span').text())
	 				})
	 				if(index == 0){
	 					
	 					list.estilos_icon =  getEstiloList(li.find('i'))
	 					list.estilos_text =  getEstiloList(li.find('span'))
	 					
						
	 				}
	 			})
	 			return list
	 		case 'audio': case 'iframe':
	 			return null;
	 		case 'p': 
	 			return base64Encode(obj.html());
	 		default:
	 			return obj.text()
	 	}
	 	
	 		
	 }

	
	 function getEstiloList(obj){
	 	var css = []
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

		return css
	 }

	 function getSrc(obj){
	 	var tag = obj.prop('tagName').toLowerCase()
	 	switch(tag){
	 		case 'img': case 'audio': case 'iframe':
	 			return obj.prop('src')
	 		break
	 		case 'a':
	 			return obj.prop('href')
	 		break
	 		default:
	 			return null
	 		break
	 	}
	 	
	 }

	 function getTableContent(tb){
	 	var table = []
	 	tb.find('tr').each(function(index){
	 		var cells = []
	 		$(this).find('th, td').each(function(c){
	 			var elements = [], 
	 				td = $(this), 
	 				estilosTd = getCss(td)
	 			td.removeClass('editable selected')
	 			$(this).children().each(function(e){
	 				//$(this).removeClass('editable selected') //en caso de un div caja
	 				var clases = $(this).prop('class'),
	 					el = $(this).hasClass('media-box') ? $(this).find('.media') : $(this),
	 					idelement = el.prop('id').split('element-')[1],
	 					estilos = getCss(el)
	 				el.removeClass('editable selected')
	 				elements.push({
	 					id: idelement,
	 					numero: e + 1,	
	 					clases: clases,	
	 					estilos: estilos,
	 					tag: el.prop('tagName'),	
	 					content: base64Encode(getContent(el)),
	 					table: getTableContent(el),
	 					url: getSrc(el),
	 					link: el.data('type')
	 				})
	 				//ver(['encode', getContent(el), base64Encode(getContent(el))])
	 			})
	 			//ver(['estilos td', estilosTd])
	 			cells.push({
		 			index: c, 
		 			tag: $(this).prop('tagName'),
		 			clases: td.prop('class'),
		 			estilos: estilosTd,
		 			elements: elements
		 		})
	 		})

	 		table.push({
	 			index:index,
	 			cells: cells
	 		})

	 	})

	 	return table
	 }

	 function save(){
	 	TEMA.estilos = getCss($('#tema'))
	 	TEMA.clases = $('#tema').prop('class')

	 	TEMA.estilos_titulo = getCss($('#titulo-tema'))
	 	TEMA.clases_titulo = $('#titulo-tema').prop('class')
	 	TEMA.titulo = $('#titulo-tema').text()
	 	TEMA.filas = []
	 	$('.fila').each(function(index){
	 		var li = $(this),
	 			idfila = li.prop('id').split('fila-')[1],
	 			columnas = []
	 		li.find('.title').removeClass('editable selected')
	 		li.find('.column').each(function(i){

	 			var col = $(this).find('.col-content'),
	 				idcol = $(this).find('.col-content').prop('id').split('col-')[1]
	 				elements = []
	 			col.children().each(function(e){
	 				 //en caso de un div caja
	 				var el = $(this), 
	 					clases = $(this).prop('class')
	 				if($(this).hasClass('scroll-table')){
	 					el = $(this).find('table')
	 				}
	 				if($(this).hasClass('media-box')){
	 					$(this).removeClass('editable selected')
	 					el = $(this).find('.media')
	 					clases = $(this).prop('class')
	 				}

	 				
	 					
		 			
		 			var	idelement = el.prop('id').split('element-')[1],
		 				estilos = getCss(el)
		 			el.removeClass('editable selected')
		 			elements.push({
		 				id: idelement,
		 				numero: e + 1,	
		 				clases: clases,	
		 				estilos: estilos,
		 				tag: el.prop('tagName'),	
		 				content: getContent(el), 
		 				table: getTableContent(el), 
		 				url: getSrc(el),
		 				link: el.data('type')
		 			})

		 			
	 			})
	 			ver(['content', getCss(col)])
	 			columnas.push({
	 					id: idcol,
	 					numero: i + 1,	
	 					align: col.data('align'),
	 					valign: col.data('valign'), 
	 					distribution: col.data('distribution'),
	 					clases: col.prop('class'),	
	 					estilos: getCss(col),
	 					elements: elements, 
	 					content: base64Encode(col.html())
	 				})

	 		})
	 		var	fila = {
	 				id: idfila,
	 				titulo: li.find('.title').html(),
	 				estilos_titulo: getCss(li.find('.title')),
	 				clases_titulo: li.find('.title').prop('class'),	
	 				numero: index + 1,
	 				columnas: li.data('cols'),
	 				columns: columnas,	
	 				clases: li.find('.fila-content').prop('class'),
	 				estilos: getCss(li.find('.fila-content'))
	 			}
	 		ver(['estilos fila', getCss(li.find('.fila-content'))])
	 		TEMA.filas.push(fila)
	 	})

	 	var aj = new Ajax()
	 	aj.add('action', 'savePageTema')
	 	aj.add('tema', toJson(TEMA))

	 	loading(true)
	 	aj.send('../php/main.php', function(data){
	 		loading(false)
	 		if(data.result == SUCCESS){
	 			swal('GUARDAR','Guardado con Éxito','success').then((value) => {
			  	location.reload(true);
			});
	 		}else{
	 			swal('GUARDAR','Error al Guardar:' + data.message,'error')
	 		}
	 	})
	 	console.clear()
	 	ver(['send', TEMA])
	 }

	 function setTema(){
	 	setCss($('#titulo-tema'), TEMA.estilos_titulo)
	 	setCss($('#tema'), TEMA.estilos)
	 	$('#titulo-tema').html(TEMA.titulo)
	 	var filas = TEMA.filas
	 	$.each(filas, function(i, fila){
	 		ver(['columnas', fila.columns])
	 		$('#filas').append(getFila(fila))
	 	})
	 	
	 	
	 	if(EDITOR != 0){
	 	 	setEditables()
	 	 }
	 	// ver(['full-page', $('#tema').html()])
	 }

	 function getActual(tag){
	 	
	 	switch(tag){
	 		case 'span': return 'Texto'; 
 			case 'h1': return 'Encabezado 1';
	 		case 'h2': return 'Encabezado 2';
	 		case 'h3': return 'Encabezado 3';
	 		case 'h4': return 'Encabezado 4';
	 		case 'h5': return 'Encabezado 5';
	 		case 'h6': return 'Encabezado 6';
			case 'i': return 'Icono';
			case 'em': return 'Enfasis';
			case 'small': return 'Pequeño';
			case 'strong': return 'Importante';
			case 's': return 'No relevante';
			case 'cite': return 'Cita';
			case 'q': return 'Cita textual';
			case 'u': return 'Señalado';
			case 'code': return 'Código';
			case 'sup': return 'Supraíndice';
			case 'sub': return 'Subíndice';
			case 'var': return 'Variable';
			case 'time': return 'Fecha/hora';
			case 'mark': return 'Resaltado'; 
			case 'p': return 'Párrafo';
			case 'img': return 'Imágen';
			case 'a': return 'Vínculo';
			case 'table': return 'Tabla';
			case 'title': return 'Title...';
			case 'th': return 'Celda cabecera table';
			case 'td': return 'Celda de tabla';
			case 'ul': return 'Lista';
			case 'audio': return 'Audio';
			case 'video': case 'iframe': return 'Video';
			case 'root':return 'Tema';
			case 'fila': return 'Fila';
			case 'column': return 'Columna'
			
	 	}
	 }

	 if(EDITOR != 0){
	 	config()
	 }else{
	 	$('#tool-tema').hide()
	 }
	$('#media-editor').hide()
	 setTema()
	 
	 

 </script>



