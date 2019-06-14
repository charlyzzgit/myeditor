<style>
	.sector{
		
		height: 300px
	}

	.alert-white{
		background: white !important;
	}

	.alert-none{
		background: transparent !important;
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div id="apariencia" class="sector col-6 flex-col-start-start border p-5">
		<label  class="form-lbl mb-1">Apariencia</label>
	</div>
	<div id="fondo" class="sector col-6 flex-col-start-center border p-5"></div>
</div>


<script>
	'use strict'



	

	var tips = [
			'table-bordered', 
			'table-striped', 
			'table-hover', 
			'table-primary', 
			'table-secondary', 
			'table-info', 
			'table-success', 
			'table-warning', 
			'table-danger', 
			'table-white', 
			'table-light', 
			'table-dark',
			'text-white'
		], 
		table = {
			border: OBJ.hasClass('table-bordered') ? true : false, 
			striped: OBJ.hasClass('table-striped') ? true : false,
			hover: OBJ.hasClass('table-hover') ? true : false,
			bg:getBgTable()
		},
		
		inputs = [

		{
          box: 'apariencia',
          type: 'checkbox',
          label: 'Bordeado:',
          name:'bd',
          checked: table.border,
		  callBack: function(value, data){
          	 table.border = value
          	 setTableApariencia()
          }
        },

        {
          box: 'apariencia',
          type: 'checkbox',
          label: 'Intercalado:',
          name:'strip',
          checked: table.striped,
		  callBack: function(value, data){
          	 table.striped = value
          	 setTableApariencia()
          }
        }, 

        {
          box: 'apariencia',
          type: 'checkbox',
          label: 'Hover:',
          name:'hv',
          checked: table.hover,
		  callBack: function(value, data){
          	table.hover = value
          	 setTableApariencia()
          }
        }, 
		{
			box:'fondo',
			type: 'select',
			options:[
				{name:'Ninguno', value: null, class: 'alert-none'}, 
				{name:'Primary', value: 'primary', class: 'alert-primary mt-1'} ,
				{name:'Secondary', value: 'secondary', class: 'alert-secondary mt-1'},
				{name:'Info', value: 'info', class: 'alert-info mt-1'}, 
				{name:'Success', value: 'success', class: 'alert-success mt-1'}, 
				{name:'Warning', value: 'warning', class: 'alert-warning mt-1'}, 
				{name:'Danger', value: 'danger', class: 'alert-danger mt-1'}, 
				{name:'White', value: 'white', class: 'alert-white mt-1'}, 
				{name:'Light', value: 'light', class: 'alert-light mt-1'}, 
				{name:'Dark', value: 'dark', class: 'alert-dark mt-1'}
			],
			label: 'Fondo:',
			name: 'bg-tb',
			value: table.bg,
			callBack: function(value, data){
				$.each(tips, function(i, tip){
					$('select[name="bg-tb"]').removeClass('alert-' + tip.split('-')[1])
				})
				$('select[name="bg-tb"]').addClass('alert-' + value)
				table.bg = value
				setTableApariencia()

			}
		}, 

		

	]

	function setTableApariencia(){
		
		$.each(tips, function(i, tip){
			OBJ.removeClass(tip)
		})
		if(table.border) OBJ.addClass('table-bordered')
		if(table.striped) OBJ.addClass('table-striped') 
		if(table.border) OBJ.addClass('table-bordered')
		if(table.bg != null) OBJ.addClass('table-' + table.bg)
		if(table.bg == 'dark') OBJ.addClass('text-white')
		}
	

	function getBgTable(){
		ver(['tips', tips])
		var bg = null
		$.each(tips, function(i, tip){
			if(i > 2){
				if(OBJ.hasClass(tip)){
					bg = tip.split('-')[1]
				}
				
			}
		})
		return bg
	}

	$('#form-tool').form({
			     inputs: inputs,
			     minimize:true
			  })

	$('select[name="bg-tb"]').addClass('alert-' + table.bg)
</script>