<style>
	.sector{
		height: 130px
	}

	.colbar{
		background: #f2f2f2;
		height: 40px
	}

	.form-group{
		width: auto
	}
</style>
<div id="form-tool" class="col-12 flex-col-start-start">
	<div class="colbar col-12 flex-row-start-center border">
		<div class="col-3 flex-row-center-center border text-dark h-100">COLUMNA 1</div>
		<div class="col-3 flex-row-center-center border text-dark h-100">COLUMNA 2</div>
		<div class="col-3 flex-row-center-center border text-dark h-100">COLUMNA 3</div>
		<div class="col-3 flex-row-center-center border text-dark h-100">COLUMNA 4</div>
	</div>
	<div class="col-12 flex-row-start-start">
		<div id="col-0" class="sector col-3 flex-col-start-center border p-4"></div>
		<div id="col-1" class="sector col-3 flex-col-start-center border p-4"></div>
		<div id="col-2" class="sector col-3 flex-col-start-center border p-4"></div>
		<div id="col-3" class="sector col-3 flex-col-start-center border p-4"></div>
	</div>
	<div class="swap col-12 flex-row-start-start">
		<div id="swap-0" class="sector col-3 flex-col-start-center border p-4"></div>
		<div id="swap-1" class="sector col-3 flex-col-start-center border p-4"></div>
		<div id="swap-2" class="sector col-3 flex-col-start-center border p-4"></div>
		<div id="swap-3" class="sector col-3 flex-col-start-center border p-4"></div>
	</div>
	
</div>

<script>
	'use strict'

	var inputs = []

	function swapCols(){
		var chks = $('.swap').find('input:checked'),
			columns = OBJ.find('.columnas'),
			col1 = parseInt($(chks[0]).prop('name').split('-')[1]),
			col2 = parseInt($(chks[1]).prop('name').split('-')[1]),
			cols = [0, 1, 2, 3],
			aux = cols[col1],
			clones = $('<ul></ul>')
			// params = [
			// 	{fila: OBJ.closest('.fila').prop('id')},
			// 	{menu: 'columns'},
			// 	{pos:$(window).scrollTop()}
			// ]
		cols[col1] = cols[col2]
		cols[col2] = aux

		columns.find('.column').each(function(index){
			$(this).data('num', cols[index])
			
		})
		cols = [0, 1, 2, 3]
		$.each(cols, function(i, col){
			columns.find('.column').each(function(){
				if(parseInt($(this).data('num')) == col){
					ver(['num', col])
					clones.append($(this))
				}
			})
		})
		ver(['clones', clones.find('li')])
		columns.empty()
		clones.find('li').each(function(i){

			columns.append($(this))
		})


		
		$('.swap').find('input').prop('checked', false)
	}

	OBJ.find('.column').each(function(index){
		var vis = parseInt($(this).data('visible')) == 1 ? true : false
		inputs.push({
           box: 'col-' + index,
           type: 'switch',
           label: 'Columna ' + (index + 1) + ':',
           name:'enabled-' + index,
           onColor: 'success',
           offColor: 'danger',
           onText: 'VISIBLE',
           offText: 'OCULTA',
           checked:vis,
           data: {col: index },
           callBack: function(value, data){
           	var dt = getJson(data),
           		col = parseInt(dt.col)
				OBJ.find('.column').each(function(index){
					if(index == col){
						$(this).data('visible', value ? 1 : 0)
						if(value){
							$('input[name="swapped-' + index + '"]').prop('disabled', false)
						}else{
							$('input[name="swapped-' + index + '"]').prop('disabled', true)
						}
						configCols(OBJ)
					}
				})
			}

         })

		inputs.push({
           box: 'swap-' + index,
           type: 'checkbox',
           label: 'Intercambiar Columna:',
           name:'swapped-' + index,
           checked:false,
           disabled: !vis ,
           data: {col: $(this).data('num')},
           callBack: function(value, data){
           	var dt = getJson(data),
           		col = dt.col
           		if($('.swap').find('input:checked').length == 2){
           			swapCols()
           		}
			}

         })
	})

	$('#form-tool').form({
			     inputs: inputs,
			     minimize:true
			  })
</script>

