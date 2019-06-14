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
		<div id="padding" class="col-6 mt-3"></div>
		
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-up mr-2"></i>
			<b>Superior</b>
		</div>
		<div id="padding-top" class="col-6 mt-3"></div>
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-down mr-2"></i>
			<b>Inferior</b>
		</div>
		<div id="border-color-bottom" class="col-12"></div>
		<div id="padding-bottom" class="col-6 mt-3"></div>
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-left mr-2"></i>
			<b>Izquierdo</b>
		</div>
		<div id="padding-left" class="col-6 mt-3"></div>
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-right mr-2"></i>
			<b>Derecho</b>
		</div>
		<div id="padding-right" class="col-6 mt-3"></div>
	</div>
</div>

<script>
	'use strict'

	var padding = {
		top: getPadding(OBJ, 'top'),
		bottom: getPadding(OBJ, 'bottom'),
		left: getPadding(OBJ, 'left'),
		right: getPadding(OBJ, 'right')
	},
	inputs = []


	function setPadding(){
		OBJ.css({
			paddingTop: padding.top + 'px',
			paddingBottom: padding.bottom + 'px',
			paddingLeft: padding.left + 'px',
			paddingRight: padding.right + 'px'
		})
		ver(['padding', padding, OBJ.css('padding')])
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
			box:'padding' + side,
			type: 'spinner',
			min:0,
			max:100,
			label: 'Relleno:',
			name: 'pd' + side,
			value: getPadding(OBJ, side.split('-')[1]),
			data:{side: side},
			callBack: function(value, data){

				var dt = getJson(data),
				side = exists(dt.side, '-') ? dt.side.split('-')[1] : ''
							
				switch(side){
					case 'top': padding.top = value; break;
					case 'bottom': padding.bottom = value; break;
					case 'left': padding.left = value; break;
					case 'right': padding.right = value; break;
					default: 
						padding.top = value
						padding.bottom = value
						padding.left = value
						padding.right = value
						$('#padding-top, #padding-bottom, #padding-left, #padding-right').find('input').val(value)
					break
				}
				setPadding()

			}
		})

	})

	$('#form-tool').form({
			inputs: inputs,
			minimize:true
	})

</script>