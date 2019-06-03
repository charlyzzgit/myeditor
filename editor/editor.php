<?php 
 ?>

<style>
	.main, .columnas{
		list-style: none;
	}

	/*.column-toolbar{
		position: absolute;
		top:0;
		left: 0;
		width: 100%;
		z-index: 100;
	}*/
</style>

 <ul class="main col-12 flex-col start-center m-0">
 	<li class="fila col-12 flex-col-start-start p-2">
 		<h3>Título Fila</h3>
 		<ul class="columnas col-12 flex-row-start-start m-0">
 			<?php for($i = 0; $i < 4; $i++) { ?>
 			<li class="column col-12 col-md-6 col-lg-3">
 				<!-- <div class="column-toolbar flex-row-between-center bg-light elevation-1"></div> -->
 			</li>
 			<?php } ?>
 		</ul>
 	</li>
 </ul>



