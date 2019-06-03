// JavaScript Document
//implementacion:
//1 - añadir clase 'frm' a cada contenedor que incluya los elementos a enviar
//2 - insertar elementos form.inputLoQueSea
//3 - enviar form.send
	var style_form_group = ' flex-col-center-center flex-nowrap';
	function optionSelect(text, val){
		this.clave = text;
		this.valor = val;
	}
	
	function markAssForm(id_container){
		if(!$('#' + id_container).hasClass('frm')){
			$('#' + id_container).addClass('frm')
		}
		//$('#' + id_container).empty()
	}
	
	function valuePair(clave, valor){
		this.clave = clave;
		this.valor = valor;
	}
	
	function Form(){
		$('.frm').empty()
		this.aj =  new AjaxFull();
		this.row = $('<div class="form-group"></div>');
		this.items = [];
		this.files = [];
		this.buttons = [];
		this.align = ' text-center';
		this.response = 'default';
		
		this.setStyle = function(pos){
			var position = '';
			switch(pos){
				case -1: position = 'start'; break;
				case 0: position = 'center'; break;
				case 1: position = 'end'; break;
			}
			style_form_group = ' d-flex flex-column align-items-' + position + ' justify-content-center flex-nowrap';
			
		}
		
		this.inputAlign = function(align){
			this.align = ' text-' + align;
		}
		
		this.inputHidden = function(id_container, id, val){
			markAssForm(id_container)
			var input ='<input type="hidden" id="' + id + '" value="' + val + '">';
			$('#' + id_container).append($(input));
			this.items.push(new optionSelect(id, id));
		}
		
		this.inputText = function(id_container, id, label, val, callBack){
			markAssForm(id_container)
			var div = $('<div class="form-group' + style_form_group + '"></div>');
			$(div).append('<label>' + label + '</label>');
			$(div).append('<input type="text" class="form-control' + this.align + '" id="' + id + '" value="' + val + '">');
			if(callBack != null){
				$(div).find('#' + id).keyup(function(e){
					if(e.which == 13){
						callBack($(this).val())
					}
				});
			}
			$('#' + id_container).append($(div));
			this.items.push(new optionSelect(id, id));
		}
		
		
		
		this.inputArea = function(id_container, id, label, val, height, callBack){
			markAssForm(id_container)
			var div = $('<div class="form-group' + style_form_group + '"></div>');
			$(div).append('<label>' + label + '</label>');
			$(div).append('<textarea class="form-control' + this.align + '" id="' + id + '" style="height: ' + height + 'px !important">' + val + '</textarea>');
			$('#' + id_container).append($(div));
			this.items.push(new optionSelect(id, id));

			 $('#' + id).on('keyup', function(){
		        if(callBack != null){
					callBack(id_container, $('#' + id).val())
				}
		    }).keyup()
			
		}
		
		this.inputColor = function(id_container, id, label, val){
			markAssForm(id_container)
			var div = $('<div class="form-group' + style_form_group + '"></div>');
			$(div).append('<label>' + label + '</label>');
			$(div).append('<input type="color" class="form-control' + this.align + '" id="' + id + '" value="' + val + '">');
			$('#' + id_container).append($(div));
			this.items.push(new optionSelect(id, id));
		}
		
		this.inputPass = function(id_container, id, label, val){
			markAssForm(id_container)
			var div = $('<div class="form-group' + style_form_group + '"></div>');
			$(div).append('<label>' + label + '</label>');
			$(div).append('<input type="password" class="form-control' + this.align + '" id="' + id + '" value="' + val + '">');
			$('#' + id_container).append($(div));
			this.items.push(new optionSelect(id, id));
		}

		this.inputFile = function(id_container, id, label, src, clik_msg, img_wsize, img_hsize, callBack){
			markAssForm(id_container)
			var div = $('<div class="form-group' + style_form_group + ' p-0"></div>');
			$(div).append('<label>' + label + '</label>');
            $(div).append('<div id="' + id + '" class="file"><img id="img' + id + '" src="' + src + '" width="' + img_wsize + '" height="' + img_hsize + '" style="cursor:pointer; border:none; "></div>');
            if(clik_msg != ''){
            	$(div).append('<label class="mt-1">' + clik_msg + '</label>');
            }
            
			$('#' + id_container).append($(div));
			this.aj.addFile(id, function(r){
				$('#' + id).find('img').attr('src', r);
				if(callBack != null){
					callBack(r)
				}
				
			});
			this.files.push(new optionSelect(id, id));
		}


		this.inputFileButton = function(id_container, id, label, src, clik_msg, img_size, callBack){
			markAssForm(id_container)
			var div = $('<div class="form-group' + style_form_group + ' p-0"></div>');
			$(div).append('<label>' + label + '</label>');
            $(div).append('<div><img id="img' + id + '" src="' + src + '" width="' + img_size + '" height="auto" style="cursor:pointer; border:solid 1px rgba(0, 0, 0, .2); "></div>');
            $(div).append('<button  id="' + id + '"class="btn btn-info mt-1 file">' + clik_msg + '</button>');
			$('#' + id_container).append($(div));
			this.aj.addFile(id, function(r){
				$('#img' + id).attr('src', r);
				callBack(r)
			});
			this.files.push(new optionSelect(id, id));
		}

		this.getFile = function(id){

			return this.aj.getFile(id)
		}
		
		this.inputSelect = function(id_container, id, label, array_options, val, callBack){
			markAssForm(id_container)
			var div = $('<div class="form-group' + style_form_group + '"></div>');
			var sel = $('<select id="' + id + '" class="form-control' + this.align + ' custom-select"></select>');
			$(div).append('<label>' + label + '</label>');
			$(sel).empty()
			for(var i = 0; i < array_options.length; i++){
				var selected = '';
				
				if(array_options[i].valor == val){
					selected = ' selected';
				}
				$(sel).append('<option value="' + array_options[i].valor + '"' + selected + '>' + array_options[i].clave + '</option>');
			}
			if(callBack != null){
				$(sel).change(function(){
					callBack(id_container, $(this).val())
				});
			}
			$(div).append($(sel));
			$('#' + id_container).append($(div));
			this.items.push(new optionSelect(id, id));
		}
		
		this.inputCheckBox = function(id_container, id, label, array_options, sel_val, style, callBack){
			markAssForm(id_container)
			var flex, sep, mr;
			if(style == 'row'){
				flex = 'flex-row-center-center'
				sep = ' ml-3'
				mr = 'mr-1'
			}else{
				flex = 'flex-col-start-start'
				sep = ''
				mr = ''
			}
			var div = $('<div class="form-group w-100 ' + flex + '"  id="' + id + '"></div>');
			if(label != ''){ 
				$(div).append('<label class="m-0 ' + mr + '">' + label + '</label>')
			}
			for(var i = 0; i < array_options.length; i++){
				if(style == 'row'){
					if(i == 0){ sep = '' }else{ sep = ' ml-3'}
				}
				
				var optionCheckbox = $('<div class="flex-row-start-center"></div>');
				$(optionCheckbox).append('<input type="checkbox" class="custom-checkbox ' + sep + '" id="' + id + '" name="' + id + '" value="' + array_options[i].valor + '">');
				$(optionCheckbox).append('<label class="m-0 mt-0 ml-1">' + array_options[i].clave + '</label>');
				
				if(array_options[i].valor == sel_val){
					$(optionCheckbox).find('input').prop('checked', true);
				}
				
				$(div).append($(optionCheckbox));
			}
			if(callBack != null){
				
				$(div).find('input').change(function(){
					callBack(id_container, $(this).val())
				});
			}
			$('#' + id_container).append($(div));
			this.items.push(new optionSelect(id, id));
		}
		
		this.inputRadio = function(id_container, id, label, array_options, sel_val, style, callBack){
			markAssForm(id_container)
			var flex, sep, mr;
			if(style == 'row'){
				flex = 'flex-row-center-center'
				sep = ' ml-3'
				mr = 'mr-1'
			}else{
				flex = 'flex-col-start-start'
				sep = ''
				mr = ''
			}
			var div = $('<div class="form-group w-100 ' + flex + '"  id="' + id + '"></div>');
			if(label != ''){ 
				$(div).append('<label class="m-0 ' + mr + '">' + label + '</label>')
			}
			for(var i = 0; i < array_options.length; i++){
				if(style == 'row'){
					if(i == 0){ sep = '' }else{ sep = ' ml-3'}
				}
				
				var optionRadio = $('<div class="flex-row-start-center"></div>');
				$(optionRadio).append('<input type="radio" class="custom-radio ' + sep + '" name="' + id + '" value="' + array_options[i].valor + '">');
				$(optionRadio).append('<label class="m-0 mt-0 ml-1">' + array_options[i].clave + '</label>');
				
				if(array_options[i].valor == sel_val){
					$(optionRadio).find('input').prop('checked', true);
				}
				
				$(div).append($(optionRadio));
			}
			if(callBack != null){
				
				$(div).find('input').change(function(){
					callBack($(this).val())
				});
			}
			$('#' + id_container).append($(div));
			this.items.push(new optionSelect(id, id));
		}
		
		
		
                            	
                                   
							
		
		this.inputGridRadio = function(cols, id_container, id, array_options, sel_val, callBack){
			markAssForm(id_container)
			
			var div = $('<div class="col-12 flex-col-center-center flex-wrap p-0 grid-radio"></div>'),
				c = 0,
				row = $('<div class="col-12 flex-row-between-center p-1 grid-row"></div>')
				
			for(var i = 0; i < array_options.length; i++){
				
				
				var optionRadio = $('<div class="col-4 flex-row-center-center pl-0 pr-0"></div>')
				if(c % cols == 0){
					if(c != 0){
						$(div).append($(row));
						row = $('<div class="col-12 flex-row-center-center p-1 grid-row"></div>')
					}
				}
				
				if(array_options[i].valor != ''){
					$(optionRadio).append('<input type="radio" class="custom-radio" name="' + id + '" value="' + array_options[i] + '">')
				}
				if(array_options[i].valor == sel_val){
					$(optionRadio).find('input').prop('checked', true);
				}
				
				$(row).append($(optionRadio));
				/*
				if(r % rows == 0){
					if(r != 0){
						$(div).append($(row));
					}
					
				}*/
				
				
				c++
			}
			
			if($(row).html() != ''){
				$(div).append($(row));
			}
			
			if(callBack != null){
				
				$(div).find('input').change(function(){
					callBack($(this).val())
				});
			}
			$('#' + id_container).append($(div));
			this.items.push(new optionSelect(id, id));
		}
		
		this.inputMaxMin = function(id_container, id, label, val, minimo, maximo, increment, callback){
			markAssForm(id_container)
			var div = $('<div class="form-group' + style_form_group + '"></div>'),
				m = [],
				maxmin = $('<div class="max-min-group flex-row-between-center p-0"></div>')
			m.push('<button id="min-' + id + '" class="btn btn-seccondary">-</button>')
			m.push('<input id="' + id + '" type="text" class="form-control ml-1 mr-1 text-center" value="' + val + '">')
			m.push('<button id="max-' + id + '" class="btn btn-seccondary">+</button>')
			$(maxmin).append(m.join(''))
			$(div).append('<label>' + label + '</label>');
			$(div).append($(maxmin));
			$(div).find('#' + id).keyup(function(e){
				if(e.which == 13){
					callback(id_container, $(this).val())
				}
			});
			
			var timer
			$(div).find('#min-' + id).data('container', id_container).data('stop', minimo).data('increment', increment).mousedown(function(){
				
				var n = parseInt($(div).find('#' + id).val()),
					h = parseInt($(this).data('stop')),
					container = $(this).data('container'),
					inc = 1
					
				if($(this).data('increment') == '0.1'){
					inc = 0.1
					h = parseFloat($(this).data('stop'))
					n = parseFloat($(div).find('#' + id).val())
				}
				
				timer = setInterval(function(){
					var num
					n-=inc
				
					if(n < h){
						n = h
					}
					if(inc == 0.1){
						if(n % 1 != 0){
							num = n.toFixed(1)
						}else{
							num = n + '.0'
						}
					}else{
						num = n
					}
					$(div).find('#' + id).val(num)
					callback(container, n)
				}, 50)
			}).mouseup(function(){
				clearInterval(timer)
			})
			
			$(div).find('#max-' + id).data('container', id_container).data('stop', maximo).data('increment', increment).mousedown(function(){
				var n = parseInt($(div).find('#' + id).val()),
					h = parseInt($(this).data('stop')),
					container = $(this).data('container'),
					inc = 1
				if($(this).data('increment') == '0.1'){
					inc = 0.1
					h = parseFloat($(this).data('stop'))
					n = parseFloat($(div).find('#' + id).val())
				}
				
				timer = setInterval(function(){
					var num
					n+=inc
					if(n > h){
						n = h
					}
					if(inc == 0.1){
						if(n % 1 != 0){
							num = n.toFixed(1)
						}else{
							num = n + '.0'
						}
					}else{
						num = n
					}
					$(div).find('#' + id).val(num)
					callback(container, n)
				}, 50)
			}).mouseup(function(){
				clearInterval(timer)
			})
			$('#' + id_container).append($(div));
			this.items.push(new optionSelect(id, id));
		}
		
		
		
		
		this.inputButton = function(id_container, id, type, value, funEvent){
			markAssForm(id_container)
			var btn = $('<button id="' + id + '" type="button" class="btn btn-' + type + ' m-1">' + value + '</button>');
			$(btn).click(function(){
				funEvent();
			});
			$('#' + id_container).append($(btn));
			this.buttons.push($(btn));
		}
		
		this.clear = function(){
			var inputs = this.items;
			for(var i = 0; i < inputs.length; i++){
				var id = inputs[i].valor;
				$('#' + id).val('');
			}
		}

		this.empty = function(){
			$('.frm').empty()
		}
		
		this.inputsToJson = function(){ 
			var inputs = this.items;
			var posts = [];
			
			for(var i = 0; i < inputs.length; i++){
				var input = inputs[i];
				var lbl = input.clave;
				var id = input.valor;
				if($('#' + id).hasClass('form-group')){
					var inp = $('#' + id).find('input').attr('name', lbl).prop('checked');
					posts.push( new valuePair(lbl, $(inp).val()) );
				}else{
					if($('#' + id).attr('type') == 'checkbox'){
						posts.push(new valuePair(lbl, $('#' + id).prop('checked')));
					}else if($('#' + id).attr('type') == 'hidden'){
						posts.push( new valuePair(lbl, $('#' + id).val()) );
					}else{
						posts.push(new valuePair(lbl, $('#' + id).val()));
					}
				}
			}
			return toJson(posts);
		 }
		 
		 
		 this.inputError = function(id, msg){
		 		if($('#' + id).val() == ''){
		 			$('#' + id).focus(function(){
					$(this).parent('.form-group').find('.del-span').remove();
					});
					$('#' + id).parent('.form-group').append('<span class="del-span text-danger">' + msg + '</span>');
		 		}
			 	
		 }
		
		 
		 this.send = function(action, url, successEvent, errorEvent){
			 this.aj.addVar('accion', action);
			 this.aj.addVar('inputs', this.inputsToJson());
			 this.aj.addVar('namefiles', toJson(this.files));
			 for(var i = 0; i < this.files.length; i++){
				 this.aj.addVar(this.files[i].clave, this.aj.getFile(this.files[i].valor));
			 }
			
			 this.aj.send(url, function(r){
				
				
				 if(getAjax(r, '__OK__')){
					 successEvent(r);
				 }else{
				 	 logs('Error: ' + r);
					errorEvent(r); 
				 }
			 });
			 
		 }
		 
		
	
	}
	