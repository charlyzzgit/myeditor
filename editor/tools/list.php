<style>
	#list{
		height: 300px;
		overflow-y: auto
	}

	.btn-item{
		font-size: 25px
	}

	#list li{
		background: #f2f2f2
	}

</style>
<ul id="list" class="col-12 flex-col-start-center pt-2"></ul>




<script>
	'use strict'
	
	function getFormLi(text, index){
		var li = $('<li class="col-8 flex-row-start-center mb-2 p-2 border elevation-1">\
							<input type="text" class="form-control mr-3">\
							<i class="btn-item add-top fa fa-plus-circle text-primary m-2"></i>\
							<i class="btn-item add-bottom fa fa-plus-circle text-success m-2"></i>\
							<i class="btn-item del fa fa-times-circle text-danger m-2"></i>\
						</li>')
				li.find('input')
								.val(text)
								.data('index', index)
								.keyup(function(){
									var n = parseInt($(this).data('index')), 
										value = $(this).val()
									addText(n, value)
								})
				li.find('.add-top')
								.prop('title', 'Agregar Item Antes')
								.data('index', index)
								.click(function(){
									var n = parseInt($(this).data('index'))
									addItem(-1, n)
								})
				li.find('.add-bottom')
								.prop('title', 'Agregar Item Despues')
								.data('index', index)
								.click(function(){
									var n = parseInt($(this).data('index'))
									addItem(1, n)
								})
				li.find('.del')
								.prop('title', 'Eliminar Item')
								.data('index', index)
								.click(function(){
									var n = parseInt($(this).data('index'))
									if(OBJ.find('li').length > 1){
										modalLi.openModal('tools/modalDelLi.php?index=' + n)
									}else{
										swal('ATENCION','La Lista debe contener al menos un Item','warning')
									}
								})
				li.find('.btn-item').data('toggle','tooltip').tooltip()
		return li
	}

	function setUl(){
		OBJ.find('li').each(function(index){
			var li = $(this)
			$('#list').append(getFormLi(li.find('span').text(), index))
		})
	}

	function addText(n, text){
		OBJ.find('li').each(function(index){
			var li = $(this)
			if(index == n){
				li.find('span').text(text)
			}
		})

	}

	function addItem(pos, n){
		$('#list').find('li').each(function(index){
			var li = $(this)
			if(index == n){
				if(pos < 0){
					li.before(getFormLi('Nuevo Item', index))
				}else{
					li.after(getFormLi('Nuevo Item', index))
				}
				addLi(pos, n)
			}
		})

		updateIndex()
	}

	function updateIndex(){
		$('#list').find('li').each(function(index){
			var li = $(this)
			li.find('.btn-item, input').data('index', index)
		})
	}

	function addLi(pos, n){
		var icon = OBJ.find('li:first-child').find('i').prop('class'), 
			span = OBJ.find('li:first-child').find('span').prop('class')
		OBJ.find('li').each(function(index){
			var li = $(this)
			if(index == n){
				var row = $('<li class="flex-row-start-center"></li>')
	 			row.append('<i></i>')
	 			row.append('<span class="ml-2"></span>')
	 			row.find('span').text('Nuevo Item').addClass(span)
	 			row.find('i').addClass(icon)
	 			setCss(row.find('i'), getEstiloList(OBJ.find('li:first-child').find('i')))
	 			setCss(row.find('span'), getEstiloList(OBJ.find('li:first-child').find('span')))
	 			ver(['estilos', getEstiloList(OBJ.find('li:first-child').find('i'))])
	 			if(pos < 0){
	 				li.before(row)
	 			}else{
	 				li.after(row)
	 			}
			}
		})
	}

	var modalLi

	if(modalLi == null){
		modalLi = new Modal({
	        	title: 'Eliminar',
	        	size: 'small',
	        	bg: 'bg-danger'
	     })
	}

	setUl()
</script>