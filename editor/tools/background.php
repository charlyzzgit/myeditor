<style>
	.sector{
		width: 20%;
		height: 300px;

	}
</style>
<div id="form-tool" class="col-12 flex-row-start-start flex-wrap">
	<div class="col-12 flex-row-center-center p-1" style="height: 50px">
		<div id="type" class="col-6"></div>
		<div id="angle" class="col-6 flex-row-start-center">
			<div class="col-2 flex-row-end-center"><b class="form-lbl mr-2">Angulo</b></div>
			<div id="deg" class="col-10 flex-row-start-center"></div>
		</div>
		<div id="shape" class="col-6"></div>
	</div>
	
	<div class="sector flex-col-start-center border p-2">
		<div id="hab-1" class="col-12 flex-row-center-center"></div>
		<div id="bg-1" class="col-12 flex-row-center-center"></div>
		<div id="deg-1" class="col-12 flex-row-center-center"></div>
	</div>
	<div class="multi sector flex-col-start-center border p-2">
		<div id="hab-2" class="col-12 flex-row-center-center"></div>
		<div id="bg-2" class="col-12 flex-row-center-center"></div>
		<div id="deg-2" class="col-12 flex-row-center-center"></div>
	</div>
	<div class="multi sector flex-col-start-center border p-2">
		<div id="hab-3" class="col-12 flex-row-center-center"></div>
		<div id="bg-3" class="col-12 flex-row-center-center"></div>
		<div id="deg-3" class="col-12 flex-row-center-center"></div>
	</div>
	<div class="multi sector flex-col-start-center border p-2">
		<div id="hab-4" class="col-12 flex-row-center-center"></div>
		<div id="bg-4" class="col-12 flex-row-center-center"></div>
		<div id="deg-4" class="col-12 flex-row-center-center"></div>
	</div>
	<div class="multi sector flex-col-start-center border p-2">
		<div id="hab-5" class="col-12 flex-row-center-center"></div>
		<div id="bg-5" class="col-12 flex-row-center-center"></div>
		<div id="deg-5" class="col-12 flex-row-center-center"></div>
	</div>
	
</div>




<script>
	'use strict'
	
	ver(['bg', OBJ.css('background').split(' repeat')[0]])
	var bg = getBackground(getStyle(OBJ, 'background')),

		inputs = [
		{
			box:'type',
			type: 'radio',
			options:[
				{name:'Sólido', value: 'none'},
				{name: 'Degradado Lineal', value: 'linear'},
				{name: 'Degradado Radial', value: 'radial'}
			],
			label: 'Tipo de Fondo:',
			name: 'bg-type',
			value: bg.gradient,
			inline:true,
			callBack: function(value, data){
				setDisplay(value)
				bg.gradient = value
				setBackground()
			}
		},

		{
			box:'deg',
			label:null,
			max:360,
			min:0,
			name: 'bg-deg',
			type: 'range',
			value:bg.deg,
			callBack: function(value, data){
				bg.deg = value
				setBackground()
			}
		},

		{
			box:'shape',
			type: 'radio',
			options:[
				{name:'Circular', value: 'circle'},
				{name: 'Elíptico', value: 'ellipse'}
			],
			label: 'Forma:',
			name: 'bg-shape',
			value: 'circle',
			inline:true,
			callBack: function(value, data){
				bg.shape = value
				setBackground()
			}
		}

	]

	function getChanels(bg){
		ver(['en chanels ', bg])
		var chanels = []
		try{
			if(exists(bg, 'gradient')){
				

				var ch = bg.split('rgb'),
					aux = [],
					result = 'rgb'
				$.each(ch, function(i, c){
					if(i != 0){
						aux.push(c)
					}
				})

				result += aux.join('rgb')
				ver(['result:', result])

				var parts = result.split('%, '),
					last = parts.length - 1
				
				parts[last] = parts[last].split('%)')[0]
				ver(['parts:', parts])
				$.each(parts, function(i, part){
					var bkg = part.split(') ')[0] + ')',
						por = part.split(') ')[1]
					chanels.push({
						bg: bkg,
						por: por,
						active: true
					})
				})
			}else{
				chanels.push({
					bg: bg,
					por: 100,
					active: true
				})
			}
			

		}catch(e){
			ver(['exception', e])
			chanels.push({
				bg: bg,
				por: 100,
				active: true
			})
		}
		ver(['chanels', chanels])
		return chanels	
		
	}

	

	function getBackground(bg) {
		ver(['getback', bg])
		var gradient = exists(bg,'gradient') ? (exists(bg, 'linear') ? 'linear' : 'radial') : 'none',
			deg = 0,
			shape = 'circle',
			chanels = [],
			length = bg.split("rgb").length-1
		switch(gradient){
			case 'none':
				chanels = getChanels(bg)
				for(var i = chanels.length; i < 5; i++){
					chanels.push({bg: 'rgba(255,255,255,1)', por: 100, active: false})
				}
			break
			case 'linear':
			
				deg = bg.split('(')[1].split(' ')[0].split('deg')[0]
				chanels = getChanels(bg)
				for(var i = chanels.length; i < 5; i++){
					chanels.push({bg: 'rgba(255,255,255,1)', por: 100, active: false})
				}
			break
			case 'radial':
				
				shape = exists(bg, 'circle') ? 'circle' : 'ellipse'
				chanels = getChanels(bg)
				ver(['canales = ', chanels])
				for(var i = chanels.length; i < 5; i++){
					chanels.push({bg: 'rgba(255,255,255,1)', por: 100, active: false})
				}
			break
		}
		
		return {
			gradient: gradient,
			deg: deg,
			shape: shape,
			chanels: chanels
		}
	}

	function setBackground(){
		var bkg = ''
		ver(['gradient', bg.gradient])
		switch(bg.gradient){
			case 'none': 
				bkg = bg.chanels[0].bg
			break
			case 'linear':
				bkg = 'linear-gradient(' + bg.deg + 'deg'
				$.each(bg.chanels, function(i, chanel){
					if(chanel.active){
						bkg += ', ' + chanel.bg + ' ' + chanel.por + '%'
					}
				})
				bkg += ')'
			break
			case 'radial':
				bkg = 'radial-gradient(' + bg.shape
				ver(['bg-chanels', bg.chanels])
				$.each(bg.chanels, function(i, chanel){
					if(chanel.active){
						bkg += ', ' + chanel.bg + ' ' + chanel.por + '%'
					}
				})
				bkg += ')'
			break
		}
		ver(['degrade antes', bkg])
		OBJ.css('background', bkg)
		ver(['degrade despues', OBJ.css('background')])
	}

	function setDisplay(gradient){

		switch(gradient){
			case 'none':
				$('#angle, #shape, .multi').hide()
			break
			case 'linear':
				$('#shape').hide()
				$('#angle, .multi').show()
			break
			case 'radial':
				$('#angle').hide()
				$('#shape, .multi').show()
			break
		}
	}

	setDisplay(bg.gradient)

	$('.sector').each(function(index){
		var n = index + 1
		inputs.push({
           box: 'hab-' + n,
           type: 'switch',
           label: 'Canal ' + n + ':',
           name:'enabled-' + n,
           onColor: 'success',
           offColor: 'danger',
           onText: 'SI',
           offText: 'NO',
           checked:bg.chanels[n - 1].active,
           data: {chanel: index + 1},
           callBack: function(value, data){
           	var dt = getJson(data),
           		ch = parseInt(dt.chanel)
				bg.chanels[ch - 1].active = value
				
				$('#bg-' + ch).fadeTo(150, value ? 1 : 0)
				$('#deg-' + ch).fadeTo(150, value ? 1 : 0)
				setBackground()
			}

         })
		inputs.push({
			box:'bg-' + n,
			type: 'color',
			label: 'Color:',
			value: bg.chanels[n - 1].bg,
			format: 'rgba',
			name: 'background-' + n,
			data: {chanel: index + 1},
			callBack: function(value, data){
				var dt = getJson(data),
           		ch = parseInt(dt.chanel)
				bg.chanels[ch - 1].bg = value
				setBackground()
			}
		})
		inputs.push({
			box:'deg-' + n,
			label:'Intensidad',
			max:100,
			min:0,
			name: 'dg-' + n,
			type: 'range',
			value:bg.chanels[n - 1].por,
			data: {chanel: index + 1},
			callBack: function(value, data){
					var dt = getJson(data),
	           		ch = parseInt(dt.chanel)
					bg.chanels[ch - 1].por = value
					setBackground()
				}
			})
	})
	
	$('#form-tool').form({
			     inputs: inputs,
			     minimize:true
			  })
	$.each(bg.chanels, function(i, chanel){
		var ch = i + 1
		$('#bg-' + ch).fadeTo(150, chanel.active ? 1 : 0).append(getPalette())
		$('#deg-' + ch).fadeTo(150, chanel.active ? 1 : 0)
	})
	

	
</script>