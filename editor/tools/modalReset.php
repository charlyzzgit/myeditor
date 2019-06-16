
 <div class="col-12 flex-col-start-center">
 	<h5>¿Restablecer todos <br>los Estilos y Clases <br> a su estado inicial?</h5>
 	<div class="col-6 flex-row-between-center mt-2">
 		<button id="reset-si" class="btn btn-success">SI</button>
 		<button id="reset-no" class="btn btn-danger" data-dismiss="modal">NO</button>
 	</div>
 </div>

 <script>
 	
	$('#reset-si').click(function(){
		ver(['obj', OBJ])
		resetCss(OBJ)
		$('#reset-no').trigger('click')
	})

 </script>