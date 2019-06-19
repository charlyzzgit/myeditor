<style>
	.insert-element i{
		font-size: 40px
	}
	ul{
		list-style: none;
	}

	.name{
		font-size: 14px;
		line-height: 1.2
	}

	.insert-element div{
		height: 100px;
	}

	.insert-element div:hover{
		background: #f2f2f2;
		cursor: pointer;
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<ul id="elements" class="col-12 flex-row-start-start flex-wrap p-2 m-0">
		<!-- <?php for($i = 0; $i < 24; $i++){ ?>
		<li class="insert-element col-1 p-2">
			<div class="col-12 flex-col-center-center elevation-2 p-2">
				<i class="fa fa-user"></i>
				<b class="mt-1">elemento</b>
			</div>
		</li>
	<?php } ?> -->
	</ul>
</div>


<script>
	'use strict'

	var btns = [
		{name: 'Texto', tag: 'span', icon:'fa fa-text-height'},
		{name: 'Texto Enriquecido', tag: 'p', icon:'fa fa-paragraph'},
		{name: 'Link', tag: 'a', icon:'fa fa-link'},
		{name: 'Lista', tag: 'ul', icon:'fa fa-list-ul'},
		{name: 'Tabla', tag: 'table', icon:'fa fa-table'},
		{name: 'Imágen', tag: 'img', icon:'fa fa-image'},
		{name: 'Video', tag: 'iframe', icon:'fa fa-video'},
		{name: 'Audio', tag: 'audio', icon:'fa fa-volume-up'},
		{name: 'Linea', tag: 'hr', icon:''},
		{name: 'Icono', tag: 'icon', icon:'fa fa-user'},
		{name: 'Galería Imágenes', tag: 'imgGalery', icon:'fas fa-images'}
		//fa-audio-description

	], 
	tag = OBJ.prop('tagName').toLowerCase()

	if(modalInsert == null){
		modalInsert = new Modal({
	        	title: 'Insertar',
	        	size: 'small',
	        	bg: 'bg-warning'
	     })
	}

	if(modalTextos == null){
		modalTextos = new Modal({
	        	title: 'Tipo de Texto',
	        	size: 'medium',
	        	bg: 'bg-dark'
	     })
	}

	if(tag == 'td'){
		btns = [
			{name: 'Texto', tag: 'span', icon:'fa fa-text-height'},
			{name: 'Texto Enriquecido', tag: 'p', icon:'fa fa-paragraph'},
			{name: 'Link', tag: 'a', icon:'fa fa-link'},
			{name: 'Imágen', tag: 'img', icon:'fa fa-image'},
			{name: 'Video', tag: 'iframe', icon:'fa fa-video'},
			{name: 'Audio', tag: 'audio', icon:'fa fa-volume-up'},
			{name: 'Linea', tag: 'hr', icon:''},
			{name: 'Icono', tag: 'icon', icon:'fa fa-user'}

		]
	}

	function setBtns(){
		$.each(btns, function(i, btn){
			var li = $('<li class="insert-element col-1 p-2">\
							<div class="col-12 flex-col-center-center elevation-2 p-2">\
								<i></i>\
								<b class="name mt-1 text-center"></b>\
							</div>\
						</li>')
			if(btn.icon != ''){
				li.find('i').addClass(btn.icon)
			}else{
				li.find('i').append('<span class="text-center">___</span>')
			}
			li.find('b').html(btn.name)
			li.find('div').data('tag', btn.tag).click(function(){
				var mtag = $(this).data('tag')
			
				if(mtag == 'span'){ //si es texto va a la modal de seleccion de tipo de texto
					if(OBJ.hasClass('editable')){
						//alert('b')
						var box = (tag == 'td') ? 'col' : 'element'
						modalTextos.openModal('tools/modalTextos.php?box=' + box)
					}else{
						//alert('c')
						modalTextos.openModal('tools/modalTextos.php?box=col')
					}
					
				}else{
					if(OBJ.hasClass('editable')){
						//alert('b')
						var box = (tag == 'td') ? 'col' : 'element'
						modalInsert.openModal('tools/modalInsert.php?tag=' + mtag + '&box=' + box)
					}else{
						var box = 'col'
						//alert(OBJ.prop('class'))
						if(OBJ.hasClass('media')){
							box = 'element'
						}
						modalInsert.openModal('tools/modalInsert.php?tag=' + mtag + '&box=' + box)
					}
				}
			})
			$('#elements').append(li)
		})
	}


	

	setBtns()
</script>