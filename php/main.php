<?php
header('Access-Control-Allow-Origin: *');  //para ser accecible remotamente
 date_default_timezone_set('America/Buenos_Aires');
 error_reporting(1);

 

require_once('scripts.php');

set_time_limit(0);
$ERROR = '__ERROR__';
$OK = '__OK__';


$request = $_REQUEST;
$files = $_FILES;

$action = $request['action'];


switch($action){
	case 'backup':
		backup();
		echo 'ok';
	break;
	case 'restore':
		restore();
		echo 'ok';
	break;
	case 'savePageTema':
		$tema = getJson(getPost($request, 'tema', NULL));
		echo savePageTema($tema);
	break;
	
	case 'newTema':
		echo createTema($request);
	break;
	
	case 'delFila':
		echo deleteFila(getPost($request, 'idfila', NULL));
	break;
	case 'sendImage':
		echo saveImage($request, $files);
	break;
	case 'sendFile':
		echo saveArchivo($request, $files);
	break;
	case 'download':
		$url = getPost($request, 'url', '');
		$file = getPost($request, 'file', '');
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	
		echo file_get_contents($url.$file);

		
	
	break;
	case 'saveEstilo':
		echo saveEstilo($request);
	break;
	case 'deleteEstilo':
		echo deleteEstilo($request);
	break;
	case 'saveImage':
		echo 'uploaded';
	break;
	case 'ver':
		
	break;
 }




?>

