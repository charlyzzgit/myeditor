<style>
	.sector{
		
		height: 300px
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start flex-wrap">
	<div class="sector col-6 flex-col-start-center border p-5">
		<div class="form-group flex-col-start-center">
			<label for="">Lista de Estilos Guardados</label>
			<select id="list-styles" class="custom-select"></select>
			<button id="apply-style" class="btn btn-success mt-3">Aplicar</button>
		</div>
	</div>
	<div class="sector col-6 flex-col-start-center border p-5">
		<div class="form-group flex-col-start-center">
			<label for="">Estilos Aplicados a este Elemento</label>
			<select id="obj-styles" class="custom-select"></select>
			<button id="del-style" class="btn btn-warning mt-3">Quitar Estilo</button>
			<div id="alert-style" class="alert-q col-7 flex-row-between-center alert-warning mt-2 p-2">
				<b>¿Quitar Estilo seleccionado?</b>
				<button class="si btn btn-sm btn-success">SI</button>
				<button class="no btn btn-sm btn-danger" data-alert="one">NO</button>
			</div>
			<button id="del-all-styles" class="btn btn-danger mt-5">Quitar Todos los Estilos</button>
			<div id="alert-all" class="alert-q col-9 flex-row-between-center alert-warning mt-2 p-2">
				<b>¿Quitar todos los Estilos Personalizados?</b>
				<button class="si btn btn-sm btn-success">SI</button>
				<button class="no btn btn-sm btn-danger" data-alert="all">NO</button>
			</div>
		</div>
	</div>
</div>


<script>
	'use strict'
	var list = []
	function getOptionStyle(e){
		var option = $('<option></option>')
		option
			.val(e != null ? e.id : '')
			.text(e != null ? e.name : 'Seleccionar Estilo')
		if(e != null){
			option.addClass(e.name)
		}
		return option
	}

	function loadEstilos(){
		var sel = $('#list-styles')
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

	function listarEstilosObj(){
		list = []
		var clas = OBJ.prop('class'), 
			sel = $('#obj-styles')

		$.each(ESTILOS, function(i, estilo){
			if(exists(clas, estilo.name)){
				list.push(estilo)
			}
		})

		sel.empty()
		sel.append(getOptionStyle(null))
		$.each(list, function(i, estilo){
			sel.append(getOptionStyle(estilo))
		})

	}

	function removeStyle(){
		var select = $('#obj-styles')
		select.closest('.form-group').find('.form-error').remove()
		if(select.val() != ''){
			OBJ.removeClass(select.find('option:selected').text())
			listarEstilosObj()
		}else{
			select
				.addClass('alert-danger')
				.focus(function(){
					$(this).removeClass('alert-danger')
					$(this).closest('.form-group').find('.form-error').remove()
				})
			select.after('<b class="form-error text-danger">No se seleccionó ningún estilo</b>')
		}
	}

	$('.alert-q').find('.no').click(function(){
		$('.alert-q').hide()
		if($(this).data('alert') == 'all'){
			$('#del-all-styles').show()
		}else{
			$('#del-style').show()
		}
	})
	$('.alert-q').hide()
	$('#alert-style').find('.si').click(function(){
		removeStyle()
		$('.alert-q').hide()
		$('#del-style').show()
	})

	$('#alert-all').find('.si').click(function(){
		$.each(list, function(i, sty){
			OBJ.removeClass(sty.name)
		})
		
		listarEstilosObj()
		$('.alert-q').hide()
		$('#del-all-styles').show()
	})

	$('#del-style').click(function(){
		$(this).hide()
		$('#alert-style').show()
	})

	$('#del-all-styles').click(function(){
		$(this).hide()
		$('#alert-all').show()
	})

	loadEstilos()
	listarEstilosObj()

	$('#apply-style').click(function(){
		var select = $('#list-styles')
		select.closest('.form-group').find('.form-error').remove()
		if(select.val() != ''){
			OBJ.addClass(select.find('option:selected').text())
			listarEstilosObj()
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