<style>
	.sector{
		
		height: 300px;
		overflow: auto
	}

	.cell{
		width: 200px;
		height: 100px
	}

	#tb-header .cell{
		height: 30px
	}

	.ref{
		width: 70px
	}

	.btn-tb{
		cursor: pointer;
		font-size: 20px
	}
</style>
<div id="table" class="col-12 sector flex-col-start-center pt-5 pb-5">
	<div id="tb-header" class="flex-row-start-center"></div>
	<div id="tb-body" class="flex-row-start-start">
		<div id="tb-tr" class="flex-col-start-center"></div>
		<div id="tb-td" class="flex-col-start-center"></div>
	</div>
</div>


<script>
	'use strict'

	var modalTable
	
	function addTr(pos, n){
		var tds = OBJ.find('thead th').length, 
			tr = $('<tr></tr>')
		for(var i = 0; i < tds; i++){
			tr.append('<td></td>')
		}
									
		OBJ.find('tbody tr').each(function(index){
			if(index == n){
				if(pos < 0){
					$(this).before(tr)
				}else{
					$(this).after(tr)
				}
				setTable()
			}
		})
	}

	function addTd(pos, n){
		OBJ.find('tr').each(function(index){
			var tr = $(this)
			tr.find('th, td').each(function(i){
				var cell = $(this)
				if(i == n){
					var td
					if(index == 0){
						td = $('<th><span>Nueva Columna</span></th>')
						td.find('span')
								.addClass('editable')
					 			.data('toggle','tooltip')
								.prop('title', 'Click para Editar Texto')
								.tooltip()
					 			.click(function(evt){
							 		evt.stopPropagation()
							 		OBJ = $(this)

							 		setMenu('th')
							 		
									openEditor(true)
							 	})
					}else{
						td = $('<td></td>')
						td
								.addClass('editable')
					 			.data('toggle','tooltip')
								.prop('title', 'Click para Insertar Contenido')
								.tooltip()
					 			.click(function(evt){
							 		evt.stopPropagation()
							 		OBJ = $(this)

							 		setMenu(OBJ.prop('tagName').toLowerCase())
							 		
									openEditor(true)
							 	})

					}
					if(pos < 0){
						cell.before(td)
					}else{
						cell.after(td)
					}
					setTable()
				}
			})
		})

		
	}

	

	function setTable(){
		$('#tb-header, #tb-tr, #tb-td').empty()
		$('#tb-header').append('<div class="cell flex-row-center-center p-2 border ref"> </div>')
		OBJ.find('thead th').each(function(index){
			var th = $('<div class="cell flex-row-between-center p-2 border">\
							<i class="btn-tb add-left fa fa-plus-circle text-primary m-2"></i>\
							<i class="btn-tb add-right fa fa-plus-circle text-success m-2"></i>\
							<i class="btn-tb del fa fa-times-circle text-danger m-2"></i>\
						</div>')
			

			th.find('.add-left')
								.prop('title', 'Agregar Columna a la Izquierda')
								.data('index', index)
								.click(function(){
									var n = parseInt($(this).data('index'))
									addTd(-1, n)
								})
			th.find('.add-right')
								.prop('title', 'Agregar Columna a la Derecha')
								.data('index', index)
								.click(function(){
									var n = parseInt($(this).data('index'))
									addTd(1, n)
								})
			th.find('.del')
							.prop('title', 'Eliminar Columna')
							.data('index', index)
							.click(function(){
								var n = parseInt($(this).data('index'))
								modalTable.openModal('tools/modalDeleteTableCell.php?index=' + index + '&del=col')
							})

			th.find('.btn-tb').data('toggle','tooltip').tooltip()
			
			$('#tb-header').append(th)
		})

		OBJ.find('tbody tr').each(function(index){
			var tr = $('<div class="cell flex-col-center-center p-2 border ref">\
							<i class="btn-tb add-top fa fa-plus-circle text-primary m-2"></i>\
							<i class="btn-tb add-bottom fa fa-plus-circle text-success m-2"></i>\
							<i class="btn-tb del fa fa-times-circle text-danger m-2"></i>\
						</div>'), 
				row = $('<div class="tr flex-row-start-center"></div>')

			tr.find('.add-top')
								.prop('title', 'Agregar Fila Arriba')
								.data('index', index)
								.click(function(){
									var n = parseInt($(this).data('index'))
									addTr(-1, n)

								})
			tr.find('.add-bottom')
								.prop('title', 'Agregar Fila Debajo')
								.data('index', index)
								.click(function(){
									var n = parseInt($(this).data('index'))
									addTr(1, n)
								})
			tr.find('.del')
							.prop('title', 'Eliminar Fila')
							.data('index', index)
							.click(function(){
								var n = parseInt($(this).data('index'))
								modalTable.openModal('tools/modalDeleteTableCell.php?index=' + index + '&del=row')
							})

			tr.find('.btn-tb').data('toggle','tooltip').tooltip()
			$('#tb-tr').append(tr)

			$(this).find('td').each(function(){
				var cell = $('<div class="cell p-2 border">f1</div>'), 
					td = $(this), 
					align = td.css('textAlign'), 
					valign = td.css('verticalAlign')
				switch(align){
					case 'left' : align = 'start'; break;
					case 'center' : align = 'center'; break;
					case 'right' : align = 'end'; break;
				}

				switch(valign){
					case 'top' : valign = 'start'; break;
					case 'middle' : valign = 'center'; break;
					case 'bottom' : valign = 'end'; break;
				}
				cell.html(td.html())
				cell.css({ background: td.css('background')})
				cell.addClass('flex-row-' + align + '-' + valign)

				row.append(cell)
			})

			$('#tb-td').append(row)

		})
	}

	if(modalTable == null){
		modalTable = new Modal({
	        	title: 'Eliminar',
	        	size: 'small',
	        	bg: 'bg-danger'
	     })
	}

	setTable()

</script>

