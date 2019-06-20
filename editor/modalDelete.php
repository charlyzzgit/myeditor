<?php 
	require '../php/scripts.php';
	$request = $_REQUEST;
	$id = getPost($request, 'id', 0);
	$index= getPost($request, 'index', -1);
	$del = getPost($request, 'del', '');
	$message = '';

	switch($del){
		case 'fila': $message = '¿Eliminar Bloque?'; break;
		case 'column': $message = '¿Vaciar Columna?'; break;
		case 'element': $message = '¿Eliminar Elemento?'; break;
	}
 ?>


 <div class="col-12 flex-col-start-center">
 	<h5><?php print($message); ?></h5>
 	<div class="col-6 flex-row-between-center mt-2">
 		<button id="si" class="btn btn-success">SI</button>
 		<button id="no" class="btn btn-danger" data-dismiss="modal">NO</button>
 	</div>
 </div>



 <script>
 	var del = '<?php print($del); ?>',
 		id = '<?php print($id); ?>',
 		index = parseInt('<?php print($index); ?>')
 	$('#si').click(function(){
 		$('#no').trigger('click')
 		//loading(true)
 		switch(del){
 			case 'fila':
 				var idfila = parseInt(id)
 				if(idfila != 0){
	 				var aj = new Ajax()
	 				aj.add('action', 'delFila')
	 				aj.add('idfila', idfila)
	 				loading(true)
	 				aj.send('../php/main.php', function(data){
	 					loading(false)
	 					if(data.result == SUCCESS){
	 						$('#filas .fila')[index].remove()
 							updateFilas()
	 						openEditor(false)
	 						swal('ELIMINAR','El Bloque fue eliminado con éxito','success')
	 					}else{
	 						swal('ELIMINAR','No se pudo eliminar este Bloque:' + data.message,'error')
	 					}
	 				})
	 			}else{
	 				$('#filas .fila')[index].remove()
 					updateFilas()
	 				openEditor(false)
	 				swal('ELIMINAR','El Bloque fue eliminado con éxito','success')
	 			}
 				
 			break
 			case 'column':
 				
	 				OBJ.empty()
	 				save('delete')
	 				openEditor(false)
	 				swal('VACIAR','Los elementos de esta columna fueron removidos con éxito')
	 			
 			break
 			case 'element':
 				
	 			OBJ.remove()
	 			save('delete')
 				
 			break
 		}
 		
 	})
 </script>