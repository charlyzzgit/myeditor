<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	$elem = getPost($request, 'elem', '');
	

 ?>
 <style>
	.sector{
		width: 20%;
		height: 300px
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div class="sector flex-col-start-center border p-2"></div>
	<div class="sector flex-col-start-center border p-2"></div>
	<div class="sector flex-col-start-center border p-2"></div>
	<div class="sector flex-col-start-center border p-2"></div>
	<div class="sector flex-col-start-center border p-2"></div>
</div>




<script>
	'use strict'
	
	var elem = '<?php print($elem); ?>',
		fontFamily = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'fontFamily'),
		fontSize = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'fontSize'),
		fontWeight = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'fontWeight'),
		fontSpacing = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'letterSpacing'),
		fontHeight = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'lineHeight'),
		fontColor = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'textFillColor'),
		fontShadow = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'textShadow'),
		fontShadowColor = fontShadow.color,
		fontShadowX = fontShadow.x,
		fontShadowY = fontShadow.y,
		fontShadowBlur = fontShadow.blur,
		fontText = elem == '' ? OBJ.text() : OBJ.find(elem).text(),
		fontBorderColor = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'textStrokeColor'),
		fontBorderWidth = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'textStrokeWidth'),
		fontStyle = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'fontStyle'),
		fontTransform = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'textTransform'),
		fontDecoration = getStyle(elem == '' ? OBJ : OBJ.find(elem), 'textDecoration'),
	    rows = [
					'font-family',
					'font-size',
					'font-spacing',
					'font-weight',
					'font-color',
					'font-shadow-color',
					'font-shadow-x',
					'font-shadow-y',
					'font-shadow-blur',
					'font-text',
					'font-border-color',
					'font-border-width',
					'font-style',
					'font-transform',
					'font-decoration'
				],
				weights = [
					{ name: 'Normal', value: 'normal'},
					{ name: '100', value: 100},
					{ name: '200', value: 200}, 
					{ name: '300', value: 300},
					{ name: '400', value: 400},
					{ name: '500', value: 500},
					{ name: '600', value: 600},
					{ name: '700', value: 700},
					{ name: '800', value: 800},
					{ name: '900', value: 900},
					{ name: 'Bold', value: 'bold'}
				],
				decorations = [
					
					{name: 'Supra Rayado', value: 'overline'},
					{name: 'Tachado', value: 'line-through'},
					{name: 'Sub Rayado', value: 'underline'},
					{name: 'Supra-Sub Rayado', value: 'underline overline'},
					{name: 'Ninguno', value: 'none'}
				],
				transforms = [
					{name: 'Minúscula', value: 'lowercase'},
					{name: 'Mayúscula', value: 'uppercase'},
					{name: 'Capitalizada', value: 'capitalize'}
				],
				styles = [
					{name: 'Normal', value: 'normal'},
					{name: 'Itálica', value: 'italic'},
					{name: 'Cursiva', value: 'oblique'}
				],
				inputs = [
					{
						box:'font-family',
						type: 'select',
						options: getFonts(),
						label: 'Fuente:',
						name:'family',
						value: fontFamily,
						callBack: function(value, data){
							fontFamily = value
							setFontStyle()
							
						}
					},
					{
						box:'font-size',
						type: 'spinner',
						min:1,
						max:100,
						label: 'Tamaño:',
						value: fontSize,
						name: 'size',
						callBack: function(value, data){
							fontSize = value
							setFontStyle()

						}
					},

					{
						box:'font-size',
						type: 'spinner',
						min:0,
						max:100,
						label: 'Interlineado:',
						value: fontHeight,
						name: 'lineheigt',
						step: 0.1,
						callBack: function(value, data){
							fontHeight = value
							setFontStyle()
						}
					},

					{
						box:'font-spacing',
						type: 'spinner',
						min:0,
						max:50,
						label: 'Espacio entre Letras:',
						value: fontSpacing,
						name: 'letter-spacing',
						step: 1,
						callBack: function(value, data){
							fontSpacing = value
							setFontStyle()
						}
					},


					{
						box:'font-weight',
						type: 'select',
						options: weights,
						label: 'Enfasis:',
						name: 'weight',
						value: fontWeight,
						callBack: function(value, data){
							fontWeight = value
							setFontStyle()
						}
					},

					{
						box:'font-transform',
						type: 'radio',
						options:transforms,
						label: 'Transformar:',
						name: 'transform',
						value: fontTransform,
						callBack: function(value, data){
							fontTransform = value
							setFontStyle()
						}
					},

					{
						box:'font-decoration',
						type: 'radio',
						options:decorations,
						label: 'Decorado:',
						name: 'decoration',
						value: fontDecoration,
						callBack: function(value, data){
							fontDecoration = value
							setFontStyle()
						}
					},

					{
						box:'font-color',
						type: 'color',
						label: 'Color:',
						format: 'rgba',
						name: 'color',
						value: fontColor,
						callBack: function(value, data){
							console.log('color', value)
							fontColor = value
							setFontStyle()
						}
					},

					{
						box:'font-shadow-color',
						type: 'color',
						label: 'Color Sombra:',
						value: '#000000',
						format: 'rgba',
						name: 'shadow-color',
						value: fontShadowColor,
						callBack: function(value, data){
							fontShadowColor = value
							setFontStyle()
						}
					},

					{
						box:'font-shadow-x',
						type: 'spinner',
						label: 'Sombra X:',
						value: fontShadowX,
						name: 'shadow-x',
						
						callBack: function(value, data){
							fontShadowX = value
							setFontStyle()
						}
					},
					{
						box:'font-shadow-x',
						type: 'spinner',
						label: 'Sombra Y:',
						value: fontShadowY,
						name: 'shadow-y',
						
						callBack: function(value, data){
							fontShadowY = value
							setFontStyle()
						}
					},
					{
						box:'font-shadow-blur',
						type: 'spinner',
						label: 'Difuminar:',
						value: fontShadowBlur,
						name: 'shadow-blur',
						min:0,
						callBack: function(value, data){
							console.log('blur', value)
							fontShadowBlur = value
							setFontStyle()
						}
					},

					{
						box:'font-text',
						type: 'textarea',
						label: 'Texto:',
						value: elem == '' ? fontText : 'Los textos de los (Items de Lista) se editan desde la solapa Lista',
						name: 'text',
						rows: 5,
						disabled: (elem != '' || OBJ.hasClass('icon-editor')) ? true : false,
						callBack: function(value, data){
							fontText = value
							setFontStyle()
						}
					},

					{
						box:'font-border-color',
						type: 'color',
						label: 'Color Borde:',
						value: fontBorderColor,
						format: 'rgba',
						name: 'border-color',
						callBack: function(value, data){
							fontBorderColor = value
							setFontStyle()
						}
					},

					{
						box:'font-border-width',
						type: 'spinner',
						label: 'Grosor Borde:',
						value: fontBorderWidth,
						name: 'border-width',
						min:0,
						max:10,
						callBack: function(value, data){
							fontBorderWidth = value
							setFontStyle()
						}
					},

					{
						box:'font-style',
						type: 'radio',
						options:styles,
						label: 'Estilo:',
						name: 'style',
						value: fontStyle,
						callBack: function(value, data){
							fontStyle = value
							setFontStyle()
						}
					},

				]

	function setFontStyle(){
		if(elem == ''){
			OBJ.css('fontFamily', fontFamily)
			OBJ.css('font-size', fontSize + 'px')
			OBJ.css('line-height', fontHeight + 'px')
			OBJ.css('letterSpacing', fontSpacing + 'px')
			OBJ.css('font-weight', fontWeight)
			OBJ.css('text-transform', fontTransform)
			OBJ.css('text-decoration', fontDecoration)
			OBJ.css('text-fill-color', fontColor)
			OBJ.text(fontText)
			OBJ.css('text-stroke-color', fontBorderColor)
			OBJ.css('text-stroke-width', fontBorderWidth + 'px')
			OBJ.css('font-style', fontStyle)
			setTextShadow()
		}else{
			OBJ.find(elem).css('fontFamily', fontFamily)
			OBJ.find(elem).css('font-size', fontSize + 'px')
			OBJ.find(elem).css('line-height', fontHeight + 'px')
			OBJ.find(elem).css('letterSpacing', fontSpacing + 'px')
			OBJ.find(elem).css('font-weight', fontWeight)
			OBJ.find(elem).css('text-transform', fontTransform)
			OBJ.find(elem).css('text-decoration', fontDecoration)
			OBJ.find(elem).css('text-fill-color', fontColor)
			
			OBJ.find(elem).css('text-stroke-color', fontBorderColor)
			OBJ.find(elem).css('text-stroke-width', fontBorderWidth + 'px')
			OBJ.find(elem).css('font-style', fontStyle)
			setTextShadow()
		}
	}

	// function updateCss(){
	// 	fontFamily = getStyle(OBJ, 'fontFamily')
	// 	fontSize = getStyle(OBJ, 'fontSize')
	// 	fontWeight = getStyle(OBJ, 'fontWeight')
	// 	fontSpacing = getStyle(OBJ, 'letterSpacing')
	// 	fontHeight = getStyle(OBJ, 'lineHeight')
	// 	fontColor = getStyle(OBJ, 'color')
	// 	fontShadow = getStyle(OBJ, 'text-shadow')
	// 	fontShadowColor = null
	// 	fontShadowX = null
	// 	fontShadowY = null
	// 	fontShadowBlur = null
	// 	fontText = OBJ.text()
	// 	fontBorderColor = getStyle(OBJ, 'textStrokeColor')
	// 	fontBorderWidth = getStyle(OBJ, 'textStrokeWidth')
	// 	fontStyle = getStyle(OBJ, 'fontStyle')
	// 	fontTransform = getStyle(OBJ, 'textTransform')
	// 	fontDecoration = getStyle(OBJ, 'textDecoration')
	// }

	function setTextShadow(){
		if(elem == ''){
			OBJ.css('text-shadow', fontShadowColor + ' ' + fontShadowX + 'px ' + fontShadowY + 'px ' + fontShadowBlur + 'px ')
		}else{
			OBJ.find(elem).css('text-shadow', fontShadowColor + ' ' + fontShadowX + 'px ' + fontShadowY + 'px ' + fontShadowBlur + 'px ')
		}
		//console.log('sombra', OBJ.css('text-shadow'))
	}

	//OBJ.css('text-shadow', fontShadowX + 'px ' + fontShadowY + 'px ' + fontShadowBlur + ' ' + fontShadowColor)
	
	$.each(rows, function(index, row){
		var div = $('<div class="col-12 flex-row-between-center"></div>'),
			child = 1
		if(index < 4){
			child = 1
		}else if(index >= 4 && index < 9){
			child = 2
		}else if(index == 9){
			child = 3
		}else if(index > 9 && index < 13){
			child = 4
		}else if(index >= 13 && index < rows.length){
			child = 5
		}
				
		div.prop('id', row)
		$('#form-tool').find('.sector:nth-child(' + child + ')').append(div)
	})
	$('#form-tool').form({
			     inputs: inputs,
			     minimize:true
			  })
	
		
	if(elem == 'i'){
		var btn = $('<button class="btn btn-primary m-auto">Cambiar Icono</button>')
		btn.click(function(){
			modalIcons.openModal('tools/modalIcons.php')
		})
		$('#font-text').empty().addClass('pt-5').append(btn)
	}
	ver(['elem:', elem])
</script>