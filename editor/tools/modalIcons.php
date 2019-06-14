<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	// $index= getPost($request, 'index', -1);
	// $message = '';

	
 ?>

<style>
	.li-icon{
		width: 25%
	}

	.li-icon i{
		font-size: 30px
	}

	.li-icon span{
		line-height: 1.2
	}

	#icons{
		height: 600px;
		overflow-y: auto;
	}

	.li-box{
		height: 120px;
		cursor: pointer;

	}
</style>

 <div class="col-12 flex-col-start-center">
	<ul id="icons" class="col-12 flex-row-start-start flex-wrap">
		<li class="li-icon flex-row-center-center p-2">
			<div class="li-box col-12 flex-col-start-center p-4 alert-primary elevation-1">
				<i class="fa fa-user"></i>
				<span class="mt-1">Icono</span>
			</div>
		</li>
	</ul>
	<div id="close-icons" class="d-none" data-dismiss="modal"></div>
 </div>


 <script>
 	
 	function loadIcons(){
 		$('#icons').empty()
 		$.each(ICONS, function(index, icon){
 			var li = $('<li class="li-icon flex-row-center-center p-2">\
							<div class="li-box col-12 flex-col-start-center p-4 alert-primary elevation-1">\
								<i></i>\
								<span class="mt-1 text-center"></span>\
							</div>\
						</li>')
 			li.find('i').addClass(icon)
 			li.find('span').html(icon)
 			li.find('.li-box').mouseover(function(){
 				$(this).removeClass('alert-primary').addClass('alert-info')
 			}).mouseout(function(){
 				$(this).removeClass('alert-info').addClass('alert-primary')
 			}).data('index', index).click(function(){
 				var n = parseInt($(this).data('index'))
 				$.each(ICONS, function(i, ico){
 					OBJ.find('i').removeClass(ico)
 				})
 				OBJ.find('i').addClass(ICONS[n])
 				$('#close-icons').trigger('click')
 			})
 			$('#icons').append(li)
 		})
 	}

 	loadIcons()

 </script>