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
		<div id="radius" class="col-6 mt-3"></div>
		
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-up mr-2"></i>
			<i class="fa fa-arrow-circle-left mr-2"></i>
			<b>Superior - Izquierda</b>
		</div>
		<div id="radius-top-left" class="col-6 mt-3"></div>
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-up mr-2"></i>
			<i class="fa fa-arrow-circle-right mr-2"></i>
			<b>Superior - Derecha</b>
		</div>
		<div id="radius-top-right" class="col-6 mt-3"></div>
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-down mr-2"></i>
			<i class="fa fa-arrow-circle-left mr-2"></i>
			<b>Inferior - Izquierda</b>
		</div>
		<div id="radius-bottom-left" class="col-6 mt-3"></div>
	</div>
	<div class="sector flex-col-start-center border p-2">
		<div class="alert alert-dark col-12 flex-row-center-center mb-2">
			<i class="fa fa-arrow-circle-down mr-2"></i>
			<i class="fa fa-arrow-circle-right mr-2"></i>
			<b>Inferior - Derecha</b>
		</div>
		<div id="radius-bottom-right" class="col-6 mt-3"></div>
	</div>
</div>

<script>
	'use strict'

	var corner = getRadius(OBJ.css('borderRadius')),
		inputs = []

	function setRadius(){
		OBJ.css({
			borderTopLeftRadius: corner.topLeft + 'px',
			borderTopRightRadius: corner.topRight + 'px',
			borderBottomLeftRadius: corner.bottomLeft + 'px',
			borderBottomRightRadius: corner.bottomRight + 'px',
		})
	}

	$('.sector').each(function(index){
		var side = '',
			val = Math.round((parseInt(corner.topLeft) + parseInt(corner.topRight) + parseInt(corner.bottomLeft) + parseInt(corner.bottomRight))/4)
		switch(index){
			case 1: side = '-top-left'; val = corner.topLeft; break;
			case 2: side = '-top-right'; val = corner.topRight; break;
			case 3: side = '-bottom-left'; val = corner.bottomLeft; break;
			case 4: side = '-bottom-right'; val = corner.bottomRight; break;
		}

		inputs.push({
			box:'radius' + side,
			type: 'spinner',
			min:0,
			max:1000,
			label: 'Redondez:',
			name: 'br' + side,
			value: val,
			data:{side: side},
			callBack: function(value, data){

				var dt = getJson(data),
				side = exists(dt.side, '-') ? dt.side.split('-')[1] + '-' + dt.side.split('-')[2] : ''
							
				switch(side){
					case 'top-left': corner.topLeft = value; break;
					case 'top-right': corner.topRight = value; break;
					case 'bottom-left': corner.bottomLeft = value; break;
					case 'bottom-right': corner.bottomRight = value; break;
					default: 
						corner.topLeft = value
						corner.topRight = value
						corner.bottomLeft = value
						corner.bottomRight = value
						$('#radius-top-left, #radius-top-right, #radius-bottom-left, #radius-bottom-right').find('input').val(value)
					break
				}
				setRadius()

			}
		})

	})

	$('#form-tool').form({
			inputs: inputs,
			minimize:true
	})

</script>