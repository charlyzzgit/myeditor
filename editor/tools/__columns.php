<style>
	.sector{
		width: 100%;
		height: 300px
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div class="sector flex-col-center-center border p-2">
		<div class="btn-group btn-group-lg" role="group">
			<button class="btn-col btn btn-secondary" data-col="1">1 COLUMNA</button>
			<button class="btn-col btn btn-secondary" data-col="2">2 COLUMNAS</button>
			<button class="btn-col btn btn-secondary" data-col="3">3 COLUMNAS</button>
			<button class="btn-col btn btn-secondary" data-col="4">4 COLUMNAS</button>
		</div>
	</div>
</div>




<script>
	'use strict'
	ver(['cols',OBJ.data('cols')])
	$('.btn-col').click(function(){
		$('.btn-col').removeClass('btn-primary btn-secondary').addClass('btn-secondary')
		$(this).removeClass('btn-primary btn-secondary').addClass('btn-primary')
		var col = parseInt($(this).data('col'))
		OBJ.find('.column')
						.removeClass('col-md-4 col-md-6 col-lg-3 col-lg-4 col-lg-6')
		switch(col){
			
			case 2:
				OBJ.find('.column').addClass('col-md-6 col-lg-6')
			break
			case 3:
				OBJ.find('.column').addClass('col-md-4 col-lg-4')
			break
			case 4:
				OBJ.find('.column').addClass('col-md-6 col-lg-3')
			break
		}

		OBJ.data('cols', col)

		OBJ.find('.column').each(function(index){
			if(index + 1 > col){
				$(this).hide()
			}else{
				$(this).show()
			}

		})
	})

	$('.btn-col[data-col="' + OBJ.data('cols') + '"]').trigger('click')
</script>