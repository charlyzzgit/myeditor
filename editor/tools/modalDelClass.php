<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	

?>
 <div class="col-12 flex-col-start-center">
 	<h5>¿Eliminar Estilo Personalizado?</h5>
 	<div class="col-6 flex-row-between-center mt-2">
 		<button id="c-reset-si" class="btn btn-success">SI</button>
 		<button id="c-reset-no" class="btn btn-danger" data-dismiss="modal">NO</button>
 	</div>
 </div>

 <script>
 	
	$('#c-reset-si').click(function(){
			var aj = new Ajax()
			aj.add('action', 'deleteEstilo')
			aj.add('idestilo', OBJ.data('id-estilo'))
			loading(true)
			aj.send('../php/main.php', function(data){
				loading(false)
				if(data.result == SUCCESS){
					$('#content-editor').load('editor.php?editor=1')
					$('#c-reset-no').trigger('click')
				}else{
					wal('GUARDAR','Error al Procesar la Solicitud:' + data.message,'error')
				}

			})
		
	})

 </script>