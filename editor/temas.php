<?php 
	error_reporting(1);
	require '../php/scripts.php';
	$temas = getTemas(0);
?>


<style>
	.tema i{
		font-size: 40px
	}


</style>

<div class="col-12 flex-col-start-center">
	<h3>Lista de Temas</h3>
	<ul id="list" class="col-12 flex-col-start-center p-3 m-0">
		<?php foreach ($temas as $key => $tema) { ?>
			<li class="tema hand col-12 flex-row-start-center p-2 mb-2 elevation-2 border alert-primary" data-id="<?php print($tema->id); ?>">
				<i class="fas fa-graduation-cap mr-2"></i>
				<h5><?php print($tema->titulo); ?></h5>
			</li>
		<?php } ?>
		
	</ul>
</div>


<script>
	'use strict'

	$('.tema').mouseover(function(){
		$(this).removeClass('alert-primary').addClass('alert-info')
	}).mouseout(function(){
		$(this).removeClass('alert-info').addClass('alert-primary')
	}).click(function(){
		var id = $(this).data('id')
		goTo('editor', [{name: 'id', value: id}])
	})

	loading(false)
</script>