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
 		insert = 0

 	function getMediaButton(name){
 		var div = $('<div class="media flex-row-center-center"><button class="btn btn-warning"></button></div>')
 		div.css({
 			position: 'absolute', 
 			top:0, 
 			left:0, 
 			zIndex:100, 
 			background: 'rgba(0, 0, 0, .8)'
 		})
 		div.find('button').html(name)
 		return div
 	}
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
 			case 'icon':
 				elem = $('<i class="icon-editor fas fa-user"></i>')
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
 								//.prop('id', 'element-0')
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
 			alert('audio')
 				elem = $('<audio controls class="small-audio">\
						Su Navegador no soporta Audio.\
						</audio>')
 				elem.mouseover(function(){
 					OBJ.append(getMediaButton('Editar'))
 				}).mouseout(function(){
 					OBJ.find('.media').remove()
 				})
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
 		elem
 			.addClass('editable')
 			.prop('id', 'element-0')
 			.data('toggle','tooltip')
			.prop('title', 'Click para Editar')
			.tooltip()
 			.click(function(evt){
		 		evt.stopPropagation()
		 		OBJ = $(this)
		 		ver(['table', getTableContent(OBJ)])
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
			if(OBJ.closest('td')){
				alert(OBJ.prop('tagName'))
				if(OBJ.prop('tagName') == 'TABLE'){
					swal('ATENCION','Este sistema no permite tablas anidadas (Tablas dentro de otra Tabla), por favor escoja otro elemento u otro componente donde insertar una Tabla','warning')
					$('#cancel').trigger('click')
				}
				return
			}
			switch(parseInt(insert)){
				case 0: 
					OBJ.before(getInsert(tag))
				break
				case 1: 
					OBJ.after(getInsert(tag))
				break
				case 2: 
					OBJ.after('<div class="col-12"></div>')
					OBJ.after(getInsert(tag))
				break
			}
		}


		$('#cancel').trigger('click')
		
	})
 	
 </script>