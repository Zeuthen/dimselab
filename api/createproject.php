<?php
session_start();
require_once "config.php";

try {
	if ( isset( $_POST["projekt"] ) && isset( $_POST["beskrivelse"] ) && isset( $_SESSION["userid"] )) {
		$sql = "INSERT INTO projekter (Navn, Beskrivelse, FK_bruger_ID) 
					VALUES (:navn, :beskrivelse, :bruger)";
		$sth = $conn->prepare( $sql );
		$sth->bindParam( ':navn', $_POST["projekt"], PDO::PARAM_STR );
		$sth->bindParam( ':beskrivelse', $_POST["beskrivelse"], PDO::PARAM_STR );
		$sth->bindParam( ':bruger', $_SESSION["userid"], PDO::PARAM_INT );
		$sth->execute();
	}
}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>