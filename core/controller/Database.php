<?php

class Database{

	private static $intance = NULL;

	public static function getConexion(){

		if (!isset($instance)) {
			try {

// echo '<pre>'; print_r("Conecion nn"); echo '</pre>';
	            $instance = new PDO("mysql:=".DB_HOST.";dbname=".DB_NAME.";", DB_USERNAME, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

			} catch (PDOException $e) {

			  die('Connection Failed: ' . $e->getMessage());

			}
        }
        return $instance;
	}

}