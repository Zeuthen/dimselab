<?php

require_once "config.php";

try {

	$conn = new PDO( "mysql:host=$host;dbname=$db", $username, $password );
	// set the PDO error mode to exception
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	if ( isset( $_POST["artikel"] ) && isset( $_POST["stregkode"] ) && isset( $_POST["projekt"] ) && isset( $_POST["beskrivelse"] ) &&
	     isset( $_POST["antal"] ) ) {

		$sql = "INSERT INTO projekter (Navn, Beskrivelse, FK_artikel_ID, FK_bruger_ID) 
					VALUES (:projekt, :beskrivelse, (SELECT artikler.ID as Artikel FROM artikler WHERE artikler.Navn = :artikel LIMIT 1), :bruger)";

		$sth = $conn->prepare( $sql );
		$sth->bindParam( ':projekt', $_POST["projekt"], PDO::PARAM_STR );
		$sth->bindParam( ':beskrivelse', $_POST["beskrivelse"], PDO::PARAM_STR );
		$sth->bindParam( ':artikel', $_POST["artikel"], PDO::PARAM_STR );
		$sth->bindParam( ':bruger', $_SESSION["userid"], PDO::PARAM_INT );
		$sth->execute();

		$sql = "INSERT INTO statistik (FK_artikel_ID, FK_bruger_ID, FK_projekt_ID) 
					VALUES ((SELECT artikler.ID FROM artikler WHERE artikler.Navn = :artikel LIMIT 1), :bruger, (SELECT projekter.ID FROM projekter
					 WHERE projekter.Navn = :projekt AND projekter.Beskrivelse = :beskrivelse LIMIT 1))";

		$sth = $conn->prepare( $sql );
		$sth->bindParam( ':artikel', $_POST["artikel"], PDO::PARAM_STR );
		$sth->bindParam( ':bruger', $_SESSION["userid"], PDO::PARAM_INT );
		$sth->bindParam( ':projekt', $_POST["projekt"], PDO::PARAM_STR );
		$sth->bindParam( ':beskrivelse', $_POST["beskrivelse"], PDO::PARAM_STR );
		$sth->execute();
	}
}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>