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

	#modal-class{
		position: fixed;
		top:-500px;
		left: 0;
		z-index: 50;
		box-shadow: 0 2px 10px 2px rgba(0, 0, 0, .2)
	}

	#modal-class .inner{
		height: 300px;
		overflow-y: auto;
		background: #f2f2f2
	}

	#class-preview{
		
		padding: 20px;
		font-family: arial;
		font-size: 16px;
		color: rgba(0, 0, 0, 1);
		background: rgba(255, 255, 255, 1)
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

	#modal-save-class{
		position: fixed;
		right: 10px;
		bottom:50px;
		z-index:2000;
		border-radius: 2px
	}


</style>
<div id="modal-class" class="col-12 flex-col-start-center">
	<div class="col-12 text-center bg-pimary text-white p-2">Vista Previa de Clase</div>
	<div class="inner col-12 flex-row-center-center">
		<div id="class-preview" class="flex-row-center-center">Vista Previa</div>
	</div>
</div>
<div id="modal-save-class" class="flex-col-start-center p-1 bg-white elevation-2">
	<button class="save btn btn-info btn-sm"><i class="fa fa-save"></i></button>
	<button class="add-css btn btn-secondary btn-sm mt-2"><i class="fa-css3-alt fab"></i></button>
</div>
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
			<button class="ver-demo btn btn-dark btn-sm mr-2"><i class="fa fa-desktop"></i></button>
			<button class="tema-edit btn btn-success btn-sm mr-2"><i class="fa fa-pen"></i></button>
			<button class="add-fila btn btn-primary btn-sm mr-2"><i class="fa fa-plus"></i></button>
			<button class="save btn btn-info btn-sm mr-2"><i class="fa fa-save"></i></button>
			<button class="restore btn btn-warning btn-sm mr-2"><i class="fas fa-undo-alt"></i></button>
			<button class="add-css btn btn-secondary btn-sm mr-2"><i class="fa-css3-alt fab"></i></button>
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

		modalInsert, modalTextos, modalDelete, modalDevice, modalIcons, modalReset, modalClass,
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

	if(modalReset == null){
		modalReset = new Modal({
        	title: 'Restablecer',
        	size: 'small',
        	bg: 'bg-warning'
      	})
	}

	if(modalClass == null){
		modalClass = new Modal({
        	title: 'Estilos Personalizados',
        	size: 'medium',
        	bg: 'bg-secondary'
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
			case 'p':
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
					{name: 'restablecer', value:'reset'},
					{name: 'eliminar', value:'delete'},
					
				]

				if(OBJ.hasClass('icon-editor')){
					menu = [
						{name: 'icono', value:'icon'},
						{name: 'texto', value:'text'},
						{name: 'margen', value:'margin'},
						{name: 'sombra', value:'shadow'},
						{name: 'insertar', value:'insert'},
						{name: 'restablecer', value:'reset'},
						{name: 'eliminar', value:'delete'},
						
					]
				}
				if(OBJ.hasClass('th')){
					menu = [
						{name: 'texto', value:'text'}, 
						{name: 'restablecer', value:'reset'}

					]
				}

				if(OBJ.hasClass('multi-text')){
					
					menu = [
						{name: 'texto', value:'text'},
						{name: 'multitexto', value:'textEditor'},
						{name: 'fondo', value:'background'},
						{name: 'borde', value:'border'},
						{name: 'margen', value:'margin'},
						{name: 'relleno', value:'padding'},
						{name: 'sombra', value:'shadow'},
						{name: 'insertar', value:'insert'},
						{name: 'restablecer', value:'reset'},
						{name: 'eliminar', value:'delete'}
						
					]
				}

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
					{name: 'restablecer', value:'reset'},
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
					{name: 'restablecer', value:'reset'},
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
					{name: 'restablecer', value:'reset'},
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
					{name: 'fondo', value:'background'}, 
					{name: 'restablecer', value:'reset'}
					
	
				]
			break
			case 'td':
				menu = [
					{name: 'alineacion', value:'align'},
					{name: 'fondo', value:'background'},
					{name: 'insertar', value:'insert'}, 
					{name: 'restablecer', value:'reset'}
	
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
					{name: 'restablecer', value:'reset'},
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
					{name: 'restablecer', value:'reset'},
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
					{name: 'restablecer', value:'reset'},
					{name: 'eliminar', value:'delete'}
				]
			break

			case 'hr':
				menu = [
					{name: 'fondo', value:'background'},
					{name: 'Dimensiones', value:'size'},
					{name: 'margen', value:'margin'},
					{name: 'sombra', value:'shadow'},
					
					{name: 'insertar', value:'insert'},
					{name: 'restablecer', value:'reset'},
					{name: 'eliminar', value:'delete'},
					
				]
			break



		}
		$('#modal-edit').find('.name').text('Editando ' + getActual(tag))
		var size = menu.length
	 	$.each(menu, function(i, l){
	 		var li = $('<li class="menu-item"><b></b></li>'),
	 			sel = (l.value != 'delete' && l.value != 'empty' && l.value != 'reset') ? 'bg-info' : (l.value == 'reset') ? 'bg-warning' : 'bg-danger',
	 			over = (l.value != 'delete' && l.value != 'empty' && l.value != 'reset') ? 'bg-dark' : (l.value == 'reset') ? 'bg-warning' : 'bg-danger'
	 		li.css('width', (100/size) + '%')
	 		li.find('b').html(l.name.toUpperCase())
	 		li.addClass('flex-row-center-center bg-secondary text-white')
	 		li.data('type', l.value)
	 		li.mouseover(function(){
	 			$(this).removeClass('bg-secondary bg-dark bg-info bg-danger bg-warning').addClass(over)
	 		}).mouseout(function(){
	 			var active = parseInt($(this).data('active')),
	 				bg = (active == 1) ? sel : 'bg-secondary'
	 			$(this).removeClass('bg-secondary bg-dark bg-info bg-danger bg-warning').addClass(bg)
	 		}).click(function(){

	 			$('.menu-item').removeClass('bg-secondary bg-dark bg-info bg-danger bg-warning').addClass('bg-secondary').data('active', 0)
	 			$(this).removeClass('bg-secondary bg-dark bg-info bg-danger').addClass(sel).data('active', 1)
	 			var tool = $(this).data('type')
	 			if(tool != 'delete' && tool != 'reset'){
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
	 				if(tool == 'delete'){
		 				var id = OBJ.prop('id')
		 					
		 				 modalDelete.openModal('modalDelete.php?id=' + id + '&del=element')
		 			}else{
		 				modalReset.openModal('tools/modalReset.php')
		 			}
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

		$('.restore').data('toggle','tooltip')
			           .prop('title', 'Restablecer Tema')
			           .tooltip()
			           .click(function(){
			           		OBJ = $('#tema')
			           		modalReset.openModal('tools/modalReset.php')
			           })
 		
	    $('.add-css').data('toggle','tooltip')
			           .prop('title', 'Estilos Personalizadas')
			           .tooltip()
			           .click(function(){
			           		OBJ = $('#class-preview')
			           		modalClass.openModal('tools/modalClass.php')
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

	 	$(window).scroll(function(){
	 		if($(window).scrollTop() > 100){
	 			$('#modal-save-class').show()
	 		}else{
	 			$('#modal-save-class').hide()
	 		}
	 	})
	 }

	 function setEditables(){
	 	$('.editable').click(function(evt){
	 		evt.preventDefault()
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
				 				<i class="reset-col fa fa-undo-alt text-warning hand ml-2"></i>\
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

		
		col.find('.col-content').html(base64Decode(column.content))
		
		
		if(EDITOR != 0){
			setElements(col.find('.col-content'))
		}
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
				 				<button class="fila-edit btn btn-success btn-sm mr-2"><i class="fa fa-pen"></i>\
				 				<button class="fila-reset btn btn-warning btn-sm mr-2"><i class="fas fa-undo-alt"></i>\
				 				<button class="fila-del btn btn-danger btn-sm mr-2"><i class="fa fa-times"></i>\
				 			</div>\
				 		</div>\
				 		<div class="fila-content col-12 flex-col-start-start">\
		 					<div class="col-12 flex-row-between-center">\
					 			<h3 class="title titulo-fila">Título Fila</h3>\
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
	 	setCss(row.find('.title'), fila.estilos_titulo)
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
	 	}else if(obj.hasClass('editable')){
	 		tag = obj.prop('tagName').toLowerCase()
	 	}
	 	
	 		//ver(['getcss', tag, obj.text(), obj.css('color')])
	 	
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

	 function setTooltip(obj){
	 	
		obj
			.addClass('editable')
			.data('toggle','tooltip')
			.prop('title', 'Click para Editar ' + obj.prop('tagName'))
			.tooltip()
		
	 }

	 function addFlag(box){
	 	box.children().each(function(){
	 		if($(this).hasClass('editable')){
	 			//$(this).addClass('eddittable')
	 		}
	 		addFlag($(this))
	 	})
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
	 		
	 		li.find('.column').each(function(i){

	 			var col = $(this).find('.col-content'),
	 				idcol = $(this).find('.col-content').prop('id').split('col-')[1]
	 				elements = []
	 			addFlag(col) //agrega editable
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

	 				el.removeClass('editable selected')
		 			
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
	 					//elements: elements, 
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
	 		li.find('.title').removeClass('editable selected')
	 		//ver(['estilos fila', getCss(li.find('.fila-content'))])
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
	 	//console.clear()
	 	//ver(['send', TEMA])
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
			case 'hr': return 'Linea';
			case 'root':return 'Tema';
			case 'fila': return 'Fila';
			case 'column': return 'Columna'
			
	 	}
	 }

	 $('#modal-save-class').hide()

	 if(EDITOR != 0){
	 	config()
	 }else{
	 	$('#tool-tema').hide()
	 }
	$('#media-editor').hide()
	 setTema()
	 
	 

 </script>



