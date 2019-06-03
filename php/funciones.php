<?php
//require_once("sql.php");
error_reporting(1);
define('ORDERTB', 'pts desc, d desc, gf desc, gc asc, g desc, pen desc, n asc');
function formatocod($val){
	if($val < 10){
		$cad = "0000".$val;
	}else if($val >= 10 && $val < 100){
		$cad = "000".$val;
	}else if($val >= 100 && $val < 1000){
		$cad = "00".$val;
	}else if($val >= 1000 && $val < 10000){
		$cad = "0".$val;
	}else{
		$cad = $val;
	}
	return $cad;
}


function color($col){
	$c = 0;
		$color[$c][1]= "rojo";
		$color[$c][2]= "#FF0000";
		$color[$c++][3]= "#F00";
		$color[$c][1]= "azul";
		$color[$c][2]= "#0000FF";
		$color[$c++][3]= "#00F";
		$color[$c][1]= "verde";
		$color[$c][2]= "#006600";
		$color[$c++][3]= "#060";
		$color[$c][1]= "amarillo";
		$color[$c][2]= "#F9B528";
		$color[$c++][3]= "#EBA80C";
		$color[$c][1]= "naranja";
		$color[$c][2]= "#FF4A1E";
		$color[$c++][3]= "#F60";
		$color[$c][1]= "celeste";
		$color[$c][2]= "#0066FF";
		$color[$c++][3]= "#06F";
		$color[$c][1]= "verdeclaro";
		$color[$c][2]= "#669900";
		$color[$c++][3]= "#0C0";
		$color[$c][1]= "crema";
		$color[$c][2]= "#FFFF99";
		$color[$c++][3]= "#FF9";
		$color[$c][1]= "rosa";
		$color[$c][2]= "#FF3399";
		$color[$c++][3]= "#F39";
		$color[$c][1]= "azuloscuro";
		$color[$c][2]= "#000066";
		$color[$c++][3]= "#006";
		$color[$c][1]= "verdeoscuro";
		$color[$c][2]= "#002800";
		$color[$c++][3]= "#030";
		$color[$c][1]= "violeta";
		$color[$c][2]= "#660099";
		$color[$c++][3]= "#609";
		$color[$c][1]= "marron";
		$color[$c][2]= "#572C00";
		$color[$c++][3]= "#630";
		$color[$c][1]= "negro";
		$color[$c][2]= "#000000";
		$color[$c++][3]= "#000";
		$color[$c][1]= "blanco";
		$color[$c][2]= "#FFFFFF";
		$color[$c++][3]= "#FFF";
		$color[$c][1]= "gris";
		$color[$c][2]= "#666666";
		$color[$c++][3]= "#666";
		$color[$c][1]= "marronclaro";
		$color[$c][2]= "#BF6000";
		$color[$c++][3]= "#AF7907";
		$color[$c][1]= "cielo";
		$color[$c][2]= "#C1EBFF";
		$color[$c++][3]= "#B7FFFF";
		$color[$c][1]= "morado";
		$color[$c][2]= "#302903";
		$color[$c++][3]= "#330";
		$color[$c][1]= "grana";
		$color[$c][2]= "#770029";
		$color[$c++][3]= "#8D0535";
		$color[$c][1]= "marronoscuro";
		$color[$c][2]= "#2D0000";
		$color[$c++][3]= "#2D0000";
		$color[$c][1]= "piel";
		$color[$c][2]= "#FC9";
		$color[$c++][3]= "#FC9";
	for($i = 0; $i < $c; $i++){
		if($col == $color[$i][1]){
			$r = $color[$i][2];
			break;
		}
	}
	return $r;
	
}

function stylcolor($col){
	$c = 0;
	$r = "";
		$color[$c][1]= "rojo";
		$color[$c][2]= "#FF0000";
		$color[$c++][3]= "#F00";
		$color[$c][1]= "azul";
		$color[$c][2]= "#0000FF";
		$color[$c++][3]= "#00F";
		$color[$c][1]= "verde";
		$color[$c][2]= "#006600";
		$color[$c++][3]= "#060";
		$color[$c][1]= "amarillo";
		$color[$c][2]= "#F9B528";
		$color[$c++][3]= "#EBA80C";
		$color[$c][1]= "naranja";
		$color[$c][2]= "#FF4A1E";
		$color[$c++][3]= "#F60";
		$color[$c][1]= "celeste";
		$color[$c][2]= "#0066FF";
		$color[$c++][3]= "#06F";
		$color[$c][1]= "verdeclaro";
		$color[$c][2]= "#669900";
		$color[$c++][3]= "#6C0";
		$color[$c][1]= "crema";
		$color[$c][2]= "#FFFF99";
		$color[$c++][3]= "#FF9";
		$color[$c][1]= "rosa";
		$color[$c][2]= "#FF3399";
		$color[$c++][3]= "#F39";
		$color[$c][1]= "azuloscuro";
		$color[$c][2]= "#000066";
		$color[$c++][3]= "#006";
		$color[$c][1]= "verdeoscuro";
		$color[$c][2]= "#002800";
		$color[$c++][3]= "#030";
		$color[$c][1]= "violeta";
		$color[$c][2]= "#660099";
		$color[$c++][3]= "#609";
		$color[$c][1]= "marron";
		$color[$c][2]= "#572C00";
		$color[$c++][3]= "#630";
		$color[$c][1]= "negro";
		$color[$c][2]= "#000000";
		$color[$c++][3]= "#000";
		$color[$c][1]= "blanco";
		$color[$c][2]= "#FFFFFF";
		$color[$c++][3]= "#FFF";
		$color[$c][1]= "gris";
		$color[$c][2]= "#666666";
		$color[$c++][3]= "#666";
		$color[$c][1]= "marronclaro";
		$color[$c][2]= "#BF6000";
		$color[$c++][3]= "#AF7907";
		$color[$c][1]= "cielo";
		$color[$c][2]= "#C1EBFF";
		$color[$c++][3]= "#B7FFFF";
		$color[$c][1]= "morado";
		$color[$c][2]= "#302903";
		$color[$c++][3]= "#330";
		$color[$c][1]= "grana";
		$color[$c][2]= "#770029";
		$color[$c++][3]= "#8D0535";
		$color[$c][1]= "marronoscuro";
		$color[$c][2]= "#2D0000";
		$color[$c++][3]= "#2D0000";
		$color[$c][1]= "piel";
		$color[$c][2]= "#FC9";
		$color[$c++][3]= "#FC9";
	for($i = 0; $i < $c; $i++){
		if($col == $color[$i][1]){
			$r = $color[$i][3];
			break;
		}
	}
	return $r;
	
}

function stylrgb($col){
	$c = 0;
	$r = "";
		$color[$c][1]= "rojo";
		$color[$c][2]= "#FF0000";
		$color[$c++][3]= "255,0,0";
		$color[$c][1]= "azul";
		$color[$c][2]= "#0000FF";
		$color[$c++][3]= "0,0,255";
		$color[$c][1]= "verde";
		$color[$c][2]= "#006600";
		$color[$c++][3]= "0,102,0";
		$color[$c][1]= "amarillo";
		$color[$c][2]= "#F9B528";
		$color[$c++][3]= "245,184,0";
		$color[$c][1]= "naranja";
		$color[$c][2]= "#FF4A1E";
		$color[$c++][3]= "255,102,0";
		$color[$c][1]= "celeste";
		$color[$c][2]= "#0066FF";
		$color[$c++][3]= "0,102,255";
		$color[$c][1]= "verdeclaro";
		$color[$c][2]= "#669900";
		$color[$c++][3]= "102,204,0";
		$color[$c][1]= "crema";
		$color[$c][2]= "#FFFF99";
		$color[$c++][3]= "255,255,153";
		$color[$c][1]= "rosa";
		$color[$c][2]= "#FF3399";
		$color[$c++][3]= "255,102,153";
		$color[$c][1]= "azuloscuro";
		$color[$c][2]= "#000066";
		$color[$c++][3]= "0,0,102";
		$color[$c][1]= "verdeoscuro";
		$color[$c][2]= "#002800";
		$color[$c++][3]= "0,51,0";
		$color[$c][1]= "violeta";
		$color[$c][2]= "#660099";
		$color[$c++][3]= "102,0,153";
		$color[$c][1]= "marron";
		$color[$c][2]= "#572C00";
		$color[$c++][3]= "102,51,0";
		$color[$c][1]= "negro";
		$color[$c][2]= "#000000";
		$color[$c++][3]= "0,0,0";
		$color[$c][1]= "blanco";
		$color[$c][2]= "#FFFFFF";
		$color[$c++][3]= "255,255,255";
		$color[$c][1]= "gris";
		$color[$c][2]= "#666666";
		$color[$c++][3]= "153,153,153";
		$color[$c][1]= "marronclaro";
		$color[$c][2]= "#BF6000";
		$color[$c++][3]= "204,153,0";
		$color[$c][1]= "cielo";
		$color[$c][2]= "#C1EBFF";
		$color[$c++][3]= "204,255,255";
		$color[$c][1]= "morado";
		$color[$c][2]= "#302903";
		$color[$c++][3]= "102,102,0";
		$color[$c][1]= "grana";
		$color[$c][2]= "#770029";
		$color[$c++][3]= "102,0,51";
		$color[$c][1]= "marronoscuro";
		$color[$c][2]= "#2D0000";
		$color[$c++][3]= "45,0,0";
		$color[$c][1]= "piel";
		$color[$c][2]= "#FC9";
		$color[$c++][3]= "252,9,NaN";
	for($i = 0; $i < $c; $i++){
		if($col == $color[$i][1]){
			$r = $color[$i][3];
			break;
		}
	}
	return $r;
	
}


function getChanels(){
	$c = 0;
		$color[$c][1]= "rojo";
		$color[$c][2]= "#FF0000";
		$color[$c++][3]= "255,0,0";
		$color[$c][1]= "azul";
		$color[$c][2]= "#0000FF";
		$color[$c++][3]= "0,0,255";
		$color[$c][1]= "verde";
		$color[$c][2]= "#006600";
		$color[$c++][3]= "0,102,0";
		$color[$c][1]= "amarillo";
		$color[$c][2]= "#F9B528";
		$color[$c++][3]= "245,184,0";
		$color[$c][1]= "naranja";
		$color[$c][2]= "#FF4A1E";
		$color[$c++][3]= "255,102,0";
		$color[$c][1]= "celeste";
		$color[$c][2]= "#0066FF";
		$color[$c++][3]= "0,102,255";
		$color[$c][1]= "verdeclaro";
		$color[$c][2]= "#669900";
		$color[$c++][3]= "102,204,0";
		$color[$c][1]= "crema";
		$color[$c][2]= "#FFFF99";
		$color[$c++][3]= "255,255,153";
		$color[$c][1]= "rosa";
		$color[$c][2]= "#FF3399";
		$color[$c++][3]= "255,102,153";
		$color[$c][1]= "azuloscuro";
		$color[$c][2]= "#000066";
		$color[$c++][3]= "0,0,102";
		$color[$c][1]= "verdeoscuro";
		$color[$c][2]= "#002800";
		$color[$c++][3]= "0,51,0";
		$color[$c][1]= "violeta";
		$color[$c][2]= "#660099";
		$color[$c++][3]= "102,0,153";
		$color[$c][1]= "marron";
		$color[$c][2]= "#572C00";
		$color[$c++][3]= "102,51,0";
		$color[$c][1]= "negro";
		$color[$c][2]= "#000000";
		$color[$c++][3]= "0,0,0";
		$color[$c][1]= "blanco";
		$color[$c][2]= "#FFFFFF";
		$color[$c++][3]= "255,255,255";
		$color[$c][1]= "gris";
		$color[$c][2]= "#666666";
		$color[$c++][3]= "153,153,153";
		$color[$c][1]= "marronclaro";
		$color[$c][2]= "#BF6000";
		$color[$c++][3]= "204,153,0";
		$color[$c][1]= "cielo";
		$color[$c][2]= "#C1EBFF";
		$color[$c++][3]= "204,255,255";
		$color[$c][1]= "morado";
		$color[$c][2]= "#302903";
		$color[$c++][3]= "102,102,0";
		$color[$c][1]= "grana";
		$color[$c][2]= "#770029";
		$color[$c++][3]= "102,0,51";
		$color[$c][1]= "marronoscuro";
		$color[$c][2]= "#2D0000";
		$color[$c++][3]= "45,0,0";
		return $color;
}
	
	function paleta(){
		$c = 0;
		$color[$c][1]= "rojo";
		$color[$c][2]= "#FF0000";
		$color[$c++][3]= "#F00";
		$color[$c][1]= "azul";
		$color[$c][2]= "#0000FF";
		$color[$c++][3]= "#00F";
		$color[$c][1]= "verde";
		$color[$c][2]= "#006600";
		$color[$c++][3]= "#060";
		$color[$c][1]= "amarillo";
		$color[$c][2]= "#F9B528";
		$color[$c++][3]= "#EBA80C";
		$color[$c][1]= "naranja";
		$color[$c][2]= "#FF4A1E";
		$color[$c++][3]= "#F60";
		$color[$c][1]= "celeste";
		$color[$c][2]= "#0066FF";
		$color[$c++][3]= "#06F";
		$color[$c][1]= "verdeclaro";
		$color[$c][2]= "#669900";
		$color[$c++][3]= "#6C0";
		$color[$c][1]= "crema";
		$color[$c][2]= "#FFFF99";
		$color[$c++][3]= "#FF9";
		$color[$c][1]= "rosa";
		$color[$c][2]= "#FF3399";
		$color[$c++][3]= "#F39";
		$color[$c][1]= "azuloscuro";
		$color[$c][2]= "#000066";
		$color[$c++][3]= "#006";
		$color[$c][1]= "verdeoscuro";
		$color[$c][2]= "#002800";
		$color[$c++][3]= "#030";
		$color[$c][1]= "violeta";
		$color[$c][2]= "#660099";
		$color[$c++][3]= "#609";
		$color[$c][1]= "marron";
		$color[$c][2]= "#572C00";
		$color[$c++][3]= "#630";
		$color[$c][1]= "negro";
		$color[$c][2]= "#000000";
		$color[$c++][3]= "#000";
		$color[$c][1]= "blanco";
		$color[$c][2]= "#FFFFFF";
		$color[$c++][3]= "#FFF";
		$color[$c][1]= "gris";
		$color[$c][2]= "#666666";
		$color[$c++][3]= "#666";
		$color[$c][1]= "marronclaro";
		$color[$c][2]= "#BF6000";
		$color[$c++][3]= "#AF7907";
		$color[$c][1]= "cielo";
		$color[$c][2]= "#C1EBFF";
		$color[$c++][3]= "#B7FFFF";
		$color[$c][1]= "morado";
		$color[$c][2]= "#302903";
		$color[$c++][3]= "#330";
		$color[$c][1]= "grana";
		$color[$c][2]= "#770029";
		$color[$c++][3]= "#8D0535";
		$color[$c][1]= "marronoscuro";
		$color[$c][2]= "#2D0000";
		$color[$c++][3]= "#2D0000";
		$color[$c][1]= "piel";
		$color[$c][2]= "#FC9";
		$color[$c++][3]= "#FC9";
		
		return $color;
	}
	
	






function php_html($texto){
   $texto = htmlentities($texto, ENT_NOQUOTES, 'UTF-8'); // Convertir caracteres especiales a entidades
   $texto = htmlspecialchars_decode($texto, ENT_NOQUOTES); // Dejar <, & y > como estaban
   return $texto;
 }
 



function space($h){
	$sep = "";
	for($i = 0; $i < $h; $i++){
		$sep.= " \x1F ";
	}
	return $sep;
}


function newfoto($directorio, $file, $foto){
	
	if($file["size"]!= 0){
		if($foto != ''){
			if(file_exists($directorio.$foto)){
					delfoto($directorio.$foto);
			}
		}
			$foto = $file["name"];
			$extension = explode(".", $foto);
			$foto = rand(0, 9).rand(100, 9999).rand(100, 9999).".".$extension[1];//esto es para subir fotos
			copy($file["tmp_name"], $directorio.$foto);//idem
			
	}
	return $foto;
}




function saveFile($directorio, $file, $name){
	$ext = array(
		'.png',
		'.jpg',
		'.gif',
		'.bmp',
		'.doc',
		'.docx',
		'.ppt',
		'.pptx',
		'.txt',
		'.pdf'
	);
	if($file["size"]!= 0){
		for($i = 0; $i < count($ext); $i++){
			if(file_exists($directorio.$name.$ext[$i])){
				delfoto($directorio.$name.$ext[$i]);
				break;
			}
		}
		$foto = $file["name"];
		$extension = explode(".", $foto);
		$foto = $name.".".$extension[1];//esto es para subir fotos
		copy($file["tmp_name"], $directorio.$foto);//idem
			
	}
	return $foto;
}

function setfoto($directorio, $file, $foto){
	
	if($file["size"]!= 0){
		  	//$directorio = "../fotos/";
			$foto = $file["name"];
			$extension = explode(".", $foto);
			$foto = 'vos.'.$extension[1];//esto es para subir fotos
			copy($file["tmp_name"], $directorio.$foto);//idem
			
	}
	return $foto;
}

function delfoto($dir){
	if(file_exists($dir)){ 
 		unlink($dir);
	}
}

function mover($desde, $dir_destino){
	$img = explode('/', $desde);
	$foto = $img[count($img) - 1];
	$extension = explode(".", $foto);
	$foto = rand(0, 9).rand(100, 9999).rand(100, 9999).".".$extension[1];//esto es para subir fotos
	copy($desde, $dir_destino.$foto);//idem
	return $foto;
}


function vaciar($url){
	/*$files = glob($url.'*'); 
	foreach($files as $file){ 
	  if(is_file($file))
		unlink($file); 
	}*/
	
	$dir = $url; 
	$handle = opendir($dir); 
	while($file = readdir($handle)){   
		if (is_file($dir.$file)){ 
			unlink($dir.$file); 
		}
	} 
}

function vaciarTabla($base, $tabla){
	$sql = new consulta();
	$sql->delete($tabla);
}


function alert($cad){
	echo '<br>'.$cad.'</br>';
}





function rotacion($x_0, $y_0, $angulo){
	return '-ms-transform: rotate('.$angulo.'deg);
  -webkit-transform: rotate('.$angulo.'deg);
  -moz-transform: rotate('.$angulo.'deg);
  -o-transform: rotate('.$angulo.'deg);
  transform: rotate('.$angulo.'deg);

  -ms-transform-origin: '.$x_0.' '.$y_0.';
  -webkit-transform-origin: '.$x_0.' '.$y_0.';
  -moz-transform-origin: '.$x_0.' '.$y_0.';
  -o-transform-origin: '.$x_0.' '.$y_0.';
  transform-origin: '.$x_0.' '.$y_0.';';
}

function xcolumnas($c){
	return '-moz-column-count:'.$c.';
  -webkit-column-count:'.$c.';
  column-count:'.$c.';';
}

function anchoColumnas($w){
	return '-moz-column-width:'.$w.';
  -webkit-column-width:'.$w.';
  column-width:'.$w.';';
	
}

function columnas($c, $w, $sep, $bordeancho, $bordestyle, $bordecolor){
	$col = '-moz-column-count:'.$c.';
  -webkit-column-count:'.$c.';
  column-count:'.$c.';';
  $col.='-moz-column-width:'.$w.';
  -webkit-column-width:'.$w.';
  column-width:'.$w.';';
  $col.= '-moz-column-gap:'.$sep.';
  -webkit-column-gap:'.$sep.';
  column-gap:'.$sep.';';
  
  $col.= '-moz-column-rule: '.$bordeancho.' '.$bordestyle.' '.$bordecolor.';
  -webkit-column-rule: '.$bordeancho.' '.$bordestyle.' '.$bordecolor.';
  column-rule: '.$bordeancho.' '.$bordestyle.' '.$bordecolor.';';
  
  return $col;
  
}



function escalar($x, $y, $px, $py){
	return '-ms-transform: scale('.$x.', '.$y.');
  -webkit-transform: scale('.$x.', '.$y.');
  -moz-transform: scale('.$x.', '.$y.');
  -o-transform: scale('.$x.', '.$y.');
  transform: scale('.$x.', '.$y.');

  -ms-transform-origin: '.$px.' '.$py.';
  -webkit-transform-origin: '.$px.' '.$py.';
  -moz-transform-origin: '.$px.' '.$py.';
  -o-transform-origin: '.$px.' '.$py.';
  transform-origin: '.$px.' '.$py.';';
}

function trasladar($x, $y){
	return '-ms-transform: translate('.$x.', '.$y.');
  -webkit-transform: translate('.$x.', '.$y.');
  -moz-transform: translate('.$x.', '.$y.');
  -o-transform: translate('.$x.', '.$y.');
  transform: translate('.$x.', '.$y.');';
}

/*function transition($propiedad, $tiempo, $ease){
	return 'transition:'.$propiedad.' '.$tiempo.'s '.$ease.';
  -moz-transition:'.$propiedad.' '.$tiempo.'s '.$ease.';
  -ms-transition:'.$propiedad.' '.$tiempo.'s '.$ease.';
  -webkit-transition:'.$propiedad.' '.$tiempo.'s '.$ease.';
  -o-transition:'.$propiedad.' '.$tiempo.'s '.$ease.'';
}*/

function transition($propiedad, $duracion, $ease, $wait){
	return '-moz-transition-property: '.$propiedad.';
  -moz-transition-duration: '.$duracion.'s;
  -moz-transition-timing-function: '.$ease.';
  -moz-transition-delay: '.$wait.'s;
 
  -ms-transition-property: '.$propiedad.';
  -ms-transition-duration: '.$duracion.'s;
  -ms-transition-timing-function: '.$ease.';
  -ms-transition-delay: '.$wait.'s;
  -webkit-transition-property: '.$propiedad.';
  -webkit-transition-duration: '.$duracion.'s;
  -webkit-transition-timing-function: '.$ease.';
  -webkit-transition-delay: '.$wait.'s;
 
  -o-transition-property: '.$propiedad.';
  -o-transition-duration: '.$duracion.'s;
  -o-transition-timing-function: '.$ease.';
  -o-transition-delay: '.$wait.'s';
  
}


function addAnimacion($animacion, $duracion,  $veces, $direction, $ease, $delay, $for_back_wards, $pausa){
	$p = 'running';
	if($pausa){
		$p = 'paused';
	}
	return '-moz-animation-name: '.$animacion.';
  -moz-animation-duration: '.$duracion.'s;
  -moz-animation-iteration-count: '.$veces.';
  -moz-animation-direction: '.$direction.';
  -moz-animation-timing-function: '.$ease.';
  -moz-animation-delay: '.$delay.'s;
  -moz-animation-play-state:'.$p.';
  -moz-animation-fill-mode: '.$for_back_wards.';
  -webkit-animation-name: '.$animacion.';
  -webkit-animation-duration: '.$duracion.'s;
  -webkit-animation-iteration-count: '.$veces.';
  -webkit-animation-direction: '.$direction.';
  -webkit-animation-timing-function: '.$ease.';
  -webkit-animation-delay: '.$delay.'s;
   -webkit-animation-play-state:'.$p.';
   -webkit-animation-fill-mode: '.$for_back_wards.';
  -o-animation-name: '.$animacion.';
  -o-animation-duration: '.$duracion.'s;
  -o-animation-iteration-count: '.$veces.';
  -o-animation-direction: '.$direction.';
  -o-animation-timing-function: '.$ease.';
  -o-animation-delay: '.$delay.'s;
   -o-animation-play-state:'.$p.';
   -o-animation-fill-mode: '.$for_back_wards.';
   -ms-animation-name: '.$animacion.';
  -ms-animation-duration: '.$duracion.'s;
  -ms-animation-iteration-count: '.$veces.';
  -ms-animation-direction: '.$direction.';
  -ms-animation-timing-function: '.$ease.';
  -ms-animation-delay: '.$delay.'s;
   -ms-animation-play-state:'.$p.';
   -ms-animation-fill-mode: '.$for_back_wards;
  

}

function keyFrames($animacion, $propiedad_inicio, $propiedad_fin){
	
return '@-moz-keyframes '.$animacion.' {
  from {
    '.$propiedad_inicio.';
   
  }
  to {
    '.$propiedad_fin.'; 
    
  }
}

@-webkit-keyframes '.$animacion.' {
  from {
    '.$propiedad_inicio.';
   
  }
  to {
    '.$propiedad_fin.'; 
    
  }
}

@-ms-keyframes '.$animacion.' {
  from {
    '.$propiedad_inicio.';
    
  }
  to {
    '.$propiedad_fin.'; 
    
  }
}


@-o-keyframes '.$animacion.' {
  from {
    '.$propiedad_inicio.';
    
  }
  to {
    '.$propiedad_fin.'; 
    
  }
}';
}


function textBorder($col, $size){
	return '-webkit-text-stroke-width:'.$size.'px;
	-webkit-text-stroke-color:'.stylcolor($col).';
	-moz-text-stroke-width:'.$size.'px;
	-moz-text-stroke-color:'.stylcolor($col).';
	-ms-text-stroke-width:'.$size.'px;
	-ms-text-stroke-color:'.stylcolor($col).';
	-o-text-stroke-width:'.$size.'px;
	-o-text-stroke-color:'.stylcolor($col).';';
}


function readTxt($archivo_txt){
	$fp = fopen($archivo_txt, "r");
	$v = array();
	while(!feof($fp)) {
	$linea = fgets($fp);
	//echo $linea . "<br />";
	$v[] = $linea;
	}
	fclose($fp);
	return $v;
}


function getBack($tipo){
	return 'background-position:center; background-repeat:no-repeat !important; background-size:'.$tipo.'; background-image:none;';
}




function getArchivos($dir, $ext){
	$i = 0;
	$v = array();
	$directorio=opendir($dir); 
	while ($archivo = readdir($directorio)){
		if(esFormato($archivo, $ext)){
		 $v[$i++] = $archivo;
		}
	}
	
	closedir($directorio);
	
	natcasesort($v); //esto ordena x nombre
	return $v;
}

function esFormato($a, $extension){
	$r = false;
	$formato = explode('.', $extension);
	$s =  explode('.', $a);
	$ext = end($s);
	if($ext != ''){
		for($i = 0; $i < count($formato); $i++){
			if($ext == $formato[$i]){
				$r = true;
				break;
			}
		}
	}
	return $r;
}

function filterSize($v, $size){
	$r = array();
	for($i = 0; $i < count($v); $i++){
		if(strpos($v[$i], $size) !== false){
			$r[] = $v[$i];
		}
	}
	return $r;
}

function cutExtension($arch){
	$v = array();
	$u = array();
	$v = explode('.',  $arch);
	$c = '';
	for($i = 0; $i < count($v) - 1; $i++){
		$u[$i] = $v[$i];
	}
	return implode('.', $u);
}


function getImagen($url, $name){
	$v = array();
	$r = '';
	$v = getArchivos($url);
	if(count($v) > 0){
		for($i = 0; $i < count($v); $i++){
			if(cutExtension($v[$i]) == $name){
				$r = $v[$i];
				break;
			}
		}
	}
	return $r;
	
}






function toJson($reg){
	return json_encode($reg);
}


function getJson($json){
	if(get_magic_quotes_gpc()){
		$d = stripslashes($json);
	}else{
		$d = $json;
	}
	return json_decode($d,true);
}

function decode($reg){
	return array_map('html_entity_decode', $reg);
}

function cache(){
	return '?'.rand(0, 1000).'.'.rand(0, 1000).'.'.rand(0, 1000);
}

//****************************************************************************************************************************************************


