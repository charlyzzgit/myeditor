<style>
	.sector{
		
		height: 300px
	}

	

	
	#btn{
		
		height: 200px;
		overflow-y: auto
	}

	#btn button{
		width: 22%;

	}
</style>
<div id="form-tool" class="col-12 flex-row-center-start">
	
	<div class="sector col-6 flex-row-start-start flex-wrap border p-2">
		<div id="text" class="col-6 flex-row-center-center border p-2 alert-primary" style="height: 75px"></div>
		<div class="col-6 flex-col-end-center pl-2" style="height: 75px">
			<a id="single" href="#">Link Simple</a>
			<div class="col-12 flex-row-center-center mt-2" style="background: #f2f2f2">Link Tipo Botón <i class="fa fa-arrow-circle-down ml-2"></i></div>
		</div>
		<div id="btn" class="col-12 flex-row-between-center flex-wrap p-2">
			
				<button class="btn btn-primary mt-2" data-btn="primary">Primary</button>
				<button class="btn btn-info mt-2" data-btn="info">Info</button>
				<button class="btn btn-success mt-2" data-btn="success">Success</button>
				<button class="btn btn-warning mt-2" data-btn="warning">Warning</button>
				<button class="btn btn-danger mt-2" data-btn="danger">Danger</button>
				<button class="btn btn-light mt-2" data-btn="light">Light</button>
				<button class="btn btn-secondary mt-2" data-btn="secondary">Secondary</button>
				<button class="btn btn-dark mt-2" data-btn="dark">Dark</button>
			
			
				<button class="btn btn-outline-primary mt-2" data-btn="outline-primary">Off Primary</button>
				<button class="btn btn-outline-info mt-2" data-btn="outline-info">Off Info</button>
				<button class="btn btn-outline-success mt-2" data-btn="outline-success">Off Success</button>
				<button class="btn btn-outline-warning mt-2" data-btn="outline-warning">Off Warning</button>
				<button class="btn btn-outline-danger mt-2" data-btn="outline-danger">Off Danger</button>
				<button class="btn btn-outline-light mt-2" data-btn="outline-light">Off Light</button>
				<button class="btn btn-outline-secondary mt-2" data-btn="outline-secondary">Off Secondary</button>
				<button class="btn btn-outline-dark mt-2" data-btn="outline-dark">Off Dark</button>
			
		</div>
	</div>
	<div class="sector col-6 flex-col-start-center border p-2">
		<div id="type" class="col-12 flex-row-center-center p-2"></div>
		<div id="link" class="col-12 flex-row-center-center p-2"></div>
		<div id="download" class="col-12 flex-row-center-center p-2"></div>
		<a id="verify" class="btn btn-primary mt-3 text-white">Verificar Link</a>
	</div>
</div>


<script>
	'use strict'
	//$("a:visited")
	//:link - :visited - :focus - :hover - :active

	var link = getLink(OBJ), 
		inputs = [
			{
				box:'text',
				type: 'text',
				label: 'Texto del Enlace:',
				value: link.text,
				name: 'a-label',
				callBack: function(value, data){
					link.text = value
					setLink()
				}
			}, 

			

			{
	           box: 'type',
	           type: 'switch',
	           label: 'Tipo de Enlace:',
	           name:'tipo',
	           onColor: 'info',
	           offColor: 'success',
	           onText: 'Url',
	           offText: 'Descarga',
	           checked: parseInt(link.type) == 0 ? true : false,
	          
	           callBack: function(value, data){
	           		setType(value)
	           		link.type = (value) ? 0 : 1
	           		setLink()
				}

	         }, 

	         {
				box:'link',
				type: 'text',
				label: 'Url:',
				value: link.url,
				name: 'a-url',
				callBack: function(value, data){
					link.url = value
					setLink()
				}
			},

			{
                box: 'download',
                type: 'file',
                label: 'Link de Descarga',
                name: 'a-download',
                placeholder: 'Subir Archivo',
               	callBack: function(value, data){
					var aj = new Ajax(),
		          	 	 idtema = TEMA.id,
		          	 	 idelement = OBJ.prop('id').split('-')[1]
		          	 aj.add('action', 'sendFile')
		          	 aj.add('idtema', idtema)
		          	 aj.add('idelement', idelement)
		          	 aj.add('file', value)
		          	 loading(true)
		          	 aj.send('../php/main.php', function(data){
		          	 	ver(['result file', data])
		          	 	loading(false)
		          	 	if(data.result == SUCCESS){
		          	 		var file = data.file
		          	 		link.url = '../php/main.php?action=download&url=' + getRootLocation('myeditor') + '/files/' + getUrlImage(TEMA) + '&file=' + file
		          	 		setLink()
		          	 		swal('ARCHIVO','Archivo subido correctamente','success')
		          	 	}else{
		          	 		swal('ARCHIVO','Error al Subir:' + data.message,'error')
		          	 	}
		          	 })
				}
              },
		]

	function setType(value){
		if(value){
		     $('#link').show()
		     $('#download').hide()
		     $('#verify').html('Verificar Link')
		     link.type = 0
	    }else{
		     $('#link').hide()
		     $('#download').show()
		     $('#verify').html('Verificar Descarga')
		     link.type = 1
	    }
	}

	function setLink(){
		OBJ
			.text(link.text)
			.prop('href', link.url)
			.data('type', link.type)
			.removeClass('btn btn-primary btn-info btn-success btn-warning btn-danger btn-light btn-secondary btn-dark btn-outline-primary btn-outline-info btn-outline-success btn-outline-warning btn-outline-danger btn-outline-light btn-outline-secondary btn-outline-dark')

		if(link.view != null){
			OBJ.addClass('btn btn-' + link.view)
		}

		
		$('#verify').click(function(evt){
			evt.preventDefault()
			window.open(link.url, "_blank")
		})
		

		
	}

	$('#form-tool').form({
		inputs: inputs,
		minimize:true
	})



	$('#btn button, #verify').removeClass('mini-control')

	$('#btn button').addClass('elevation-2').click(function(){
		link.view = $(this).data('btn')
		setLink()
	})

	$('#single').click(function(evt){
		evt.preventDefault()
		link.view = null
		setLink()

	})
	setType(parseInt(link.type) == 0 ? true : false)
	setLink()
	
</script>

