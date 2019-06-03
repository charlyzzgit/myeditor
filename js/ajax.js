
function Ajax(action){
	this.params =[]
	this.action = action
	
	this.add = function(field, value){
		this.params.push({field: field, value:value})
	}
	this.send = function(url, callback){
		var params = this.params,
			formData = new FormData(form)
		//console.log('send', JSON.stringify(this.params))
		formData.append('action', this.action)
		formData.append('params', JSON.stringify(params))
									        
		$.ajax({
			url: url,
			method: 'POST',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data: formData, //$(this).serialize(),
			beforeSend: function(){
				
				console.log('send', JSON.stringify(params))
										              
			},
			error: function(xhr, textStatus, error){
				alert('Error: ' + xhr.statusText)	 
			},
			success: function(data, textStatus, xhr){
				logs('data: ', data)
				callback(data)
			}
		})
	}
	
}