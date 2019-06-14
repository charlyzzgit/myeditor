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
	<div class="sector flex-row-center-start flex-wrap border p-2">
		<div class="side col-12 flex-row-center-center mb-2">Uniforme</div>
		<div id="border-color" class="col-12"></div>
		<div id="border-style" class="col-6"></div>
		<div id="border-width" class="col-6 border-dark"></div>
	</div>
	<div class="sector flex-row-center-start flex-wrap border p-2">
		<div class="side col-12 flex-row-center-center mb-2">Superior</div>
		<div id="border-color-top" class="col-12"></div>
		<div id="border-style-top" class="col-6"></div>
		<div id="border-width-top" class="col-6 border-dark"></div>
	</div>
	<div class="sector flex-row-center-start flex-wrap border p-2">
		<div class="side col-12 flex-row-center-center mb-2">Inferior</div>
		<div id="border-color-bottom" class="col-12"></div>
		<div id="border-style-bottom" class="col-6"></div>
		<div id="border-width-bottom" class="col-6 border-dark"></div>
	</div>
	<div class="sector flex-row-center-start flex-wrap border p-2">
		<div class="side col-12 flex-row-center-center mb-2">Izquierdo</div>
		<div id="border-color-left" class="col-12"></div>
		<div id="border-style-left" class="col-6"></div>
		<div id="border-width-left" class="col-6 border-dark"></div>
	</div>
	<div class="sector flex-row-center-start flex-wrap border p-2">
		<div class="side col-12 flex-row-center-center mb-2">Derecho</div>
		<div id="border-color-right" class="col-12"></div>
		<div id="border-style-right" class="col-6"></div>
		<div id="border-width-right" class="col-6 border-dark"></div>
	</div>
</div>




<script>
	'use strict'
	ver(['css', OBJ.css('border-top-width'), getBorder(OBJ, 'top', 'width')])
	var border = {
			top: {
				color: getBorder(OBJ, 'top', 'color'),
				width: getBorder(OBJ, 'top', 'width'),
				style: getBorder(OBJ, 'top', 'style')
			},
			bottom: {
				color: getBorder(OBJ, 'bottom', 'color'),
				width: getBorder(OBJ, 'bottom', 'width'),
				style: getBorder(OBJ, 'bottom', 'style')
			},
			left: {
				color: getBorder(OBJ, 'left', 'color'),
				width: getBorder(OBJ, 'left', 'width'),
				style: getBorder(OBJ, 'left', 'style')
			},
			right: {
				color: getBorder(OBJ, 'right', 'color'),
				width: getBorder(OBJ, 'right', 'width'),
				style: getBorder(OBJ, 'right', 'style')
			},
		},
		inputs = []


	function setBorder(){
		OBJ.css({
			borderTopColor: border.top.color,
			borderTopWidth: border.top.width + 'px',
			borderTopStyle: border.top.style,

			borderBottomColor: border.bottom.color,
			borderBottomWidth: border.bottom.width + 'px',
			borderBottomStyle: border.bottom.style,

			borderLeftColor: border.left.color,
			borderLeftWidth: border.left.width + 'px',
			borderLeftStyle: border.left.style,

			borderRightColor: border.right.color,
			borderRightWidth: border.right.width + 'px',
			borderRightStyle: border.right.style
		})
		ver(['border', border, OBJ.css('borderTopWidth')])
	}

	
	ver(['border:', border])
		$('.sector').each(function(index){
			var side = ''
			switch(index){
				case 1: side = '-top'; break;
				case 2: side = '-bottom'; break;
				case 3: side = '-left'; break;
				case 4: side = '-right'; break;
			}
			ver(['side antes:', side.split('-')[1]])
				inputs.push({
					box:'border-color' + side,
					type: 'color',
					label: 'Color:',
					format: 'rgba',
					name: 'b-color' + side,
					value: getBorder(OBJ, side.split('-')[1], 'color'),
					data:{side: side},
					callBack: function(value, data){
						var dt = getJson(data),
							side = exists(dt.side, '-') ? dt.side.split('-')[1] : ''
						
						switch(side){
							case 'top': border.top.color = value; break;
							case 'bottom': border.bottom.color = value; break;
							case 'left': border.left.color = value; break;
							case 'right': border.right.color = value; break;
							default: 
								border.top.color = value
								border.bottom.color = value
								border.left.color = value
								border.right.color = value
							break
						}
						setBorder()
					}
				})

				inputs.push({
						box:'border-width' + side,
						type: 'spinner',
						min:0,
						max:100,
						label: 'Grosor:',
						name: 'b-width' + side,
						value: getBorder(OBJ, side.split('-')[1], 'width'),
						data:{side: side},
						callBack: function(value, data){

							var dt = getJson(data),
							side = exists(dt.side, '-') ? dt.side.split('-')[1] : ''
							
							switch(side){
								case 'top': border.top.width = value; break;
								case 'bottom': border.bottom.width = value; break;
								case 'left': border.left.width = value; break;
								case 'right': border.right.width = value; break;
								default: 
									border.top.width = value
									border.bottom.width = value
									border.left.width = value
									border.right.width = value
								break
							}
							setBorder()

						}
					})

				inputs.push({
						box:'border-style' + side,
						type: 'radio',
						options:[
							{name: 'Ninguno', value: 'none'},
							{name: 'Sólido', value: 'solid'},
							{name: 'Doble', value: 'double'},
							{name: 'Punteado', value: 'dotted'},
							{name: 'Precipitado', value: 'dashed'},
							{name: 'Interior', value: 'inset'},
							{name: 'Exterior', value: 'outset'}
						],
						label: 'Estilo:',
						name: 'b-style' + side,
						value: getBorder(OBJ, side.split('-')[1], 'style'),
						data:{side: side},
						callBack: function(value, data){
							var dt = getJson(data),
							side = exists(dt.side, '-') ? dt.side.split('-')[1] : ''
							
							switch(side){
								case 'top': border.top.style = value; break;
								case 'bottom': border.bottom.style = value; break;
								case 'left': border.left.style = value; break;
								case 'right': border.right.style = value; break;
								default: 
									border.top.style = value
									border.bottom.style = value
									border.left.style = value
									border.right.style = value
								break
							}
							setBorder()
						}
					})
			})
		
	$('#form-tool').form({
			inputs: inputs,
			minimize:true
	})
</script>