(function($){
	'use strict'
	$.fn.extend({
		form: function(uiOptions){
			var form = $(this),
				options = {
					inputs:[],
					requiredText: 'Requerido',
					requiredColor: 'text-danger',
					requiredSize: 12,
					requiredInput: 'alert-danger',
					minimize: false
					
				},
				opc = $.extend(options, uiOptions),
				timer
				

			return $(this).each(function(){

				function upLoadImage(file){
        
			        var input = $(file)[0],                
			            inputFiles = input.files,
			            inputFile = inputFiles[0],
			            reader = new FileReader(),
			            image = $(file).parent().find('img')
			        if(inputFiles == undefined || inputFiles.length == 0){ 
			            return
			        }
			        
			        reader.onload = function(event) {
			             image.prop('src', event.target.result)
			             
			        }
			        reader.onerror = function(event) {
			            alert("Error al Cargar imágen: " + event.target.error.code);
			        }
			        reader.readAsDataURL(inputFile);
			    }

			    function upLoadFile(file){
        
			        var input = $(file)[0],                
			            inputFiles = input.files,
			            inputFile = inputFiles[0],
			            reader = new FileReader()
			        $(file).parent().find('.custom-file-label').html($(file).val().split('fakepath\\')[1])
			        if(inputFiles == undefined || inputFiles.length == 0){ 
			            return
			        }
			        
			        reader.onload = function(event) {
			             //url.html(event.target.result)
			             
			        }
			        reader.onerror = function(event) {
			            alert("Error al Cargar imágen: " + event.target.error.code);
			        }
			        reader.readAsDataURL(inputFile);
			    }

			    function maxMin(btn){
			    	
					var input = $(btn).closest('.input-group').find('input'),
						n = parseInt(input.val()),
						h = parseInt(btn.hasClass('min') ? input.prop('min') : input.prop('max')),
						callBack = input.data('exe'),
						step = '' + input.data('step')
						var increment = (step.indexOf('.') != -1) ? parseFloat(step) : parseInt(step)
					timer = setInterval(function(){
							if(btn.hasClass('min')){
								n -= increment
															
								if(n < h){
									n = h
								}
							}else{
								n += increment
															
								if(n > h){
									n = h
								}
							}
							
							//console.log('num', n)
							if(step.indexOf('.') != -1){
								input.val(n.toFixed(2)) 
							}						
							input.val(n)
							try{
								window[callBack(n, input.data('data'))].call
							}catch(e){}

															
						}, 50)
			    }

				function getInput(input){
					var box = $('<div class="form-group">\
									<label class="form-lbl"></label>\
								'),
						type = input.type
					switch(type){
						case 'textarea':
							box.find('.form-lbl').after('<textarea class="form-control"></textarea')
							box.find('textarea')
											.prop('rows', (input.rows != null) ? input.rows : 2)
											.val(input.value)
											.keyup(function(){
												var inp = $(this),
													callBack = inp.data('exe'),
													data = inp.data('data'),
													val = inp.val()
												try{
													window[callBack(val, data)].call
												}catch(e){}
											})
						break
						case 'select':
							var options = (input.options != null) ? input.options : []
							box.find('.form-lbl').after((input.icon != null) ? getInputIcon('<select class="custom-select"></select>', input.icon) : '<select class="custom-select"></select>')
							
							$.each(options, function(index, opc){
								var option = $('<option></option>')
								option
									  .val(opc.value)
									  .html(opc.name)
									  .prop('selected', (opc.value == input.value) ? true : false)
								if(opc.class != null){
									option.addClass(opc.class)
								}
								box.find('select').append(option)
							})
							box.find('select')
											.change(function(){
												var inp = $(this),
													callBack = inp.data('exe'),
													data = inp.data('data'),
													val = inp.val()
												try{
													window[callBack(val, data)].call
												}catch(e){}
											})
						break
						case 'radio':
							var options = (input.options != null) ? input.options : []
							$.each(options, function(index, opc){
								var option = $('<div class="custom-control custom-radio">\
                        						<input type="radio"  class="custom-control-input">\
                        						<label class="custom-control-label"></label>\
                      						</div>')
								option.find('input')
													.prop('id', input.name + '-' + index)
													.val(opc.value)
													.prop('checked', (opc.value == input.value) ? true : false)
													.click(function(){
														var inp = $(this),
															callBack = inp.data('exe'),
															data = inp.data('data'),
															val = inp.val()
														try{
															window[callBack(val, data)].call
														}catch(e){}
													})
								option.find('label')
													.prop('for', input.name + '-' + index)
													.html(opc.name)

								if(opc.class != null){
									option.addClass(opc.class)
								}		

								box.append(option)
								if(input.inline != null){
									box.addClass('flex-row-start-center')
									box.find('.custom-radio').addClass('ml-3')
									box.find('.form-lbl').addClass('mr-3')
								}


								
							})
							
						break
						case 'checkbox':
							if(input.group == null){
								box.find('.form-lbl').remove()

								box.append('<div class="custom-control custom-checkbox">\
					                      <input class="custom-control-input">\
					                      <label class="custom-control-label"></label>\
					                    </div>')
								box.find('input')
												.prop('type', 'checkbox')
												.prop('id', 'form-' + input.name)
												.prop('checked', (input.checked != null) ? input.checked : false)
												.click(function(){
													console.log('click checkbox')
													var callBack = $(this).data('exe'),
    												data = $(this).data('data'),
    												value = $(this).prop('checked')
	    											try{
														window[callBack(value, data)].call
													}catch(e){
														console.log('Exception checkbox:', e)
													}
												})
								box.find('.custom-checkbox label')
																  .prop('for', 'form-' + input.name)
																  .html(input.label)
							}else{
								$.each(input.group, function(index, chk){
									var row = $('<div class="custom-control custom-checkbox">\
							                      <input class="custom-control-input">\
							                      <label class="custom-control-label"></label>\
							                    </div>')
									row.find('input')
												.prop('type', 'checkbox')
												.prop('id', 'form-' + input.name + '-' + index)
												.prop('checked', (chk.checked != null) ? chk.checked : false)
												.click(function(){
													console.log('click checkbox')
													var callBack = $(this).data('exe'),
    												data = $(this).data('data'),
    												value = $(this).prop('checked')
	    											try{
														window[callBack(value, data)].call
													}catch(e){
														console.log('Exception checkbox:', e)
													}
												})
									row.find('.custom-control-label')
																  .prop('for', 'form-' + input.name + '-' + index)
																  .html(chk.name)
																  console.log('chk', chk.name)
									box.append(row)
								})
									
							}
							
						break
						case 'switch':
							var onColor = (input.onColor != null) ? input.onColor : 'success',
								offColor = (input.offColor != null) ? input.offColor : 'danger',
								onText = (input.onText != null) ? input.onText : 'SI',
								offText = (input.offText != null) ? input.offText : 'NO'
							box.find('.form-lbl').prop('for', 'switch-' + input.name).after('<input type="checkbox">')
							box.find('input')
											.prop('id', 'switch-' + input.name)
											.data('on-color', onColor)
											.data('off-color', offColor)
											.data('on-text', onText)
											.data('off-text', offText)
											.on('switchChange.bootstrapSwitch', function(event, state) {
    											var callBack = $(this).data('exe'),
    												data = $(this).data('data')
    											try{
													window[callBack(state, data)].call
												}catch(e){}
  											}).bootstrapSwitch('state', (input.checked != null) ? input.checked : false)
  							box.addClass('flex-col-start-start')
						break

						case 'image':
							var noImage = 'Form/noimage.png',
								src = (input.src != null) ? (input.src != '' ? input.src : noImage) : noImage 
							box.find('.form-lbl').after('<div class="box-file col-12 p-0">\
														<img class="img-thumbnail form-hand">\
														<input type="file" class="input-file bg-dark">\
														</div>')
							box.find('img').prop('src', src).prop('width', (input.size != null) ? input.size : 100)
							box.find('input').change(function(){
								var file = $(this)[0].files[0],
									callBack = $(this).data('exe'),
									data = $(this).data('data')
								try{
									window[callBack(file, data)].call
								}catch(e){
									console.log('Exception: Imagen ', e)
								}

								upLoadImage($(this))
							})

						break
						case 'file':
							box.find('.form-lbl').after('<div class="custom-file">\
								                          <input type="file" class="custom-file-input" lang="es">\
								                          <label class="custom-file-label"></label>\
								                        </div>')
							box.find('.custom-file-label')
														.prop('for', 'file-' + input.name)
														.html((input.placeholder != null) ? input.placeholder : 'Seleccionar Archivo')
							box.find('input')
											.prop('id', 'file-' + input.name)
											.change(function(){
												var file = $(this)[0].files[0],
													callBack = $(this).data('exe'),
													data = $(this).data('data')
												try{
													window[callBack(file, data)].call
												}catch(e){
													console.log('Exception: File ', e)
												}
												upLoadFile($(this))
											})

						break
						case 'range':
							box.find('.form-lbl').prop('for', 'range-' + input.name)
							box.append('<div class="col-12 flex-row-start-center p-0">\
											<label class="badge badge-primary mr-1 p-2">' + input.value + '</label>\
											<input type="range" class="custom-range">\
										</div>')
							box.find('input')
											.prop('id','range-' + input.name)
											.prop('min', (input.min != null) ? input.min : -1000000)
											.prop('max', (input.max != null) ? input.max : 1000000)
											.prop('step',(input.step != null) ? input.step : 1)
											.val(input.value)
											.change(function(){
												var inp = $(this),
													callBack = inp.data('exe'),
													data = inp.data('data'),
													val = inp.val()
												inp.parent().find('label').html(val)
												try{
													window[callBack(val, data)].call
												}catch(e){}
											})
							
						break
						case 'spinner':

							box.append('<div class="input-group mb-3">\
					                      <div class="input-group-prepend">\
					                        <button class="min btn btn-secondary"><i class="fa fa-minus"></i></button>\
					                      </div>\
					                      <input type="number" class="form-control small-input spinner-input text-center ml-1 mr-1">\
					                      <div class="input-group-append">\
					                        <button class="max btn btn-secondary"><i class="fa fa-plus"></i></button>\
					                      </div>\
					                    </div>')
							box.find('input')
											.prop('min', (input.min != null) ? input.min : -1000000)
											.prop('max', (input.max != null) ? input.max : 1000000)
											.data('step', (input.step != null) ? input.step : 1)
											.val(input.value)
											.keyup(function(){
												var inp = $(this),
													callBack = inp.data('exe'),
													data = inp.data('data'),
													val = inp.val()
													
												try{
													window[callBack(val, data)].call
												}catch(e){
													
													//console.log('Exception spinner:', callBack, e)
												}
											})
											
							box.find('button').prop('type', 'button').mousedown(function(evt){
								evt.preventDefault()
								maxMin($(this))
							}).mouseup(function(evt){
								evt.preventDefault()
								clearInterval(timer)
							}).mouseleave(function(evt){
								evt.preventDefault()
								clearInterval(timer)
							})


						break
						case 'date': case 'time': case 'datetime':
							var format = 'DD/MM/YYYY HH:mm',
								dateIcon = 'fa-calendar-alt'
							if(type == 'date'){
								format = format.split(' ')[0]
								dateIcon = 'fa-calendar'
							}else if(type == 'time'){
								format = format.split(' ')[1]
								dateIcon = 'fa-clock'
							}
							box.append('<div class="input-group date" data-target-input="nearest">\
				                            <input type="text" class="form-control datetimepicker-input" data-target="#date-' + input.name + '">\
				                            <div class="date-event input-group-append" data-toggle="datetimepicker" data-target="#date-' + input.name + '">\
				                                <div class="input-group-text form-hand"><i class="fa ' + dateIcon + ' text-primary"></i></div>\
				                            </div>\
				                        </div>')
							box.find('.date').prop('id', 'date-' + input.name)
							box.find('.date-event')
							box.find('input').val((input.value != null) ? input.value : '')
							box.find('#date-' + input.name).datetimepicker({
			                      format: format,
			                      language : 'es',
			                      autoclose: true,
			                      locale:'es',
			                      icons:{
			                         date: 'fa fa-calendar-alt text-primary',
			                         time: 'fa fa-clock text-primary',
			                         previous: 'fa fa-chevron-left text-primary',
			                         next: 'fa fa-chevron-right text-primary'
			                      }
			                     
			                  })

						break
						case 'color':
							box.append('<div id="color-' + input.name + '" class="input-group colorpicker-component colorpicker-element">\
				                          <input type="text" class="form-control">\
				                          <span class="input-group-addon input-group-text"><i></i></span>\
				                      </div>')
							box.find('input')
											.val((input.value != null) ? input.value : '#000000')
											// .change(function(){
											// 	var inp = $(this),
											// 		callBack = inp.data('exe'),
											// 		data = inp.data('data'),
											// 		val = inp.val()
											// 	try{
											// 		window[callBack(val, data)].call
											// 	}catch(e){}
											// })
							box.find('#' + 'color-' + input.name).colorpicker({
					            //color: (input.value != null) ? input.value : '#000000',
					            format: (input.format != null) ? input.format : 'hex'

					        }).on('changeColor', function(ev) {
					                
					                var inp = $(ev.target).closest('.form-group').find('input'),
										callBack = inp.data('exe'),
										data = inp.data('data'),
										val = inp.val()
									try{
										window[callBack(val, data)].call
									}catch(e){}
					           });




						break
						case 'submit':
							box = $('<button class="btn"></button>')
							box
								.addClass((input.btn != null) ? 'btn-' + input.btn : 'btn-dark')
								.html((input.label != null) ? input.label : '?')
								.click(function(evt){
									evt.preventDefault()
									send(input)
								})
						break
						default:

							box.find('.form-lbl').after((input.icon != null) ? getInputIcon('<input class="form-control">', input.icon) : '<input class="form-control">')
							box.find('input')
											.prop('type', type)
											.val(input.value)
											.keyup(function(){
												var inp = $(this),
													callBack = inp.data('exe'),
													data = inp.data('data'),
													val = inp.val()
												try{
													window[callBack(val, data)].call
												}catch(e){}
											})


						break
						
					}
					// if(input.width != null){
					// 	switch(type){
					// 		case 'text': case 'number': case 'select':
					// 			box.find('input, select').css('width', input.width + 'px !important')
					// 		break
					// 	}
					// }
					
					if(type == 'submit'){
						box.html(input.label)
					}

					box.find('.form-lbl').html(input.label)
					box.find(':input')
									.prop('disabled', (input.disabled != null) ? input.disabled : false)
									.data('exe', input.callBack)
									.data('data', JSON.stringify(input.data))
					
					if(type != 'submit' && type != 'button'){
						box.find('input, select, textarea')
						.prop('name', input.name)
						.prop('required', (input.required != null) ? true : false)
					}				

					if(input.required != null){
						var req = $('<b class="ml-1"></b>')
						req.html(opc.requiredText)
						req.addClass(opc.requiredColor)
						req.css('font-size', opc.requiredSize + 'px')
						box.find('.form-lbl').after(req)
					}

					if(input.label == null){
						box.find('.form-lbl').remove()
					}

					
					return box
				}

				function getInputIcon(input, icon){
					var box = $('<div class="input-group mb-3">\
		                        <div class="input-group-prepend">\
		                          <span class="input-group-text"><i></i></span>\
		                        </div>\
		                      </div>')
					box.find('i').addClass(icon)
					box.append(input)
					return box
				}

				function getValue(input){
					switch(input.prop('type')){
						case 'file': return input[0].files[0]
						case 'checkbox': case 'switch': return input.prop('checked') ? 1 : 0
						default: return input.val()

					}
				}

				function validate(){
					var e = 0
					form.find('.form-error').remove()
					form.find(':input').each(function(){
						var input = $(this),
							required = input.prop('required'),
							value = getValue(input),
							type = input.prop('type'),
							name = input.prop('name'),
							error = ((input.data('error') != null) ? input.data('error') : '')
						
						if(required){
							if(value == error){
								e++;
								setError(input, 'Campo Inválido')
							}
							if(type == 'email'){
								if(!validateEmail(value)){
									e++;
									setError(input, 'Correo Inválido')
								}
							}
							if(type == 'radio'){
								var rd = $('input[name="' + name + '"]:checked').val()
									
								if(rd === undefined){
									e++
									input.closest('.form-group').find('.form-error').remove()
									setError(input, 'Seleccionar Item')
								}
							}
						}
					})

					if(e != 0){
						return false
					}
					return true
				}

				function setError(input, message){
					var type = input.prop('type')
					switch(type){
						case 'radio':
							var parent = input.closest('.form-group')
							parent.find('.form-error').remove()
							parent
								.removeClass('alert-danger')
								.addClass('alert-danger')
								.append('<b class="form-error text-danger mr-1">' + message + '</b>')
							input.focus(function(){
									$(this).closest('.form-group').removeClass('alert-danger')
									$(this).closest('.form-group').find('.form-error').remove()
								})
						break
						default:
							input
								.addClass('alert-danger')
								.after('<b class="form-error text-danger mr-1">' + message + '</b>')
								.focus(function(){
									$(this).removeClass('alert-danger')
									$(this).closest('.form-group').find('.form-error').remove()
								})
						break
					}
					
				}

				function validateEmail(email){
					var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				    if(!expr.test(email) ){
						return false;
					}
					return true;
					
				}

				function getPostVars(action){
					var data = new FormData(form)
					data.append('action', action)
					form.find(':input').each(function(){
						var input = $(this),
							type = input.prop('type'),
							name = input.prop('name'),
							value = null

						switch(type){
							case 'file':
								value = input[0].files[0]
							break
							case 'radio':
								value = $('input[name="' + name + '"]:checked').val()
							break
							case 'checkbox':
								value = (input.prop('checked')) ? 1 : 0
							break
							default:
								value = input.val()
							break
						}
						console.log('pair:',type, name, value)
						if(name != null){
							data.append(name, value)
						}
						
					})
					return data
				}

				function send(data){
					if(validate()){
						var callBack = data.callBack

						$.ajax({
				            url: data.url,
				            method: 'POST',
				            dataType: 'json',
				            cache: false,
				            contentType: false,
				            processData: false,
				            data: getPostVars(data.action),
				            success: function(data, textStatus, xhr){
				                
				                try{
				                	window[callBack(data)].call
				                }catch(e){}
				                      
				            },
				            error: function(xhr, textStatus, error){
				            	console.log('xhr:', xhr, 'textStatus:', textStatus, 'error:', error)
				                console.log('Error:', xhr.statusText)
				                swal('ERROR','Guardar','error')
				            }
				        }) 
				    }else{
				    	swal('REVISAR', 'Hay Campos Incorrectos','warning') 
				    }
					
				}



				$.each(opc.inputs, function (index, input) { 
					$('#' + input.box).append(getInput(input))
				})

				
				if(opc.minimize){
					$(form).find('input, select, button').addClass('mini-control')
					$('.min, .max').addClass('mini-button')
					$('.form-lbl').addClass('min-label')
					$('.form-group, .input-group').addClass('m-bot')
					//$('.small-input').addClass('small-input-min')

				}
				 
     
				    
			}) //fin return

		}//fin form

		

	})//fin extend

})(jQuery)
