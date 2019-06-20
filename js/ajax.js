
function Ajax(){
	this.params =[]
	//this.action = action
	
	this.add = function(field, value){
		console.log(field, value)
		this.params.push({field: field, value:value})
	}
	this.send = function(url, callBack){
		var params = this.params,
			formData = new FormData()
		
		formData.append('_token', $('meta[name="csrf-token"]').attr('content'))
		for(var i = 0; i < this.params.length; i++){
			formData.append(this.params[i].field, this.params[i].value);
			console.log('send', this.params[i].value)
		}
		
		
									        
		$.ajax({
			url: url,
			method: 'POST',
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			data: formData, //$(this).serialize(),
			beforeSend: function(){
				
				console.log('dataSend: ', formData)
										              
			},
			error: function(xhr, textStatus, error){
				try{
					loading(false)
				}catch(e){}

				console.log(
					'ERROR AJAX: ',
					'textStatus: ' + textStatus, 
					'error :' + error, 
					'xhr.statusText: ', xhr.statusText
					) 
				console.warn('warm', xhr)
				console.error('error', xhr)
				var message = 'textStatus: ' + textStatus + 
					'\n, error: ' + error + 
					'\n, xhr.statusText : ' + xhr.statusText
				swal('ERROR DE SISTEMA','Error al Procesar la Solicitud:' + message,'error')
			},
			success: function(data, textStatus, xhr){
				logs('data: ', data)
				callBack(data)
			}
		})
	}
	
}