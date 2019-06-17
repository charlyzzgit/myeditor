<style>
	.sector{
		
		height: 300px
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start flex-wrap">
	<div id="distribution" class="sector col-4 flex-col-start-center border p-5"></div>
	<div id="align" class="sector col-4 flex-col-start-center border p-5"></div>
	<div id="valign" class="sector col-4 flex-col-start-center border p-5"></div>
</div>



<script>
	'use strict'

	var tag = (OBJ.hasClass('col-content') ? 'col' : OBJ.prop('tagName').toLowerCase()), 
		align = 'left', 
		valign = 'top',
		distribution = 'wrap',
		horizontal, vertical, 
		removes = [
			'flex-row-start-start',
			'flex-row-start-center', 
			'flex-row-start-end', 
			'flex-row-center-start',
			'flex-row-center-center', 
			'flex-row-center-end', 
			'flex-row-end-start',
			'flex-row-end-center', 
			'flex-row-end-end', 
			'flex-row-between-start',
			'flex-row-between-center', 
			'flex-row-between-end', 
			'flex-row-around-start',
			'flex-row-around-center', 
			'flex-row-around-end', 
			'flex-col-start-start', 
			'flex-col-start-center', 
			'flex-col-start-end', 
			'flex-col-start-between', 
			'flex-col-start-around', 
			'flex-col-center-start', 
			'flex-col-center-center', 
			'flex-col-center-end', 
			'flex-col-center-between', 
			'flex-col-center-around', 
			'flex-col-end-start', 
			'flex-col-end-center', 
			'flex-col-end-end', 
			'flex-col-end-between', 
			'flex-col-end-around', 
			'flex-wrap'
		]

	function getAlign(){
		//var clas = OBJ.prop('class')
		
			align = OBJ.data('align')
			valign = OBJ.data('valign')
			distribution = OBJ.data('distribution')


		setAlign()
	}

	function setAlign(){
		if(tag == 'col'){
			$.each(removes, function(i, rem){
				OBJ.removeClass(rem)
			})
			var dis = (distribution != 'col') ? 'row' : 'col', 
				a = (dis == 'row') ? align : valign, 
				b = (dis == 'col') ? align : valign, 
				wrap = distribution == 'wrap' ? ' flex-wrap' : ''
			OBJ.addClass('flex-' + dis + '-' + a + '-' + b + wrap)
		}else{
			OBJ.css({
				textAlign: align, 
				verticalAlign: valign
			})
		}
			OBJ
				.data('align', align)
				.data('valign', valign)
				.data('distribution', distribution)
			//ver(['class', OBJ.prop('class')])
		
	}

	getAlign()
	if(tag == 'col'){

		horizontal = [
				{name:'Izquierda', value:'start'}, 
				{name:'Centro', value:'center'}, 
				{name:'Derecha', value:'end'},
				{name:'Uniforme', value:'around'},
				{name:'Hacia afuera', value:'between'} 
			]
		vertical = [
				{name:'Arriba', value:'start'},
				{name:'Centro', value:'center'}, 
				{name:'Abajo', value:'end'}
			]
	}else{
		$('#distribution').hide()
		$('#align, #valign').removeClass('col-4').addClass('col-6')
		if(tag == 'table'){
			$('#valign').hide()
			$('#align').removeClass('col-6').addClass('col-12')
		}
		horizontal = [
				{name:'Izquierda', value:'left'}, 
				{name:'Centro', value:'center'}, 
				{name:'Derecha', value:'right'}
			]
		vertical = [
				{name:'Arriba', value:'top'},
				{name:'Centro', value:'center'}, 
				{name:'Abajo', value:'bottom'}
			]
	}
	var	inputs = [

			{
				box:'distribution',
				type: 'radio',
				options:[
					{name:'Fila', value: 'row'}, 
					{name:'Columna', value: 'col'} ,
					{name:'Ambos', value: 'wrap'}
				],
				label: 'Distribución:',
				name: 'dist',
				value: distribution,
				callBack: function(value, data){
					distribution = value
					setAlign()
				}
			}, 

			{
				box:'align',
				type: 'radio',
				options:horizontal,
				label: 'Horizontal:',
				name: 'hor',
				value: align,
				callBack: function(value, data){
					align = value
					setAlign()
				}
			},
			{
				box:'valign',
				type: 'radio',
				options:vertical,
				label: 'Vertical:',
				name: 'ver',
				value: valign,
				callBack: function(value, data){
					valign = value
					setAlign()
				}
			},
		]


	$('#form-tool').form({
			     inputs: inputs,
			     minimize:true
			  })

</script>