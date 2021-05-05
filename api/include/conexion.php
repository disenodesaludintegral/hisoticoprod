<?php

class Conexion{
	static public function Conectar(){
		$host = "172.31.15.159";
		$user = "root";
		$pass = "$123@56$";
		$db = "synapse_espejo_noc";
		try{
			
			$link  = new PDO("mysql:host={$host};dbname={$db};charset=utf8",$user,$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			
			return $link;
		}catch(PDOException $e){
			
			echo $e;

		}
		
	}
}


