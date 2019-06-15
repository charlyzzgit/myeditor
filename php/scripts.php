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
	setBackup('elements');
}

function restore(){
	getBackup('temas');
	getBackup('filas');
	getBackup('columnas');
	getBackup('elements');
}

function createTema(){
	$sql = new consulta();
	$sql->addCampo('titulo', 'Tema');
	$sql->addCampo('numero', 1);
	$sql->insert('temas');
	if($sql->getSuccess()){
		$response = toJson(array('result' => 'OK'));
	}else{
		$response = toJson(array('result' => 'ERROR', 'message' => $sql->getError()));
	}

	return $response;
	
}

function getTable($table, $idfila, $idcol, $tema){

	for($i = 0; $i < count($table); $i++){
		for($j = 0; $j < count($table[$i]['cells']); $j++){
			for($k = 0; $k < count($table[$i]['cells'][$j]['elements']); $k++){
				$el = $table[$i]['cells'][$j]['elements'][$k];
				$save = saveElement($el, $idfila, $idcol, $tema);
				$e = getJson($save);
				$table[$i]['cells'][$j]['elements'][$k] = $e['id'];
			}
		}
	}
	
	// foreach ($table as $key => $tr){
	// 	$cells = $tr['cells'];
	// 	foreach ($cells as $key1 => $cell){
	// 		$cell['ides'] = array();
	// 		$elements = $cell['elements'];
	// 		foreach ($elements as $key2 => $el){ 
	// 			//$save = saveElement($el, $idfila, $idcol, $tema);
	// 			$e = getJson($save);
	// 			$cell['ides'][] = $e['id'];
	// 		}
	// 	}
	// }
	return $table;
}

function setContent($content){
	$content = str_replace(array("\r", "\n"), '', $content); //elimina renglones en blanco (los renglones en blanco no guradan en la db y dan errores)
	return htmlentities(addslashes($content)); //permite codigo html
}

function saveElement($el, $idfila, $idcol, $tema){
	$table = $el['table']; //getTable($el['table'], $idfila, $idcol, $tema);
	$id = $el['id'];
	$sql = new consulta();
	$sql->addCampo('id_docente', $tema['id_docente']);
	$sql->addCampo('id_curso', $tema['id_curso']);
	$sql->addCampo('id_modulo', $tema['id_modulo']);
	$sql->addCampo('id_clase', $tema['id_clase']);
	$sql->addCampo('id_tema', $tema['id']);
	$sql->addCampo('id_fila', $idfila);
	$sql->addCampo('id_columna', $idcol);
	$sql->addCampo('numero', $el['numero']);
    $sql->addCampo('clases', $el['clases']);
    $sql->addCampo('estilos', toJson($el['estilos']));
    $sql->addCampo('tag', $el['tag']);
    $sql->addCampo('content', (count($table) != 0 ? toJson($table) : ( $el['tag'] == 'UL' ? toJson($el['content']) : setContent($el['content']))));
    $sql->addCampo('url', $el['url']);
    $sql->addCampo('link', $el['link']);
    if($id == 0){
		$id = $sql->insert('elements');
	}else{
		$sql->addCondicion('id', $id);
		$sql->update('elements');
	}

	if($sql->getSuccess()){
		return toJson(array('result' => SUCCESS, 'id' => $id));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => 'Error en Elemento: '.$sql->getError()));
	}
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
    if($id == 0){
		$id = $sql->insert('columnas');
	}else{
		$sql->addCondicion('id', $id);
		$sql->update('columnas');
	}

	if($sql->getSuccess()){
		// $elements = $col['elements'];
		// foreach ($elements as $key => $el) {
		// 	$save = saveElement($el, $idfila, $id, $tema);
		// 	$success = getJson($save);
		// 	if($success['result'] != SUCCESS){
		// 		return $save;
		//     }
		// }
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
		return toJson(array('result' => SUCCESS));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => 'Error en Tema: '.$sql->getError()));
	}
}

function getCss($style){

	return $style != NULL ? getJson($style) : array();
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
	$res = $sql->readSql('columnas');
	$columnas = array();
	while($reg = getreg($res)){
		$reg->elements = getElements($reg->id);
		$reg->estilos = getCss($reg->estilos);
		$columnas[] = $reg;
	}
	return $columnas;
}

function getContent($reg){
	$content = '';
	switch($reg->tag){ 
		case'TABLE': return getJson($reg->content); //$table;
		case'UL': return getJson($reg->content); //$table;
		default: return  ($reg->content);
	}
}

function getElements($idcol){
	$sql = new consulta();
	$sql->addCondicion('id_columna', $idcol);
	$res = $sql->readSql('elements');
	$elements = array();
	while($reg = getreg($res)){
		$reg->estilos = getCss($reg->estilos);
		$reg->content = getContent($reg);
		$elements[] = $reg;
	}
	return $elements;
}

function getElement($id){
	$sql = new consulta();
	$sql->addCondicion('id', $id);
	return getreg($sql->readSql('elements'));
	
}


function deleteElement($id){
	//antes borrar imagenes y archivos asociados
	$sql = new consulta();
	$sql->addCondicion('id', $id);
	$sql->delete('elements');

	if($sql->getSuccess()){
		return toJson(array('result' => SUCCESS));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => $sql->getError()));
	}
}


function emptyColumna($id){
	$sql = new consulta();
	$sql->addCondicion('id_columna', $id);
	$sql->delete('elements');

	if($sql->getSuccess()){
		return toJson(array('result' => SUCCESS));
	}else{
		return toJson(array('result' => 'ERROR', 'message' => $sql->getError()));
	}
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
	$idelement = getPost($request, 'idelement', 0);
	$file = getPost($files, 'image', NULL);
	$element = getElement($idelement);
	$tema = getTema($idtema);
	$dir = '../img/docente-'.$tema->id_docente.'/curso-'.$tema->id_curso.'/modulo-'.$tema->id_modulo.'/clase-'.$tema->id_clase.'/tema-'.$tema->id.'/';
	$name = $element != NULL ? getOldName($element->content, 'image') : 'image-'.date('Y-m-d').'_'.date('H-i-s');
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







 ?>