<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	$tag = getPost($request, 'tag', NULL);
	$box = getPost($request, 'box', NULL);

 ?>


 <div class="col-12 flex-col-start-center">
	<div id="form" class="col-12 flex-col-start-center p-2">
		<div id="insert" class="col-5"></div>
	</div>
	<div class="col-10 flex-row-between-center mt-3">
		<button id="btn-insert" class="btn btn-success">Insertar</button>
		<button id="cancel" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	</div>
 </div>


 <script>
 	var tag = '<?php print($tag); ?>',
 		box = '<?php print($box); ?>',
 		options = [],
 		insert = box == 'col' ? 1 : 0

 	
 	function getInsert(tag){

 		var elem = null
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
 				elem = $('<' + tag + '>Nuevo Texto</' + tag + '>')
 			break
 			case 'p':
 				elem = $('<' + tag + '>Nuevo Texto Enriquecido</' + tag + '>')
 				elem.addClass('multi-text')
 			break
 			case 'icon':
 				elem = $('<i class="icon-editor fas fa-circle"></i>')
 			break
 			case 'img':
 				elem = $('<img>')
 				elem.prop('src', IMG + 'noimage.png').addClass('img-small')
 			break
 			case 'a':
 				elem = $('<a href="#">Nuevo Link</a>')
 			break
 			case 'table':
 				elem = getTable(null)

 				//elem.addClass('table-bordered table-striped')
 				elem.find('th span')
 								.addClass('editable')
 								.addClass('th')
					 			.data('toggle','tooltip')
								.prop('title', 'Click para Editar Texto')
								.tooltip()
					 			.click(function(evt){
							 		evt.stopPropagation()
							 		OBJ = $(this)

							 		setMenu('th')
							 		
									openEditor(true)
							 	})

 				elem.find('td')
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
 			break

 			case 'ul':
 				elem = getList(null)
 				
 				
 			break

 			case 'audio':
					elem = $('<div class="media-box audio-small"><audio controls class="media d-block">\
						Su Navegador no soporta Audio.\
						</audio></div>')
					
		 				
		 				setMediaEditor(elem)
		 			
		 			
			break
			case 'iframe':
	 				elem = $('<div class="media-box video-small"><iframe frameborder="0" class="media video" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>')
	 				
		 				
		 				setMediaEditor(elem)
		 			
		 			
	 		break

 			case 'hr':
	 				elem = $('<hr>') 
 			break

 			case 'imgGalery':
 				elem = $('<div class="flex-row-start-start flex-wrap galery"></div>')
 				
 			break
 		}

 		if(elem != null){
 			elem.css({
 				marginTop: '2px',
 				marginBottom: '2px',
 				marginLeft: '2px',
 				marginRight: '2px'
 			})
 		}

 		if(tag == 'audio' || tag == 'iframe'){
 			elem.find('.media').prop('id', 'element-0')
 		}else{
 			elem.prop('id', 'element-0')
 		}
 		elem
 			.addClass('editable')
 			.data('toggle','tooltip')
			.prop('title', 'Click para Editar')
			.tooltip()
 			.click(function(evt){
		 		evt.stopPropagation()
		 		OBJ = $(this).hasClass('media-box') ? $(this).find('.media') : $(this)
		 		
		 		setMenu(OBJ.prop('tagName').toLowerCase())
		 		
				openEditor(true)
		 	}).trigger('click')
 		return elem
 	}

 	if(box != null){
 		if(box == 'col'){
 			options = [
 				{name: 'Al Principio', value: 0},
 				{name: 'Al Final', value: 1}
 			]
 		}else{
 			options = [
 				{name: 'Delante', value: 0},
 				{name: 'Detrás', value: 1},
 				{name: 'Debajo', value: 2}
 			]
 		}
 	}

 	$('#form').form({
			inputs: [
				{
					box:'insert',
					type: 'radio',
					options: options,
					label: 'Insertar en:',
					name: 'insert-in',
					value: insert,
					
					callBack: function(value, data){
						insert = value				
					}
		}
	],
			minimize:true
	})

	$('#btn-insert').click(function(){

		if(box == 'col'){
			if(OBJ.prop('tagName') == 'TD'){
				if(tag == 'table'){
					swal('ATENCION','Este sistema no permite tablas anidadas (Tablas dentro de otra Tabla). \n Por favor escoja otro elemento u otro componente donde insertar una Tabla','warning')
					$('#cancel').trigger('click')
					return
				}

				if(tag == 'ul'){
					swal('ATENCION','Este sistema no permite Listas dentro de Tablas. \n Por favor escoja otro elemento u otro componente donde insertar una Tabla','warning')
					$('#cancel').trigger('click')
					return
				}
				
			}
			switch(parseInt(insert)){
				case 0: 
					OBJ.prepend(getInsert(tag))
				break
				case 1: 
					ver(['append'])
					OBJ.append(getInsert(tag))
				break
			}
		}else{
			ver(['closest', OBJ.closest('td')])
			// if(OBJ.closest('td')){
			// 	alert(OBJ.prop('tagName'))
			// 	if(OBJ.prop('tagName') == 'TABLE'){
			// 		swal('ATENCION','Este sistema no permite tablas anidadas (Tablas dentro de otra Tabla), por favor escoja otro elemento u otro componente donde insertar una Tabla','warning')
			// 		$('#cancel').trigger('click')
			// 	}
			// 	return
			// }
			var mtag = OBJ.prop('tagName').toLowerCase(),
				obj = null

			if(tag == 'table'){
				obj = OBJ.closest('.scroll-table')
			}else if(mtag == 'audio' || mtag == 'iframe'){
				//alert('xx')
				obj = OBJ.closest('.media-box')
			}else if(mtag == 'galery'){
				obj = OBJ.closest('.galery')
			}else{
				obj = OBJ
			}
			switch(parseInt(insert)){
				case 0: 
					obj.before(getInsert(tag))
				break
				case 1: 
					obj.after(getInsert(tag))
				break
				case 2: 
					ver(['debajo'])
					var jump = $('<div class="col-12 jump"></div>')
					obj.after(jump)
					jump.after(getInsert(tag))
				break
			}
		}


		$('#cancel').trigger('click')
		
	})
 	
 </script>