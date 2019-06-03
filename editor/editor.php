<?php 
 ?>

<style>
	.main, .columnas{
		list-style: none;
	}
</style>

 <ul class="main col-12 flex-col start-center p-0 m-0">
 	<li class="fila col-12 flex-col-start-start p-2">
 		<h3>Título Fila</h3>
 		<ul class="columnas col-12 flex-row-start-start m-0 p-0">
 			<?php for($i = 0; $i < 4; $i++) { ?>
 			<li class="column col-12 col-md-6 col-lg-3 p-0">
 				columna
 			</li>
 			<?php } ?>
 		</ul>
 	</li>
 </ul>



 