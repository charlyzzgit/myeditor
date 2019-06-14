<style>
	.sector{
		height: 300px
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div class="sector col-12 flex-row-center-center border p-2">
		<div id="float" class="col-4"></div>
	</div>
	
</div>


<script>
	'use strict'
	var float = getStyle(OBJ, 'float')
	if(float == null){
		float = ''
	}
//ver([getStyle(OBJ, 'float')])
	$('#form-tool').form({
			     inputs: [
			     	{
						box:'float',
						type: 'radio',
						options:[
							{name: 'la Izquierda', value: 'left'},
							{name: 'ningún lado', value: ''},
							{name: 'la Derecha', value: 'right'}
						],
						inline:true,
						label: 'Flotar a:',
						name: 'decoration',
						value: float,
						callBack: function(value, data){
							OBJ.removeClass('float-left float-right')
							if(value != ''){
								OBJ.addClass('float-' + value)
							}
							ver(['float', OBJ.prop('class')])
						}
					}
			     ],
			     minimize:true
			  })
</script>