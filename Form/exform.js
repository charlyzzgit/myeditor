(function($){
	'use strict'
	$.fn.extend({
		form: function(uiOptions){
			var form = $(this),
				options = {
					textRequired: 'Requerido'
				},
				opc = $.extend(options, uiOptions)
				

			return $(this).each(function(){

			})

		},

		textRequired: 'Requerido',

		getInput: function(name){
			var input = null
			form.find(':input').each(function(){
				var inp = $(this)
				if(inp.prop('name') == name){
					input = inp
					return
				}
			})
			return input
		},

		setInput: function(options){
			var name = (options.name != null) ? options.name : '',
				value = (options.value != null) ? options.value : '',
				required = (options.required != null) ? true : false,
				disabled = (options.disabled != null) ? true : false,
				callBack = options.callBack,
				input = null,
				type = null
			
			if(name != ''){
				input = form.getInput(name)
				type = input.prop('type')
				input.data('exe', callBack)
					 .prop('required', required)
					 .prop('disabled', disabled)
				if(required){
					var req = $('<b class="text-danger ml-1"></b>')
					req.html(form.textRequired).css({fontSize:'10px'})
					input.closest('.form-group').find('label').first().after(req)
				}
				
				switch(type){
					case 'select': case 'select-one':

						var options = (options.options != null) ? options.options : []
						$.each(options, function (index, opt) { 
							var option = $('<option></option>')
							option
								.val(opt.value)
								.html(opt.name)
								.prop('selected', (opt.value == value) ? true : false)
							input.append(option)
						})
					break
					default:
						input
							.val(value)
							.keyup(function(evt){
								evt.preventDefault()
								var value = $(this).val(),
									callBack = $(this).data('exe')
								try{
									window[callBack(value)].call
								}catch(e){}
							})
					break
				}
					
					
					
			}
		},



		validate: function(){
			form.find(':input').each(function(){
				var input = $(this),
					value,
					required = input.prop('required')
				if(required){
					input.after('<b class="error text-danger">Campo Incompleto</b>')
					input.addClass('alert-danger')
					input.focus(function(){
						$(this).removeClass('alert-danger')
						$(this).closest('.form-group').find('.error').remove()
					})
				}
			})
		},


		
	})
})(jQuery)
