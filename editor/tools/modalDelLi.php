<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	$index= getPost($request, 'index', -1);
	$message = '';

	
 ?>


 <div class="col-12 flex-col-start-center">
 	<h5>¿Eliminar Item de la Lista</h5>
 	<div class="col-6 flex-row-between-center mt-2">
 		<button id="li-si" class="btn btn-success">SI</button>
 		<button id="li-no" class="btn btn-danger" data-dismiss="modal">NO</button>
 	</div>
 </div>



 <script>
 	var ind = parseInt('<?php print($index); ?>')
 	$('#li-si').click(function(){
	 	OBJ.find('li').each(function(index){
	 		var li = $(this)
	 		if(ind == index){
	 			li.remove()
	 		}
	 	})

	 	$('#list').find('li').each(function(index){
	 		var li = $(this)
	 		if(ind == index){
	 			li.remove()
	 			updateIndex()
	 			$('#li-no').trigger('click')
	 		}
	 	})
	 })

 </script> 