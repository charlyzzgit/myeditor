<style>
	.sector{
		height: 300px
	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start">
	<div class="sector col-4 flex-row-center-start border p-2">
		<div id="size" class="col-6 mt-3"></div>
	</div>
	<div class="sector col-4 flex-row-center-start border p-2">
		<div id="image" class="col-6 mt-3"></div>
	</div>
	<div class="sector col-4 flex-row-center-start border p-2">
		<div id="custom" class="col-6 mt-3"></div>
	</div>
	
</div>


<script>
	'use strict'
	var inputs = [
		{
          box: 'image',
          type: 'image',
          label: 'Click en la Imágen para cambiar',
          name: 'foto',
          size:100,
          src: OBJ.prop('src') != null ? OBJ.prop('src') : IMG + 'noimage.png',
          callBack: function(value, data){
          	 var aj = new Ajax(),
          	 	 idtema = TEMA.id,
          	 	 idelement = OBJ.prop('id').split('-')[1]
          	 aj.add('action', 'sendImage')
          	 aj.add('idtema', idtema)
          	 aj.add('idelement', idelement)
          	 aj.add('image', value)
          	 loading(true)
          	 aj.send('../php/main.php', function(data){
          	 	ver(['result image', data])
          	 	loading(false)
          	 	if(data.result == SUCCESS){
          	 		var image = data.image
          	 		OBJ.prop('src', '../img/' + getUrlImage(TEMA) + image)
          	 	}else{
          	 		swal('IMAGEN','Error al Guardar:' + data.message,'error')
          	 	}
          	 })
          }
       		
        },

        {
			box:'size',
			type: 'radio',
			options:[
				{name:'Muy Chica', value: 'img-mini'},
				{name:'Chica', value: 'img-small'},
				{name:'Mediano', value: 'img-medium'},
				{name:'Grande', value: 'img-big'},
				{name:'Full', value: 'img-full'}
			],
			label: 'Tamaño Fijo:',
			name: 'size',
			value: 'small',
			callBack: function(value, data){
				
				OBJ.removeClass('img-mini img-small img-medium img-big img-full').addClass(value)
			}
		},
		{
			box:'custom',
			type: 'spinner',
			min:1,
			max:100,
			label: 'Tamaño Personalizado:',
			name: 'custom-size',
			value: 20,
			callBack: function(value, data){
				OBJ.removeClass('img-mini img-small img-medium img-big img-full')
				OBJ.css('width', value + '%')
			}
		}
	]


$('#form-tool').form({
		inputs: inputs,
		minimize:true
})
</script>