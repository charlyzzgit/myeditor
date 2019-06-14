<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	$index= getPost($request, 'index', -1);
	$del = getPost($request, 'del', '');
	$message = '';

	switch($del){
		case 'row': $message = '¿Eliminar Fila?'; break;
		case 'col': $message = '¿Eliminar Columna?'; break;
	}
 ?>


 <div class="col-12 flex-col-start-center">
 	<h5><?php print($message); ?></h5>
 	<div class="col-6 flex-row-between-center mt-2">
 		<button id="tb-si" class="btn btn-success">SI</button>
 		<button id="tb-no" class="btn btn-danger" data-dismiss="modal">NO</button>
 	</div>
 </div>



 <script>
 	var ind = parseInt('<?php print($index); ?>'), 
 		del = '<?php print($del); ?>'

 	$('#tb-si').click(function(){
 		if(del == 'row'){
	 		if(OBJ.find('tbody tr').length > 1){
		 		OBJ.find('tbody tr').each(function(index){
		 			if(ind == index){
		 				$(this).remove()
		 				setTable()
		 			}
		 		})
		 	}else{
		 		swal('ATENCION','La Tabla debe contener al menos una Fila','warning')
		 	}
		 }else{
		 	OBJ.find('tr').each(function(){
					var tr = $(this)
					if(tr.find('th, td').length > 1){
						tr.find('th, td').each(function(index){
							
							if(index == ind){
								$(this).remove()
								setTable()
							}
						})
					}else{
						swal('ATENCION','La Tabla debe contener al menos una Columna','warning')
					}
				})
		 }
 		$('#tb-no').trigger('click')
 	})
 </script>