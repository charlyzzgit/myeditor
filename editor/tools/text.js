(function($){
	'use strict'
	$.fn.extend({
		toolText: function(uiOptions){
			var form = $(this),
				options = {
					
					
				},
				opc = $.extend(options, uiOptions),
				rows = [
					'font-family',
					'font-size',
					'font-weight',
					'font-transform',
					'font-decoration',
					'font-color',
					'font-shadow-color',
					'font-shadow-x',
					'font-shadow-y',
					'font-shadow-blur',
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
					{name: 'Ninguno', value: 'none'},
					{name: 'Supra Rayado', value: 'overline'},
					{name: 'Tachado', value: 'line-through'},
					{name: 'Sub Rayado', value: 'underline'},
					{name: 'Supra-Sub Rayado', value: 'underline overline'}
				],
				transforms = [
					{name: 'Minúscula', value: 'lowercase'},
					{name: 'Mayúscula', value: 'uppercase'},
					{name: 'Capitalizada', value: 'capitalize'}
				],
				inputs = [
					{
						box:'font-family',
						type: 'select',
						options: getFonts(),
						label: 'Fuente:',
						name:'family',
						callBack: function(value, data){

						}
					},
					{
						box:'font-size',
						type: 'spinner',
						min:1,
						max:100,
						label: 'Tamaño:',
						value: 16,
						name: 'size',
						callBack: function(value, data){

						}
					},

					{
						box:'font-weight',
						type: 'select',
						options: weights,
						label: 'Enfasis:',
						name: 'weight',
						callBack: function(value, data){

						}
					},

					{
						box:'font-transform',
						type: 'select',
						options:transforms,
						label: 'Transformar:',
						name: 'transform',
						callBack: function(value, data){

						}
					},

					{
						box:'font-decoration',
						type: 'select',
						options:decorations,
						label: 'Enfasis:',
						name: 'decoration',
						callBack: function(value, data){

						}
					},

					{
						box:'font-color',
						type: 'color',
						label: 'Color:',
						value: '#000000',
						format: 'rgba',
						name: 'color',
						callBack: function(value, data){

						}
					},

					{
						box:'font-shadow-color',
						type: 'color',
						label: 'Color Sombra:',
						value: '#000000',
						format: 'rgba',
						name: 'shadow-color',
						callBack: function(value, data){

						}
					},

					{
						box:'font-shadow-x',
						type: 'spinner',
						label: 'Sombra X:',
						value: 0,
						name: 'shadow-x',
						
						callBack: function(value, data){

						}
					},
					{
						box:'font-shadow-x',
						type: 'spinner',
						label: 'Sombra Y:',
						value: 0,
						name: 'shadow-y',
						
						callBack: function(value, data){

						}
					},
				]
				
				

			return $(this).each(function(){
				var child = 1
				$.each(rows, function(index, row){
					var div = $('<div class="col-12 flex-row-between-center"></div>')
					if(index != 0 && index % 5 == 0){
						child++
					}
					
					div.prop('id', row)
					$(form).find('.sector:nth-child(' + child + ')').append(div)
				})
				$(form).form({
			        inputs: inputs,
			        minimize:true
			     })
  
			}) //fin return

		}//fin form

		

	})//fin extend

})(jQuery)


