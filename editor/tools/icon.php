<style>
	.sector{
		
		height: 300px
	}

	<style>
	.li-icon{
		/*width: 20%*/
	}

	.li-icon i{
		font-size: 30px
	}

	.li-icon span{
		line-height: 1.2
	}

	#icons{
		height: 300px;
		overflow-y: auto;
	}

	.li-box{
		height: 120px;
		cursor: pointer;

	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div class="sector flex-col-start-center p-2">
		<ul id="icons" class="col-12 flex-row-start-start flex-wrap">
			
		</ul>
	</div>
</div>


<script>
	'use strict'

	function loadIcons(){
 		$('#icons').empty()
 		$.each(ICONS, function(index, icon){
 			var li = $('<li class="li-icon col-2 flex-row-center-center p-2">\
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
 					OBJ.removeClass(ico)
 				})
 				OBJ.addClass(ICONS[n])
 				ver(['icono:', ICONS[n], OBJ.prop('class')])
 				$('#close-icons').trigger('click')
 			})
 			$('#icons').append(li)
 		})
 	}

 	loadIcons()
</script>