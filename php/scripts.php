<?php 
require_once('sql.php');
require_once('funciones.php');

define('SUCCESS', 'OK');
error_reporting(1);


function getPost($request, $name, $default){
	return isset($request[$name]) ? $request[$name] : $default;
}

function backup(){
	setBackup('temas');
	setBackup('filas');
	setBackup('columnas');
	setBackup('estilos');
}

function restore(){
	getBackup('temas');
	getBackup('filas');
	getBackup('columnas');
	getBackup('estilos');
}

function createTema($request){
	$sql = new consulta();
	$sql->addCampo('id_docente', getPost($request, 'iddocente', NULL));
	$sql->addCampo('id_curso', getPost($request, 'idcurso', NULL));
	$sql->addCampo('id_modulo', getPost($request, 'idmodulo', NULL));
	$sql->addCampo('id_clase', getPost($request, 'idclase', NULL));
	$sql->addCampo('titulo', getPost($request, 'titulo', NULL));
	$sql->addCampo('numero', getPost($request, 'num', 0));
	$sql->insert('temas');
	if($sql->getSuccess()){
		$response = toJson(array('result' => 'OK'));
	}else{
		$response = toJson(array('result' => 'ERROR', 'message' => $sql->getError()));
	}

	return $response;
	
}



function setContent($content){
	$content = str_replace(array("\r", "\n"), '', $content); //elimina renglones en blanco (los renglones en blanco no guradan en la db y dan errores)
	return htmlentities(addslashes($content)); //permite codigo html
}



function saveColumna($col, $idfila, $tema){
	$id = $col['id'];
	$sql = new consulta();
	$sql->addCampo('id_docente', $tema['id_docente']);
	$sql->addCampo('id_curso', $tema['id_curso']);
	$sql->addCampo('id_modulo', $tema['id_modulo']);
	$sql->addCampo('id_clase', $tema['id_clase']);
	$sql->addCampo('id_tema', $tema['id']);
	$sql->addCampo('id_fila', $idfila);
	$sql->addCampo('numero', $col['numero']);
    $sql->addCampo('align', $col['align']);
    $sql->addCampo('valign', $col['valign']);
    $sql->addCampo('distribution', $col['distribution']);
    $sql->addCampo('clases', $col['clases']);
    $sql->addCampo('estilos', toJson($col['estilos']));
    $sql->addCampo('content', setContent($col['content']));
    $sql->addCampo('visible', $col['visible']);
    if($id == 0){
		$id = $sql->insert('columnas');
	}else{
		$sql->addCondicion('id', $id);
		$sql->update('columnas');
	}

	if($sql->getSuccess()){
		
		return toJson(array('result' => SUCCESS));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => 'Error en Columna: '.$sql->getError()));
	}
}

function saveFila($fila, $tema){
	$id = $fila['id'];
	$sql = new consulta();
	$sql->addCampo('id_docente', $tema['id_docente']);
	$sql->addCampo('id_curso', $tema['id_curso']);
	$sql->addCampo('id_modulo', $tema['id_modulo']);
	$sql->addCampo('id_clase', $tema['id_clase']);
	$sql->addCampo('id_tema', $tema['id']);
	$sql->addCampo('titulo', $fila['titulo']);
	$sql->addCampo('estilos_titulo', toJson($fila['estilos_titulo']));
	$sql->addCampo('clases_titulo', $fila['clases_titulo']);
	$sql->addCampo('numero', $fila['numero']);
	$sql->addCampo('columnas', $fila['columnas']);
	$sql->addCampo('clases', $fila['clases']);
	$sql->addCampo('estilos', toJson($fila['estilos']));
	if($id == 0){
		$id = $sql->insert('filas');
	}else{
		$sql->addCondicion('id', $id);
		$sql->update('filas');
	}

	if($sql->getSuccess()){
		$columnas = $fila['columns'];
		foreach ($columnas as $key => $col) {
			$save = saveColumna($col, $id, $tema);
			$success = getJson($save);
			if($success['result'] != SUCCESS){
				return $save;
		    }
			
		}
		return toJson(array('result' => SUCCESS));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => 'Error en Fila: '.$sql->getError()));
	}

	
}


function savePageTema($tema){
	
	$sql = new consulta();
	$sql->addCondicion('id', $tema['id']);
	$sql->addCampo('titulo', $tema['titulo']);
	$sql->addCampo('estilos_titulo', toJson($tema['estilos_titulo']));
	$sql->addCampo('clases_titulo', $tema['clases_titulo']);
	$sql->addCampo('clases', $tema['clases']);
	$sql->addCampo('estilos', toJson($tema['estilos']));
	$sql->update('temas');
	if($sql->getSuccess()){
		$filas = $tema['filas'];
		foreach ($filas as $key => $fila) {
			$save = saveFila($fila, $tema);
			$success = getJson($save);
			if($success['result'] != SUCCESS){
				return $save;
		    }
		}
		$d = clearFiles($tema);
		return toJson(array('result' => SUCCESS));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => 'Error en Tema: '.$sql->getError()));
	}
}



function clearFiles($tema){
	$dels = array();
	$url = 'docente-'.$tema['id_docente'].'/curso-'.$tema['id_curso'].'/modulo-'.$tema['id_modulo'].'/clase-'.$tema['id_clase'].'/tema-'.$tema['id'].'/';
	$files = getListFiles(getAllArchivos('../files/'.$url));
	$images = getListFiles(getAllArchivos('../img/'.$url));

	foreach($tema['files'] as $key => $file) {
		if($file['dir'] == 'img'){
			mark($images, $file['file']);
		}else if($file['dir'] == 'file'){
			mark($files, $file['file']);
		}
	}	
		
		
	

	foreach ($images as $key => $image) {
		//alert('image: '.toJson($image));
		if($image['del']){
			delfoto('../img/'.$url.$image['file']);
		}
		
	}
	foreach ($files as $key => $file) {
		//alert('file: '.toJson($file));
		if($file['del']){
			delfoto('../img/'.$url.$file['file']);
		}
		
	}

	return $dels;
}

function getListFiles($arch){
	$files = array();
	foreach ($arch as $key => $file) {
		$data['file'] = $file;
		$data['del'] = true;
		$files[] = $data;
	}
	return $files;
}

function mark(&$files, $file){
	for($i = 0; $i < count($files); $i++) {
		if($files[$i]['file'] == $file){
			$files[$i]['del'] = false;
			break;
		}
	}
}



function getCss($style){

	return $style != NULL ? getJson($style) : array();
}


function getTemas($idclase){
	$sql = new consulta();
	$sql->addCondicion('id_clase', $idclase);
	$res = $sql->readSql('temas');
	$temas = array();
	while($reg = getreg($res)){
		$temas[] = $reg;
	}
	
	return $temas;
}

function getTema($id){
	$sql = new consulta();
	$sql->addCondicion('id', $id);
	$tem = getreg($sql->readSql('temas'));
	$tem->filas = getFilas($tem->id);
	$tem->estilos_titulo = getCss($tem->estilos_titulo);
	$tem->estilos = getCss($tem->estilos);
	return $tem;
}

function getFilas($idtema){
	$sql = new consulta();
	$sql->addCondicion('id_tema', $idtema);
	$res = $sql->readSql('filas');
	$filas = array();
	while($reg = getreg($res)){
		$reg->columns = getColumnas($reg->id);
		$reg->estilos_titulo = getCss($reg->estilos_titulo);
		$reg->estilos = getCss($reg->estilos);
		$filas[] = $reg;
	}
	return $filas;
}

function getColumnas($idfila){
	$sql = new consulta();
	$sql->addCondicion('id_fila', $idfila);
	$sql->orderBy('numero asc');
	$res = $sql->readSql('columnas');
	$columnas = array();
	while($reg = getreg($res)){
		//$reg->elements = getElements($reg->id);
		$reg->estilos = getCss($reg->estilos);
		$columnas[] = $reg;
	}
	return $columnas;
}





function deleteFila($id){
	//antes borrar imagenes y archivos asociados
	$sql = new consulta();
	$sql->addCondicion('id_fila', $id);
	$sql->delete('elements');

	if($sql->getSuccess()){
		$sql = new consulta();
		$sql->addCondicion('id_fila', $id);
		$sql->delete('columnas');
		if($sql->getSuccess()){
			$sql = new consulta();
			$sql->addCondicion('id', $id);
			$sql->delete('filas');

			if($sql->getSuccess()){
				return toJson(array('result' => SUCCESS));
			}else{
				return toJson(array('result' => 'ERROR', 'message' => $sql->getError()));
			}
		}else{
			return toJson(array('result' => 'ERROR', 'message' => $sql->getError()));
		}
	}else{
		return toJson(array('result' => 'ERROR', 'message' => $sql->getError()));
	}

	

	
}




function getOldName($url, $sep){
	$a = explode($sep, $url);
	$b = explode('.', $a[1]);
	return $sep.$b[0];
}


function saveImage($request, $files){
	$idtema = getPost($request, 'idtema', 0);
	//$idelement = getPost($request, 'idelement', 0);
	$file = getPost($files, 'image', NULL);
	//$element = getElement($idelement);
	$tema = getTema($idtema);
	$dir = '../img/docente-'.$tema->id_docente.'/curso-'.$tema->id_curso.'/modulo-'.$tema->id_modulo.'/clase-'.$tema->id_clase.'/tema-'.$tema->id.'/';
	$name = 'image-'.date('Y-m-d').'_'.date('H-i-s');
	createDir($dir);
	$img = saveFile($dir, $file, $name);
	if($img != NULL){
		return toJson(array('result' => SUCCESS, 'image' => $img));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => 'Error al Guardar Archivo'));
	}
	
}

function saveArchivo($request, $files){
	$idtema = getPost($request, 'idtema', 0);
	$idelement = getPost($request, 'idelement', 0);
	$file = getPost($files, 'file', NULL);
	$element = getElement($idelement);
	$tema = getTema($idtema);
	$dir = '../files/docente-'.$tema->id_docente.'/curso-'.$tema->id_curso.'/modulo-'.$tema->id_modulo.'/clase-'.$tema->id_clase.'/tema-'.$tema->id.'/';
	$name = $element != NULL ? getOldName($element->content, 'file') : 'file-'.date('Y-m-d').'_'.date('H-i-s');
	createDir($dir);
	$arch = saveFile($dir, $file, $name);
	if($arch != NULL){
		return toJson(array('result' => SUCCESS, 'file' => $arch));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => 'Error al Guardar Archivo'));
	}
	
}


function saveEstilo($request){
	$sql = new consulta();
	$id = getPost($request, 'idestilo', 0);
	$sql->addCampo('estilos', getPost($request, 'estilos', 0));
	$sql->addCampo('important', getPost($request, 'important', 0));

	if($id == 0){
		$sql->addCampo('id_docente', getPost($request, 'iddocente', 0));
		$sql->addCampo('name', getPost($request, 'name', 0));
		$id = $sql->insert('estilos');
	}else{
		$sql->addCondicion('id', $id);
		$sql->update('estilos');
	}

	if($sql->getSuccess()){
		return toJson(array('result' => SUCCESS, 'id' => $id, 'estilos' => getEstilos(getPost($request, 'iddocente', 0))));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => $sql->getError()));
	}
}

function deleteEstilo($request){
	$id = getPost($request, 'idestilo', 0);
	$sql = new consulta();
	$sql->addCondicion('id', $id);
	$sql->delete('estilos');
	if($sql->getSuccess()){
		return toJson(array('result' => SUCCESS));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => $sql->getError()));
	}
}

function getEstilos($iddocente){
	$sql = new consulta();
	$sql->addCondicion('id_docente', $iddocente);
	$sql->orderBy('name asc');
	$res = $sql->readSql('estilos');
	$estilos = array();
	while($reg = getreg($res)){
		$reg->estilos = getCss($reg->estilos);
		$estilos[] = $reg;
	}
	return $estilos;
}


function toCss($name){
	$alfa = array(
		'A',
		'B',
		'C',
		'D',
		'E',
		'F',
		'G',
		'H',
		'I',
		'J',
		'K',
		'L',
		'M',
		'N',
		'O',
		'P',
		'Q',
		'R',
		'S',
		'T',
		'U',
		'V',
		'W',
		'X',
		'Y',
		'Z'
	);

	$result = array(
		'-a',
		'-b',
		'-c',
		'-d',
		'-e',
		'-f',
		'-g',
		'-h',
		'-i',
		'-j',
		'-k',
		'-l',
		'-m',
		'-n',
		'-o',
		'-p',
		'-q',
		'-r',
		'-s',
		'-t',
		'-u',
		'-v',
		'-w',
		'-x',
		'-y',
		'-z'
	);

	return str_replace($alfa, $result, $name);
}

function getFontFamily($font){
	$fonts = array(
            'Verdana', 
            'Geneva', 
            'Sans-serif',
            'Georgia', 
            'Times New Roman', 
            'Times',
            'Serif',
            'Courier New',
            'Courier', 
            'Monospace',
            'Helvetica', 
            'Tahoma',
            'Trebuchet MS', 
            'Arial', 
            'Arial Black', 
            'Gadget',
            'Palatino Linotype', 
            'Book Antiqua', 
            'Palatino',
            'Lucida Sans Unicode', 
            'Lucida Grande',
            'MS Serif', 
            'New York',
            'Lucida Console', 
            'Monaco',
            'Comic Sans MS', 
            'Cursive',
            'Rockwell Extra Bold'
	);

	sort($fonts);

	for($i = 0; $i < count($fonts); $i++){
		if($i == $font){
			return $fonts[$i];
		}
	}

	return 'Arial';
}

 ?>