<?php

// specify your own database credentials

$db       = "dimselab";
$host     = "localhost";
$username = "root";
$password = "";
$charset  = 'utf8';

try {

	$dsn  = "mysql:host=$host;dbname=$db;charset=$charset";
	$conn = new PDO( $dsn, $username, $password );
	// set the PDO error mode to exception
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch( PDOException $e ) {
	echo "Connection error: " . $e->getMessage();
}