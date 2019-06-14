<?php
	require_once('conexion.php');
	error_reporting(1);

	function allreg($sql){
		$base = getConexion();
		return $base->query($sql);
	}

	function unreg($sql){
	 	$base = getConexion();
		return mysqli_fetch_array(mysqli_query($sql, $base));
	}

	function getreg($res){
		
		return $res->fetch_object();
	}

	function rows($res){
		return mysqli_num_rows($res);
	}

	class consulta{
	
	function __construct() {
		$this->base = getConexion();
   	}
	
    var  $array_campos = array();
  	var $array_condiciones = array();
	var $order = '';
	var $condicion = '';
	var $sql = '';
	var $error = '';
	var $success = '';
	 
	function orderBy($o){
		$this->order = $o;
	}
	
	function getSql(){
		return $this->sql;
	}
	
	function getError(){
		return $this->error;
	}

	function getSuccess(){
		return $this->success;
	}
	
   
   function addCampo($campo, $valor){
	   $i = count($this->array_campos);
	   $this->array_campos[$i]->campo = $campo;
	   $this->array_campos[$i]->val = $valor;
	   
   }
   
   function addCondicion($campo, $valor){
	   $i = count($this->array_condiciones);
	   $this->array_condiciones[$i]->campo = $campo;
	   $this->array_condiciones[$i]->val = $valor;
	   
   }
   
   function condiciones($c){
	   
	   $this->condicion = $c;
	   
   }

    function readSql($tabla){
		$w = '';
		$cond = '';
		$order = '';
		$condicion = '';
		if($this->order != ''){
			$order = ' order by '.$this->order;
		}
		if(count($this->array_condiciones) > 0){
			for($i = 0; $i < count($this->array_condiciones); $i++){
				$cond.=$this->array_condiciones[$i]->campo." = '".$this->array_condiciones[$i]->val."' and ";
			}
			$cond = substr($cond, 0, -5);
			$w = " where ";
		}else if($this->condicion != ''){
			$condicion = $this->condicion;
			$w = " where ";
		}
		$this->sql = "select * from ".$tabla.$w.$cond.$condicion.$order;
		//echo $this->sql;
		$res = allreg($this->sql, $this->base);
		//$reg = getreg($res);
		$this->error = mysqli_error($this->base);
		$this->base->close();
		return $res;
	}
	
	function insert($tabla){
		//$this->array_campos = array();
		$c = ' (';
		for($i = 0; $i < count($this->array_campos); $i++){
			$c.= $this->array_campos[$i]->campo.', ';
		}
		$c = substr($c, 0, -2);
		$c.=") values('"; 
		for($i = 0; $i < count($this->array_campos); $i++){
			$c.= $this->array_campos[$i]->val."', '";
		}
		$c = substr($c, 0, -3);
		
		$c.=')';
		$this->sql = "insert into ".$tabla.$c;
		//echo 'sql = '.$sql;
		$this->success = $this->base->query($this->sql); 

		$id = $this->base->insert_id;
		
		$this->error = mysqli_error($this->base);
		
		$this->base->close();

		return $id;
		
	}
	
	function update($tabla){
		//$this->array_campos = array();
		//$this->array_condiciones = array();
		$c = '';
		$w = '';
		for($i = 0; $i < count($this->array_campos); $i++){
			$c.= $this->array_campos[$i]->campo." = '".$this->array_campos[$i]->val."',";
		}
		$c = substr($c, 0, -1);
		$cond = '';
		if(count($this->array_condiciones) > 0){
			for($i = 0; $i < count($this->array_condiciones); $i++){
				$cond.=$this->array_condiciones[$i]->campo." = '".$this->array_condiciones[$i]->val."' and ";
			}
			$cond = substr($cond, 0, -5);
			$w = " where ";
		}
		
		$this->sql = "update ".$tabla." set ".$c.$w.$cond;
		//echo 'sql = '.$sql;
		$this->success = $this->base->query($this->sql); 
		
		$this->error = mysqli_error($this->base);
		$this->base->close();
	}
	
	
	function delete($tabla){
		$cond = '';
		if(count($this->array_condiciones) > 0){
			$cond = " where ";
			for($i = 0; $i < count($this->array_condiciones); $i++){
				$cond.=$this->array_condiciones[$i]->campo." = '".$this->array_condiciones[$i]->val."' and ";
			}
		}
		$cond = substr($cond, 0, -4);
		$this->sql = "delete from ".$tabla.$cond;
		//echo 'sql = '.$sql;
		$this->success = $this->base->query($this->sql); 
		//echo 'sql = '.$del;
		$this->error = mysqli_error($this->base);
		$this->base->close();
	}


	function sumarGrupos(){
		$w = '';
		$cond = '';
		$order = '';
		$condicion = '';
		$tabla = 'grupos';
		if($this->order != ''){
			$order = ' order by '.$this->order;
		}
		if(count($this->array_condiciones) > 0){
			for($i = 0; $i < count($this->array_condiciones); $i++){
				$cond.=$this->array_condiciones[$i]->campo." = '".$this->array_condiciones[$i]->val."' and ";
			}
			$cond = substr($cond, 0, -5);
			$w = " where ";
		}else if($this->condicion != ''){
			$condicion = $this->condicion;
			$w = " where ";
		}
		$this->sql = "select 
						SUM(j) as j,
						SUM(g) as g,
						SUM(e) as e,
					    SUM(p) as p,
						SUM(gf) as gf,
						SUM(gc) as gc,
						SUM(gv) as gv,
						SUM(d) as d,
						SUM(pts) as pts
						from ".$tabla.$w.$cond.$condicion.$order;
		$res = allreg($this->sql, $this->base);
		//$reg = getreg($res);
		$this->error = mysqli_error($this->base);
		$this->base->close();
		return $res;
		
	}


   
}


//****************************************************fin consulta*****************************************************************************

//****************************************************backups*****************************************************************************************


function borrar($tabla){
	$base = getConexion();
	$sql = new consulta($base);
	$sql->delete($tabla);
}

// function reset($tabla){
// 	$base = getConexion();
// 	$base->query('ALTER TABLE '.$tabla.' AUTO_INCREMENT = 0') or die($base->error);
// }

function copyTabla($tabla){
	$base = getConexion();
	$nueva = 'back_'.$tabla;
	$base->query('CREATE TABLE '.$nueva .' LIKE '.$tabla) or die($base->error);

	//$base->query('CREATE TABLE'.$nueva.' SELECT * FROM' tabla_origen';
}

function setBackup($tabla){
	$base = getConexion();
	borrar('back_'.$tabla, $base);
	return mysqli_error($base->query('INSERT INTO back_'.$tabla.' SELECT * FROM '.$tabla));
	//return (mysqli_error($base);
}

function getBackup($tabla){
	$base = getConexion();
	borrar($tabla, $base);
	return mysqli_error($base->query('INSERT INTO '.$tabla.' SELECT * FROM back_'.$tabla));
	//return (mysqli_error($base));
}


function modTabla($tabla){
	$base = getConexion();
	"DROP TABLE back_".$tabla;
	//copyTabla($tabla, $base);
	
}

?>