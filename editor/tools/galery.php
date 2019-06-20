<style>
	.sector{
		height: 250px
	}

	.form-group{
		width: auto !important
	}

	#images{
		overflow-y: auto
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div class="col-8 flex-col-start-center">
		<div id="images" class="sector col-12 flex-row-start-start flex-wrap border"></div>
		<div class="flex-row-center-center" style="height: 50px">
			<button id="add-image" class="btn btn-primary mr-2">Agregar Imágen</button>
			<button id="del-image" class="btn btn-danger ml-2">Quitar Imágen</button>
		</div>
	</div>
	<div class="col-4 flex-row-between-start">
		<div id="size" class="col-6 flex-row-center-start p-2 pt-5 border"  style="height: 300px"></div>
		<div id="margin" class="col-6 flex-row-center-start p-2 pt-5 border"  style="height: 300px"></div>
	</div>
</div>


<script>
	'use strict'

	var inputs = [],
		size = 'img-gal-min',
		margin = parseInt(OBJ.find('img').css('margin').split('px')[0])

	if(OBJ.find('img').hasClass('img-gal-small')){
		size = 'img-gal-small'
	}

	if(OBJ.find('img').hasClass('img-gal-medium')){
		size = 'img-gal-medium'
	}

	if(OBJ.find('img').hasClass('img-gal-big')){
		size = 'img-gal-big'
	}
		
	function loadImages(){
		inputs = []
		$('#images, #size, #margin').empty()
		OBJ.find('img').each(function(){
			var obj = $(this)
			inputs.push(
				{
		          box: 'images',
		          type: 'image',
		          label: '',
		          name: 'foto',
		          size:100,
		          
		          src: obj.prop('src') != null ? obj.prop('src') : IMG + 'noimage.png',
		          callBack: function(value, data){
		          	 var aj = new Ajax(),
		          	 	 idtema = TEMA.id,
		          	 	 idelement = obj.prop('id').split('-')[1]
		          	 aj.add('action', 'sendImage')
		          	 aj.add('idtema', idtema)
		          	 aj.add('idelement', idelement)
		          	 aj.add('image', value)
		          	 loading(true)
		          	 aj.send('../php/main.php', function(data){
		          	 	ver(['result image', data])
		          	 	loading(false)
		          	 	if(data.result == SUCCESS){
		          	 		var image = data.image
		          	 		obj.prop('src', '../img/' + getUrlImage(TEMA) + image)
		          	 	}else{
		          	 		swal('IMAGEN','Error al Guardar:' + data.message,'error')
		          	 	}
		          	 }) //fin ajax
		          } //fin callback
			   }//fin input
			) //fin push
		}) //fin each

		inputs.push({
						box:'size',
						type: 'radio',
						options:[
							{name:'Muy Chica', value:'img-gal-min'},
							{name:'Chica', value:'img-gal-small'},
							{name:'Normal', value:'img-gal-medium'},
							{name:'Grande', value:'img-gal-big'}
						],
						label: 'Tamaño de las Imágenes:',
						name: 'i-size',
						value: size,
						callBack: function(value, data){
							OBJ.find('img')
										.removeClass('img-gal-min img-gal-small img-gal-medium img-gal-big')
										.addClass(value)
							
						}
					})
		inputs.push({
			box:'margin',
			type: 'spinner',
			min:0,
			max:100,
			label: 'Separación entre Imágenes:',
			name: 'mg',
			value: margin,
			
			callBack: function(value, data){
				OBJ.find('img').css('margin', value + 'px')
			}
		})

		$('#form-tool').form({
			     inputs: inputs,
			     minimize:true
			  })
	}

	loadImages()

	$('#add-image').click(function(){
		var img = $('<img>')
		img.prop('src', IMG + 'noimage.png')
		img.addClass('img-gal-min')
		OBJ.append(img)
		loadImages()
	})
	.data('toggle','tooltip')
	.prop('title', 'Agrega una Imágen Lista para cargar')
	.tooltip()

	$('#del-image').click(function(){
		modalDelGal.openModal('tools/modalDelGalery.php?tag=img')
	})
	.data('toggle','tooltip')
	.prop('title', 'Abre un Selector de Imágenes para eliminar la Imágen elegida')
	.tooltip()
	
</script>

