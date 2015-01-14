<?php

class Mysql{
	static $host = "127.0.0.1";
	static $user = "root";
	static $pwd = "tps29151532";
	static $db = "nodejs";
	
	static function connection(){
		try{
			$option = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
			);
			$conn = new PDO("mysql:host=".self::$host.";dbname=".self::$db,self::$user,self::$pwd,$option);
		}catch(PDOException $e){
			print "ERROR:".$e->getMessage();
			die();
		}
		
		return $conn;
	}
}



?>