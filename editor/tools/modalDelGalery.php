<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	$tag = getPost($request, 'tag', NULL);

	$message = '';
	if($tag != NULL){
		$message = ($tag == 'img') ? '¿Eliminar Imágen seleccionada?' : '¿Eliminar Video seleccionado?';
	}
?>
<style>
	#preview img, .item-img{
		width: 100px;
		height: 100px;
		object-fit: cover;
		margin:2px;
	}

	#preview iframe, .item-vid{
		width: 160px;
  		height: 90px;
  		margin:2px;
	}

	.item-vid{
		position: relative;
	}

	.item-vid iframe{
		width: 100%;
		height: 100%;
	}

	.blocked{
		width: 100%;
		height: 100%;
		position: absolute;
		top:0;
		left: 0;
		z-index: 10
	}

	.item-img:hover, .blocked:hover{
		border: solid 5px red;
		cursor: pointer;
	}
</style>
 <div class="col-12 flex-col-start-center">
	<div id="info" class="col-12 flex-col-start-center">
	 	<div id="preview" class="col-4 flex-row-center-center">
	 		<img>
	 		<iframe class="video" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	 	</div>
	 	<div class="flex-row-center-center mt-2 mb-2">
	 		<b class="alert alert-warning m-0"><?php print($message); ?></b>
	 		<button id="gal-si" class="btn btn-success ml-3 mr-1">SI</button>
	 		<button id="gal-no" class="btn btn-danger ml-1">NO</button>
	 	</div>
	 	
	</div>
	<div id="gal" class="col-12 flex-row-start-start flex-wrap"></div>
	<div class="col-12 flex-row-center-center p-2 alert-info">
		<span>Seleccione el Elemento a Eliminar</span>
		<i id="adv" class="fas fa-info-circle text-warning ml-2 " style="font-size: 30px"></i>
	</div>
	<div id="close-gal" class="d-none" data-dismiss="modal"></div>
 </div>

 <script>

 	var tag = '<?php print($tag); ?>'

 	function setGalery(tag){
 		if(tag == 'img'){
 			$('#gal').empty()
	 		OBJ.find('img').each(function(index){
				var obj = $(this),
					img = $('<img class="img-thumbnail item-img">')
				img.prop('src', obj.prop('src'))
				img.data('index', index)
				img.click(function(){
					$('#gal-si').data('index', $(this).data('index'))
					$('#preview img').prop('src', $(this).prop('src')).show()
					$('#info').show()
				})
				$('#gal').append(img)
			})
	 	}else if(tag == 'video'){
	 		$('#gal').empty()
	 		OBJ.find('.box-gal').each(function(index){
				var obj = $(this).find('iframe'),
					vid = $('<div class="item-vid"><iframe class="video" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>')
				vid.find('.video').prop('src', exists(obj.prop('src'), 'myeditor/editor/') ? '' : obj.prop('src'))
				vid.data('index', index)
				vid.append('<div class="blocked"></div>')
				vid.click(function(){
					var vd = $(this).find('.video')
					$('#gal-si').data('index', $(this).data('index'))
					$('#preview iframe').prop('src', exists(vd.prop('src'), 'myeditor/editor/') ? '' : vd.prop('src')).show()
					$('#info').show()
				})
				$('#gal').append(vid)
			})
	 	}
 	}

 	$('#info, #preview img, #preview iframe').hide()

 	if(tag != null){
 		setGalery(tag)
 	}
 	
	$('#gal-si').click(function(){
		var n = parseInt($(this).data('index'))
		if(tag == 'img'){
			OBJ.find('img').each(function(index){
				if(index == n){
					$(this).remove()
					loadImages()
				}
			})
		}else if(tag == 'video'){
			OBJ.find('.box-gal').each(function(index){
				if(index == n){
					$(this).remove()
					loadVideos()
				}
			})
		}
		var message = 'Elelemento seleccionado fue removido de la Galería. Para que la acción surta efecto real debe guadar el Proyecto "BOTON GUARDAR"'
		swal('QUITAR DE GALERIA', message,'warning').then((value) => {
	 		$('#close-gal').trigger('click')
		});
		
	})

	$('#gal-no').click(function(){
		$('#info').hide()
	})

	$('#adv')
			.data('toggle','tooltip')
			.prop('title', 'Importante: esta acción quita el Elemento de la Galería. Para Eliminarla definitivamente debe guardar todo')
			.tooltip()

 </script>