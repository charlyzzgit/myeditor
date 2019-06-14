<?php

function getConexion(){
	$hostname = "localhost";
	$basededatos = "EDITOR";
	$username = "root";
	$password = "";


	$base = new mysqli($hostname, $username, $password, $basededatos);
	if ($base->connect_errno) {
	    echo "Fallo al conectar a MySQL: (" . $base->connect_errno . ") " . $base->connect_error;
	}else{
		$base->query('SET CHARACTER SET UTF8');
	}

	return $base;
}

//echo $base->host_info . "\n";



?>