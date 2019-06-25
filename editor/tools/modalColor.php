<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	$input = getPost($request, 'input', '');
	

 ?>
 <style>
	#list-colors{
		height: 500px;
		overflow-y: auto
	}

	.m-col{
		width: 100px;
		height: 40px;
		border-radius: 5px
	}

	.grupo-item{
		border-radius: 5px;
		width: 18%
	}
</style>
<div class="col-12 flex-col-start-center">
	<ul class="col-12 flex-row-between-start flex-wrap m-0 p-2" style="list-style: none;">
		<li class="grupo-item text-center p-1 m-1 elevation-1 hand text-white" style="background: red" data-scroll="red">Rojos</li>
		<li class="grupo-item text-center p-1 m-1 elevation-1 hand" style="background: pink" data-scroll="pink">Rosas</li>
		<li class="grupo-item text-center p-1 m-1 elevation-1 hand" style="background: orange" data-scroll="orange">Naranjas</li>
		<li class="grupo-item text-center p-1 m-1 elevation-1 hand" style="background: yellow" data-scroll="yellow">Amarillos</li>
		<li class="grupo-item text-center p-1 m-1 elevation-1 hand text-white" style="background: purple" data-scroll="purple">Púrpuras</li>
		<li class="grupo-item text-center p-1 m-1 elevation-1 hand text-white" style="background: green" data-scroll="green">Verdes</li>
		<li class="grupo-item text-center p-1 m-1 elevation-1 hand text-white" style="background: blue" data-scroll="blue">Azules</li>
		<li class="grupo-item text-center p-1 m-1 elevation-1 hand text-white" style="background: brown" data-scroll="brown">Marrones</li>
		<li class="grupo-item text-center p-1 m-1 elevation-1 hand" style="background: white" data-scroll="white">Blancos</li>
		<li class="grupo-item text-center p-1 m-1 elevation-1 hand text-white" style="background: gray" data-scroll="gray">Grises</li>
	</ul>
	<ul id="list-colors" class="col-12 flex-row-between-start flex-wrap m-0"></ul>
</div>
<div id="close-color" class="d-none" data-dismiss="modal"></div>


<script>
	var id_input = '<?php print($input); ?>',
		pos = 0
	
	function getLiColor(col){
		var li = $('<li class="col-12 flex-row-start-center p-2 mb-2">\
						<div class="m-col hand elevation-1"></div>\
						<span class="name ml-3"></span>\
					</li>')
		li.find('.m-col').css('background-color', col.rgb)
		li.find('.name').html(col.name)
		li.find('.m-col').click(function(){
			
			$('input[name="' + id_input + '"]').val($(this).css('background-color')).trigger('keyup')
			$('#close-color').trigger('click')
		})
		return li
	}

	function getID(title){
		switch(title){
			case 'rojos': return 'red'
			case 'rosas': return 'pink'
			case 'naranjas': return 'orange'
			case 'amarillos': return 'yellow'
			case 'púrpuras': return 'purple'
			case 'verdes': return 'green'
			case 'azules': return 'blue'
			case 'marrones': return 'brown'
			case 'blancos': return 'white'
			case 'grises': return 'gray'
			default : return ''
		}
	}

	$.each(COLORS, function(i, col){
		var colores = col.colors,
			li = $('<li class="grupo col-12 flex-col-start-center p-2">\
					<div class="col-12 flex-col-start-center p-2 border">\
						<h4 class="title col-12 p-2"></h4>\
						<ul class="colors col-12 flex-col-start-center mt-1"></ul>\
					</div>\
				</li>'),
			colText = 'white',
			id = getID(col.title)
		if(id == 'pink' || id == 'white' || id == 'yellow' || id == 'orange'){
			colText = 'black'
		}
		li.find('.title').html(col.title.toUpperCase())
		li.prop('id', id)
		li.find('h4').css({
			background: id,
			color: colText
		})
		$.each(colores, function(c, color){
			li.find('ul').append(getLiColor(color))
		})
		
		$('#list-colors').append(li)	
			
	})

	


	$('.grupo-item').click(function(){
		var id = $(this).data('scroll')
		ancla(id)
	})
</script>