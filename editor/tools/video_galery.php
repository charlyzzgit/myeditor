<style>
	.sector{
		height: 250px
	}

	/*.form-group{
		width: auto !important
	}*/

	.vid-box{
		width: 24%;
		background: #f2f2f2;
		margin:.5%;
	}

	
	#videos{
		overflow-y: auto
	}


</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div class="col-8 flex-col-start-center">
		<div id="videos" class="sector col-12 flex-row-start-start flex-wrap border p-1"></div>
		<div class="flex-row-center-center" style="height: 50px">
			<button id="add-video" class="btn btn-primary mr-2">Agregar Video</button>
			<button id="del-video" class="btn btn-danger ml-2">Quitar Video</button>
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
		size = 'video-gal-min',
		margin = 2
	try{
		margin = parseInt(OBJ.find('.box-gal').css('margin').split('px')[0])
	}catch(e){}

	if(OBJ.find('box-gal').hasClass('video-gal-min')){
		size = 'video-gal-min'
	}

	if(OBJ.find('box-gal').hasClass('video-gal-small')){
		size = 'video-gal-small'
	}

	if(OBJ.find('box-gal').hasClass('video-gal-medium')){
		size = 'video-gal-medium'
	}

	if(OBJ.find('box-gal').hasClass('video-gal-big')){
		size = 'video-gal-big'
	}


	function setVideo(obj, demo, url){
		var src = ''
		if(exists(url, 'youtube')){
			//https://www.youtube.com/watch?v=V6oryEBGU2I&list=RDV6oryEBGU2I&start_radio=1
			
			src = 'https://www.youtube.com/embed/' + url.split('watch?v=')[1].split('&')[0]
		}else if(exists(url, 'vimeo')){
			//https://vimeo.com/9153533 
			
			src="https://player.vimeo.com/video/" + url.split('vimeo.com/')[1]
		}

		obj.prop('src', src)
		demo.prop('src', src)
	}
		
	function loadVideos(){
		inputs = []
		$('#videos, #size, #margin').empty()
		OBJ.find('.box-gal').each(function(index){
			var obj = $(this).find('iframe'),
				div = $('<div class="vid-box flex-col-start-center p-2 elevation-2"></div>'),
				video = $('<iframe frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>')
			div.prop('id', 'video-' + index)
			video.prop('src', exists(obj.prop('src'), 'myeditor/editor/') ? '' : obj.prop('src'))
			video.addClass('video video-gal-min')
			div.append(video)
			$('#videos').append(div)
			inputs.push(
				{
						box:'video-' + index,
						type: 'text',
						label: 'Url del Video:',
						value: exists(obj.prop('src'), 'myeditor/editor/') ? '' : obj.prop('src'),
						name: 'vd-url',
						data:{index: index},
						callBack: function(value, data){
							setVideo(obj, $('#video-' + data.index), value)
							
						}
				}
		          
			) //fin push
		}) //fin each

		inputs.push({
						box:'size',
						type: 'radio',
						options:[
							{name:'Muy Chico', value:'video-gal-min'},
							{name:'Chico', value:'video-gal-small'},
							{name:'Normal', value:'video-gal-medium'},
							{name:'Grande', value:'video-gal-big'}
						],
						label: 'Tamaño de las Imágenes:',
						name: 'i-size',
						value: size,
						callBack: function(value, data){
							OBJ.find('.box-gal')
										.removeClass('video-gal-min video-gal-small video-gal-medium video-gal-big')
										.addClass(value)
							
						}
					})
		inputs.push({
			box:'margin',
			type: 'spinner',
			min:0,
			max:100,
			label: 'Separación entre Videos:',
			name: 'mg',
			value: margin,
			
			callBack: function(value, data){
				OBJ.find('.box-gal').css('margin', value + 'px')
			}
		})

		$('#form-tool').form({
			     inputs: inputs,
			     minimize:true
			  })

		$('#videos').find('.form-group').addClass('text-center')
		
	
	}

	loadVideos()

	$('#add-video').click(function(){
		var box = $('<div class="box-gal video-gal-min float-left"></div>'),
			video = $('<iframe frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>')
		video.prop('src', '')
		video.addClass('video')
		box.css('margin', '2px')
		box.append(video)
		box.append('<div></div>')
		OBJ.append(box)
		loadVideos()
	})
	.data('toggle','tooltip')
	.prop('title', 'Agrega una Video Listo para cargar')
	.tooltip()

	$('#del-video').click(function(){
		modalDelGal.openModal('tools/modalDelGalery.php?tag=video')
	})
	.data('toggle','tooltip')
	.prop('title', 'Abre un Selector de Videos para eliminar el Video elegido')
	.tooltip()

OBJ.resizable()
</script>

