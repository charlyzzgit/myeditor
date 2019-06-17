<style>
	.sector{
		
		height: 300px
	}

	.side{
		background: #f2f2f2
	}
</style>
<div id="form-tool" class="col-12 flex-row-center-start">
	<div class="sector col-6 flex-row-center-start border p-2">
		<div id="width" class="col-12"></div>
	</div>
	<div class="sector col-6 flex-row-center-start border p-2">
		<div id="height" class="col-12"></div>
	</div>
</div>

<script>
	'use strict' 

	var width = parseInt(OBJ.css('width').split('%')[0]), 
		height = parseInt(OBJ.css('height').split('px')[0])
	$('#form-tool').form({
			     inputs: [
			     	{
						box:'width',
						type: 'spinner',
						min:0,
						max:100,
						label: 'Ancho:',
						value: width,
						name: 'w',
						callBack: function(value, data){
							OBJ.css('width', value + '%')
						}
					}, 

					{
						box:'height',
						type: 'spinner',
						min:1,
						max:1000,
						label: 'Alto:',
						value: height,
						name: 'h',
						callBack: function(value, data){
							OBJ.css('height', value + 'px')
						}
					}
			     ],
			     minimize:true
			  })
	

</script>