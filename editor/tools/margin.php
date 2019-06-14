<style>
	.sector{
		width: 20%;
		height: 300px
	}

	.side{
		background: #f2f2f2
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-up mr-2"></i>
			<i class="fa fa-arrow-circle-down mr-2"></i>
			<i class="fa fa-arrow-circle-left mr-2"></i>
			<i class="fa fa-arrow-circle-right mr-2"></i>
			<b>Uniforme</b>
		</div>
		<div id="margin" class="col-6 mt-3"></div>
		
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-up mr-2"></i>
			<b>Superior</b>
		</div>
		<div id="margin-top" class="col-6 mt-3"></div>
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-down mr-2"></i>
			<b>Inferior</b>
		</div>
		<div id="margin-bottom" class="col-6 mt-3"></div>
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-left mr-2"></i>
			<b>Izquierdo</b>
		</div>
		<div id="margin-left" class="col-6 mt-3"></div>
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-right mr-2"></i>
			<b>Derecho</b>
		</div>
		<div id="margin-right" class="col-6 mt-3"></div>
	</div>
</div>

<script>
	'use strict'

	var margin = {
		top: getMargin(OBJ, 'top'),
		bottom: getMargin(OBJ, 'bottom'),
		left: getMargin(OBJ, 'left'),
		right: getMargin(OBJ, 'right')
	},
	inputs = []


	function setMargin(){
		OBJ.css({
			marginTop: margin.top + 'px',
			marginBottom: margin.bottom + 'px',
			marginLeft: margin.left + 'px',
			marginRight: margin.right + 'px'
		})
		ver(['margin', margin, OBJ.css('margin')])
	}

	$('.sector').each(function(index){
		var side = ''
		switch(index){
			case 1: side = '-top'; break;
			case 2: side = '-bottom'; break;
			case 3: side = '-left'; break;
			case 4: side = '-right'; break;
		}

		inputs.push({
			box:'margin' + side,
			type: 'spinner',
			min:0,
			max:100,
			label: 'Margen:',
			name: 'pd' + side,
			value: getMargin(OBJ, side.split('-')[1]),
			data:{side: side},
			callBack: function(value, data){

				var dt = getJson(data),
				side = exists(dt.side, '-') ? dt.side.split('-')[1] : ''
							
				switch(side){
					case 'top': margin.top = value; break;
					case 'bottom': margin.bottom = value; break;
					case 'left': margin.left = value; break;
					case 'right': margin.right = value; break;
					default: 
						margin.top = value
						margin.bottom = value
						margin.left = value
						margin.right = value
						$('#margin-top, #margin-bottom, #margin-left, #margin-right').find('input').val(value)
					break
				}
				setMargin()

			}
		})

	})

	$('#form-tool').form({
			inputs: inputs,
			minimize:true
	})

</script>