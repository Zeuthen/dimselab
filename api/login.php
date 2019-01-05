<?php
require_once "config.php";

try {


	$conn = new PDO( "mysql:host=$host;dbname=$db", $username, $password );
	// set the PDO error mode to exception
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	$sql = "SELECT * FROM brugere WHERE Email = :email AND Adgangskode = :adgangskode";
	$sth = $conn->prepare( $sql );
	$sth->bindParam( ':email', $_POST["email"], PDO::PARAM_STR );
	$sth->bindParam( ':adgangskode', $_POST["password"], PDO::PARAM_STR );
	$sth->execute();
	$result = $sth->fetchAll();
	if ( count( $result ) > 0 ) {
		session_start();
		foreach ( $result as $row ) {
			$_SESSION["user"]   = $row["Brugernavn"];
			$_SESSION["userid"] = $row["ID"];
		}
	}
}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>