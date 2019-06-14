<style>
	.sector{
		height: 300px
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div class="sector col-4 flex-col-start-center border p-5">
		<div id="shadow-x" class="col-12 mt-3"></div>
		<div id="shadow-y" class="col-12 mt-3"></div>
	</div>
	<div class="sector col-4 flex-col-start-center border p-5">
		<div id="shadow-color" class="col-12 mt-3"></div>
		<div id="shadow-inset" class="col-12 mt-3"></div>
	</div>
	<div class="sector col-4 flex-col-start-center border p-5">
		<div id="shadow-blur" class="col-12 mt-3"></div>
		<div id="shadow-spread" class="col-12 mt-3"></div>
	</div>
</div>


<script>
	'use strict'
	var shadow = getBoxShadow(OBJ),
	inputs = [
		{
			box:'shadow-x',
			type: 'spinner',
			min:-100,
			max:100,
			label: 'Desplazamiento Horizontal:',
			value: shadow.x,
			name: 'shd-x',
			step: 1,
			callBack: function(value, data){
				shadow.x = value
				setBoxShadow()
			}
		},
		{
			box:'shadow-y',
			type: 'spinner',
			min:-100,
			max:100,
			label: 'Desplazamiento Vertical:',
			value: shadow.y,
			name: 'shd-y',
			step: 1,
			callBack: function(value, data){
				shadow.y = value
				setBoxShadow()
			}
		},
		
		{
			box:'shadow-color',
			type: 'color',
			label: 'Color:',
			value: shadow.color,
			format: 'rgba',
			name: 'shd-color',
			callBack: function(value, data){
				shadow.color = value
				setBoxShadow()
			}
		},

		{
           box: 'shadow-inset',
           type: 'switch',
           label: 'Dirección:',
           name:'shd-inset',
           onColor: 'info',
           offColor: 'primary',
           onText: 'INTERNA',
           offText: 'EXTERNA',
           checked:shadow.inset,
           callBack: function(value, data){
           		shadow.inset = value
				setBoxShadow()
         	}
         },

		{
			box:'shadow-blur',
			type: 'spinner',
			min:0,
			max:100,
			label: 'Difuminado:',
			value: shadow.blur,
			name: 'shd-blur',
			step: 1,
			callBack: function(value, data){
				shadow.blur = value
				setBoxShadow()
			}
		},
		{
			box:'shadow-spread',
			type: 'spinner',
			min:0,
			max:100,
			label: 'Propagación:',
			value: shadow.spread,
			name: 'shd-spread',
			step: 1,
			callBack: function(value, data){
				shadow.spread = value
				setBoxShadow()
			}
		}
	]

function setBoxShadow(){
	var inset = (shadow.inset) ? 'inset ' : ''
	OBJ.css('boxShadow', inset + shadow.x + 'px ' + shadow.y + 'px ' + shadow.blur + 'px ' + shadow.spread + 'px ' + shadow.color)
}


$('#form-tool').form({
		inputs: inputs,
		minimize:true
})
</script>