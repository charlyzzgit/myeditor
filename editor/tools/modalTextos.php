<?php 
	require '../../php/scripts.php';
	$request = $_REQUEST;
	$box = getPost($request, 'box', NULL);
	

 ?>


 <div class="col-12 flex-col-start-center">
 	<div id="result" class="col-12 flex-row-center-center p-2">
 		<span>Texto de muestra</span>
 	</div>
 	<div id="form" class="col-12 flex-col-start-center">
	 	<div id="texto" class="col-12 flex-col-start-center"></div>
		<div id="tips" class="col-6 flex-col-start-center"></div>
	</div>
	<div class="col-10 flex-row-between-center mt-3">
		<button id="btn-apply" class="btn btn-success">Aplicar</button>
		<button id="btn-cancel" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	</div>
 </div>


 <script>
 	var options = [
 		{ name:'Encabezado 1', value: 'h1'},
 		{ name:'Encabezado 2', value: 'h2'},
 		{ name:'Encabezado 3', value: 'h3'},
 		{ name:'Encabezado 4', value: 'h4'},
 		{ name:'Encabezado 5', value: 'h5'},
 		{ name:'Encabezado 6', value: 'h6'},
		{ name:'Normal', value: 'span'},
		{ name:'Itálica', value:'i'},
		{ name:'Énfasis', value: 'em'},
		{ name:'Pequeño', value: 'small'},
		{ name:'Importante', value: 'strong'},
		{ name:'No Relevante', value: 's'},
		{ name:'Cita', value: 'cite'},
		{ name:'Cita Textual', value: 'q'},
		{ name:'Señalado', value: 'u'},
		{ name:'Código', value: 'code'},
		{ name:'SupraÍndice', value: 'sup'},
		{ name:'Subíndice', value: 'sub'},
		{ name:'Variable', value: 'var'},
		{ name:'Fecha/Hora', value: 'time'},
		{ name:'Resaltado', value: 'mark'},
		{ name:'Bloque de Código', value: 'pre'}
	],

 	box = '<?php print($box); ?>',
 	tag = 'span'

	$('#form').form({
			inputs: [
				{
					box:'texto',
					type: 'textarea',
					label: 'Prueba de Texto:',
					name: 'demo',
					value: 'Texto de muestra',
					
					callBack: function(value, data){
						$('#result').children().text(value)	
					}
				},
				{
					box:'tips',
					type: 'select',
					options: options,
					label: 'Tipos de Texto:',
					name: 'tag',
					value: 'span',
					
					callBack: function(value, data){
						var text = 	$('#result').children().text(),
							el = $('<' + value + '></' + value + '>')
							el.text(text)
						$('#result').html(el)
						tag = value
					}
				}
			],
			minimize:true
	})

 $('#btn-apply').click(function(){
 		$('#btn-cancel').trigger('click')
 		modalInsert.openModal('tools/modalInsert.php?tag=' + tag + '&box=' + box)
 })
				 	
 </script>

 <!-- <sup class"text-info">ª</sup> Jornada

 H<sub class"text-info">2</sub>O -->