<style>
	.sector{
	
		height: 300px
	}

	#box-audio{
		border-radius: 10px !important
	}
</style>
<div id="form-tool" class="col-12 flex-row-center-start">
	<div class="sector col-8 flex-col-center-center border p-4">
		<div id="audio" class="col-12"></div>
		<div id="box-audio" class="col-8 flex-col-center-center mt-4 alert-primary p-3">
			<b>Porbar Audio</b>
			<audio id="demo" controls class=" d-block mt-1">Su Navegador no soporta Audio.</audio>
		</div>
	</div>
	<div class="sector col-4 flex-col-center-center pl-5 pr-5">
		<div id="size" class="col-12"></div>
	</div>
</div>



<script>
	'use strict'
	var demo = $('#demo'), 
		size = 'small'
	if(OBJ.hasClass('audio-medium')){
		size = 'medium'
	}else if(OBJ.hasClass('audio-big')){
		size = 'big'
	}

	demo.prop('src', OBJ.prop('src'))
	$('#form-tool').form({
			     inputs: [
			     	{
						box:'size',
						type: 'radio',
						options:[
							{name:'Chico', value:'small'},
							{name:'Mediano', value:'medium'}, 
							{name:'Grande', value:'big'}
						],
						label: 'Tamaño del Reproductor:',
						name: 's-audio',
						value: size,
						callBack: function(value, data){
							OBJ
								.removeClass('audio-small audio-medium audio-big')
								.addClass('audio-' + value)
						}
					},
			     	{
                box: 'audio',
                type: 'file',
                label: 'Subir Archivo de Audio',
                name: 'a-file',
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
		          	 			//url = '../php/main.php?action=download&url=' + getRootLocation('myeditor') + '/files/' + getUrlImage(TEMA) + '&file=' + file
		          	 			OBJ.prop('src', '../files/' + getUrlImage(TEMA) + file)
		          	 			demo.prop('src', '../files/' + getUrlImage(TEMA) + file)
		          	 		swal('ARCHIVO','Archivo subido correctamente','success')
		          	 	}else{
		          	 		swal('ARCHIVO','Error al Subir:' + data.message,'error')
		          	 	}
		          	 })
				}
              }
			     ],
			     minimize:true
			  })

</script>