<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	// $docente = getPost($request, 'docente', 0);
	// $estilos = getEstilos($docente);

 ?>


 <div id="form-class" class="col-12 flex-col-start-center">
 	<div class="col-12 alert-success p-2">
		<div class="col-12 form-group">
			<label for="">Estilos Creados</label>
			<select name="" id="sel-class" class="custom-select"></select>
		</div>
		<div id="botonera" class="col-12 flex-row-start-center">
			<button id="btn-class" class="btn btn-success">Editar</button>
			<button id="btn-del-class" class="btn btn-danger ml-2">Eliminar</button>
		</div>
		<div id="alert-del" class="col-12 flex-row-start-center alert alert-warning p-1">
			<b>¿Eliminar Estilo?</b>
			<button class="si btn btn-sm btn-success ml-3">SI</button>
			<button class="no btn btn-sm btn-danger ml-2">NO</button>
		</div>
	</div>
	<div class="col-12 alert-primary p-2 mt-4">
		<div class="col-12 form-group ">
			<label for="">Nuevo Estilo</label>
			<input type="text" id="name-class" class="form-control" placeholder="Nombre del Estilo">
		</div>
		<button id="btn-newclass" class="btn btn-primary">Crear</button>
	</div>
	<div id="cerrar-class" class="d-none" data-dismiss="modal"></div>
 </div>

<script>
	
	function classEncode(c){
		return 'Editor-' + c
	}

	function classDecode(c){
		return  c.split('Editor-')[1]
	}

	function getOptionStyle(e){
		var option = $('<option></option>')
		option
			.val(e != null ? e.id : '')
			.text(e != null ? classDecode(e.name) : 'Seleccionar Estilo')
		if(e != null){
			option.addClass(e.name)
		}
		return option
	}

	function loadEstilos(){
		var sel = $('#sel-class')
		sel.empty()
		sel.append(getOptionStyle(null))
		$.each(ESTILOS, function(i, estilo){
			sel.append(getOptionStyle(estilo))
		})
	}

	function getEstilo(id){
		var e = null
		$.each(ESTILOS, function(i, estilo){
			if(estilo.id == id){
				e = estilo
			}
		})
		return e
	}

	function deleteEstilo(id){
		$.each(ESTILOS, function(i, estilo){
			if(estilo.id == id){
				ESTILOS.splice(i, 1)
				loadEstilos()
			}
		})
	}

	function estiloExists(name){
		for(var i = 0; i < ESTILOS.length; i++){
			if(ESTILOS[i].name == classEncode(name)){
				return true
			}
		}
		return false
	}


	$('#alert-del').hide()

	$('#alert-del').find('.no').click(function(){
		$('#botonera').show()
		$('#alert-del').hide()
	})

	$('#alert-del').find('.si').click(function(){
		$('#botonera').show()
		$('#alert-del').hide()
		var aj = new Ajax()
		aj.add('action', 'deleteEstilo')
		aj.add('idestilo', $('#sel-class').val())
		loading(true)
		aj.send('../php/main.php', function(data){
			loading(false)
			if(data.result == SUCCESS){
				deleteEstilo(parseInt($('#sel-class').val()))
				swal('GUARDAR','Estilo eliminado correctamente','success')
			}else{
				swal('GUARDAR','Error al Procesar la Solicitud:' + data.message,'error')
			}

		})
	})

	$('#btn-del-class').click(function(){
		$('#botonera').hide()
		$('#alert-del').show()
	})

	loadEstilos()

	$('#btn-newclass').click(function(){
		var input = $('#name-class')
		input.closest('.form-group').find('.form-error').remove()
		if(input.val() != '' && !estiloExists(input.val())){
			var aj = new Ajax()
			aj.add('action', 'saveEstilo')
			aj.add('iddocente', TEMA.id_docente)
			aj.add('idestilo', 0) 
			aj.add('name', classEncode(input.val()))
			aj.add('estilos', toJson(getCss(OBJ)))
			loading(true)
			aj.send('../php/main.php', function(data){
				loading(false)
				if(data.result == SUCCESS){
					OBJ.data('id-estilo', data.id)
					ESTILOS = data.estilos
					var e = getEstilo(parseInt(data.id))
					
					setMenu('css')
	 				openClass(true)
					openEditor(true)
					swal('GUARDAR','Estilo creado correctamente', 'success')
					$('#class-preview').text(e.name)
					$('#important').bootstrapSwitch('state', parseInt(e.important) == 1 ? true : false)
					$('#cerrar-class').trigger('click')
				}else{
					swal('GUARDAR','Error al Guardar:' + data.message,'error')
				}
			})
		}else{
			var msg = estiloExists(input.val()) ? 'El Nombre Insertado ya existe para otro estilo' : 'No se asignó un Nombre de estilo'
			input
				.addClass('alert-danger')
				.focus(function(){
					$(this).removeClass('alert-danger')
					$(this).closest('.form-group').find('.form-error').remove()
				})
			input.after('<b class="form-error text-danger">' + msg + '</b>')
		}
	})

	$('#btn-class').click(function(){
		var select = $('#sel-class')
		select.closest('.form-group').find('.form-error').remove()
		if(select.val() != ''){
			var e = getEstilo(select.val())
			
			if(e != null){
				setCss(OBJ, e.estilos)
				OBJ.data('id-estilo', e.id)
				setMenu('css')
				$('#class-preview').text(classDecode(e.name))
				$('#important').bootstrapSwitch('state', parseInt(e.important) == 1 ? true : false)
	 			openClass(true)
				openEditor(true)
				$('#cerrar-class').trigger('click')
			}
			
		}else{
			select
				.addClass('alert-danger')
				.focus(function(){
					$(this).removeClass('alert-danger')
					$(this).closest('.form-group').find('.form-error').remove()
				})
			select.after('<b class="form-error text-danger">No se seleccionó ningún estilo</b>')
		}
	})

</script>
