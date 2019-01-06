<?php

$db       = "dimselab";
$host     = "localhost";
$username = "root";
$password = "";

$conn = new PDO( "mysql:host=$host;dbname=$db", $username, $password );
// set the PDO error mode to exception
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

?>