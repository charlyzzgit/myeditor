<style>
	.sector{
		height: 250px;
		background: #f2f2f2;
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start flex-wrap">
	<div class="col-12 flex-row-center-center" style="height: 50px">
		<button id="label-remove" class="btn btn-sm btn-danger">Remover Etiqueta</button>
	</div>
	<div id="alert" class="col-6 sector flex-row-around-center flex-wrap border p-4"></div>
	<div id="badge" class="col-6 sector flex-row-around-center flex-wrap border p-4"></div>
</div>


<script>
	'use strict'
	var tips = [
		'primary',
		'secondary',
		'info',
		'success',
		'warning',
		'danger',
		'light',
		'dark'
	]

	function removeTips(){
		$.each(tips, function(i, tip){
			OBJ.removeClass('alert badge alert-' + tip + ' badge-' + tip)
		})
	}

	$.each(tips, function(i, tip){
		var alt = $('<span></span>'),
			bad = $('<span></span>')
		alt
			.addClass('hand ml-4 mr-4 alert alert-' + tip)
			.html(tip)
			.css('font-size', '18px')
			.data('class', tip)
			.click(function(){
				var clas = 'alert alert-' + $(this).data('class')
				removeTips()
				OBJ.addClass(clas)
			})
		bad
			.addClass('hand ml-4 mr-4 badge badge-' + tip)
			.html(tip)
			.css('font-size', '18px')
			.data('class', tip)
			.click(function(){
				var clas = 'badge badge-' + $(this).data('class')
				removeTips()
				OBJ.addClass(clas)
			})
		$('#alert').append(alt)
		$('#badge').append(bad)
	})

	$('#label-remove').click(function(){
		removeTips()
	})
</script>