<style>
	.sector{
		
		height: 300px
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div class="sector col-8 flex-col-center-center border p-2">
		<div id="url" class="col-12"></div>
		<iframe id="video" src="https://www.youtube.com/watch?v=V6oryEBGU2I&list=RDV6oryEBGU2I&start_radio=1" frameborder="0" class="video video-small mt-2" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	</div>
	<div class="sector col-4 flex-col-center-center pl-5 pr-5">
		<div id="size" class="col-12"></div>
	</div>
</div>

<script>
	'use strict'
	var demo = $('#video'), 
		size = 'small', 
		url = OBJ.prop('src')

	function setVideo(url){
		var src = ''
		if(exists(url, 'youtube')){
			//https://www.youtube.com/watch?v=V6oryEBGU2I&list=RDV6oryEBGU2I&start_radio=1
			
			src = 'https://www.youtube.com/embed/' + url.split('watch?v=')[1].split('&')[0]
		}else if(exists(url, 'vimeo')){
			//https://vimeo.com/9153533 
			
			src="https://player.vimeo.com/video/" + url.split('vimeo.com/')[1]
		}

		OBJ.prop('src', src)
		demo.prop('src', src)
	}
	if(OBJ.hasClass('video-medium')){
		size = 'medium'
	}else if(OBJ.hasClass('video-big')){
		size = 'big'
	}else if(OBJ.hasClass('video-big')){
		size = 'full'
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
							{name:'Grande', value:'big'},
							{name:'Full', value:'full'}
						],
						label: 'Tamaño del Video:',
						name: 's-vid',
						value: size,
						callBack: function(value, data){
							OBJ
								.removeClass('video-small video-medium video-big video-full')
								.addClass('video-' + value)
						}
					},

					{
						box:'url',
						type: 'text',
						label: 'Url del Video:',
						value: url,
						name: 'a-url',
						callBack: function(value, data){
							setVideo(value)
							
						}
					}
			     	
              
			     ],
			     minimize:true
			  })
	OBJ.prop('src', url)
	demo.prop('src', url)
</script>

