<?php 
	error_reporting(1);
	require '../php/scripts.php';
	$temas = getTemas(0);
	$id_docente = getPost($request, 'iddocente', 0);
	$id_curso = getPost($request, 'idcurso', 0);
	$id_modulo = getPost($request, 'idmodulo', 0);
	$id_clase = getPost($request, 'idclase', 0);
?>


<style>
	.ppal{
		font-size: 40px
	}


</style>

<div class="col-12 flex-col-start-center p-3">
	<div class="col-12 flex-row-between-center">
		<h3>Lista de Temas</h3>
		<button id="new" class="btn btn-primary">Crear Tema Nuevo</button>
	</div>
	<div id="form" class="col-12 flex-row-between-center">
		<div id="name" class="col-6"></div>
		<div id="snd" class="col-6 pt-4 pl-4 mt-1"></div>
	</div>
	<ul id="list" class="col-12 flex-col-start-center m-0 mt-2">
		<?php foreach ($temas as $key => $tema) { ?>
			<li class="tema hand col-12 flex-row-between-center p-2 mb-2 elevation-2 border alert-primary">
				<div class="flex-row-start-center">
					<i class="ppal fas fa-graduation-cap mr-2"></i>
					<h5><?php print($tema->titulo); ?></h5>
				</div>
				<div class="flex-row-start-center">
					<button class="edit btn btn-success"  data-id="<?php print($tema->id); ?>">
						<i class="fas fa-pen"></i>
					</button>
					<button class="del btn btn-danger ml-2"  data-id="<?php print($tema->id); ?>">
						<i class="fas fa-trash"></i>
					</button>
				</div>
			</li>
		<?php } ?>
		
	</ul>
</div>


<script>
	'use strict'
	var iddocente = '<?php print($iddocente); ?>',
		idcurso = '<?php print($idcurso); ?>',
		idmodulo = '<?php print($iddocente); ?>',
		idclase = '<?php print($idclase); ?>'
	$('#form').hide()
	$('.tema').mouseover(function(){
		$(this).removeClass('alert-primary').addClass('alert-info')
	}).mouseout(function(){
		$(this).removeClass('alert-info').addClass('alert-primary')
	}).find('.edit').click(function(){
		var id = $(this).data('id')
		goTo('editor', [{name: 'id', value: id}])
	})

	$('#form').form({
		inputs: [
			{
				box:'name',
				name: 'iddocente',
				type:'hidden',
				value: iddocente
			},
			{
				box:'name',
				name: 'idcurso',
				type:'hidden',
				value: idcurso
			},
			{
				box:'name',
				name: 'idmodulo',
				type:'hidden',
				value: idmodulo
			},
			{
				box:'name',
				name: 'idclase',
				type:'hidden',
				value: idclase
			},
			{
				box:'name',
				name: 'num',
				type:'hidden',
				value: $('#list li').length + 1
			},

			{
				box:'name',
				label: 'Titulo del Tema:',
				name: 'titulo',
				type:'text'
			},

			{
                box: 'snd',
                type: 'submit',
                label: 'Crear',
                btn: 'success',
                url:'../php/main.php',
                action: 'newTema',
                title: 'Submit',
                callBack: function(data){
                  if(data.result == 'OK'){
                      swal('OK','Guardar','success').then((value) => {
					  location.reload(true);
				});
                      
                  }else{
                      swal('ERROR',data.message,'error')    
                  }
                }
              }
		]
	})

	$('#new').click(function(){
		$('#form').slideDown(150)
	})
	loading(false)
</script>