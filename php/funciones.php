<?php
require_once("sql.php");
error_reporting(1);

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
	$foto = NULL;
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

function createDir($dir){
	if(!file_exists($dir)){
		return mkdir($dir, 0777, true);
	}else{
		return false;
	}
}

function fileExists($url){

}

function getNameDir($name){
	return str_replace(' ', '_', $name);
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



function scrollBar($obj){
	return $obj.'::-webkit-scrollbar{
	 width: 7px;
			 
	}
				
	'.$obj.'::-webkit-scrollbar-button{
		width:5px;
		height: 10px;
	}
	
	'.$obj.'::-webkit-scrollbar-track{
		 border:thin solid #fff;
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		-webkit-border-radius: 1px;
		border-radius: 1px;
	}
				
	'.$obj.'::-webkit-scrollbar-thumb{
		 -webkit-box-shadow: inset 0 1px 0 rgba(255,255,225,.5),inset 1px 0 0 rgba(255,255,255,.4),inset 0 1px 2px rgba(255,255,255,.3);
		border:thin solid #fff;
		border-radius: 1px;
		-webkit-border-radius: 1px;
		background:rgba(0, 0, 0, .3);
	}';
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

function desencripter($encrypt){
	return utf8_encode(base64_decode($encrypt));
}

function cache(){
	return '?'.rand(0, 1000).'.'.rand(0, 1000).'.'.rand(0, 1000);
}

//****************************************************************************************************************************************************

function dateFormat($fecha, $formato){
	$parts = explode('/', $fecha); ///dd/mm/yyy h:m:s
	$rest = explode(' ', $parts[2]);
	$dia = $parts[0];
	$mes = $parts[1];
	$anio = $rest[0];
	$hora = $rest[1];
	$fecha = $anio.'-'.$mes.'-'.$dia.' '.$hora;
	return date_format(date_create($fecha), $formato);
	
}


function base64JsonDecode($json){
	return utf8_encode(base64_decode($json));
}


