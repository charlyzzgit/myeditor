<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	$box = getPost($request, 'box', NULL);
	

 ?>


 <div id="form-class" class="col-12 flex-col-start-center">
 	<div class="col-12 alert-success p-2">
		<div class="col-12 form-group">
			<label for="">Estilos Creados</label>
			<select name="" id="sel-class" class="custom-select"></select>
		</div>
		<button id="btn-class" class="btn btn-success">Editar</button>
	</div>
	<div class="col-12 alert-primary p-2 mt-4">
		<div class="col-12 form-group ">
			<label for="">Nuevo Estilo</label>
			<input type="text" id="name-class" class="form-control" placeholder="Nombre del Estilo">
		</div>
		<button id="btn-newclass" class="btn btn-primary">Crear</button>
	</div>
	<div id="cerrar" class="d-none"></div>
 </div>

<script>
	function getOptionStyle(e){
		var option = $('<option></option>')
		option
			.val(e = null ? e : '')
			.text(e = null ? e : 'Seleccionar Estilo')
		return option
	}

	function loadEstilos(){
		var sel = $('#sel-class')
		sel.empty()
		sel.append(getOptionStyle(null))
	}



	loadEstilos()

	$('#btn-newclass').click(function(){
		var input = $('#name-class')
		input.closest('.form-group').find('.form-error').remove()
		if(input.val() != ''){

		}else{
			input
				.addClass('alert-danger')
				.focus(function(){
					$(this).removeClass('alert-danger')
					$(this).closest('.form-group').find('.form-error').remove()
				})
			input.after('<b class="form-error text-danger">No se asignó un Nombre de estilo</b>')
		}
	})

	$('#btn-class').click(function(){
		var select = $('#sel-class')
		select.closest('.form-group').find('.form-error').remove()
		if(select.val() != ''){

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
