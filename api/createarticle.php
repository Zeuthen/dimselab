<?php
require_once "config.php";

try {
	if ( isset( $_POST["artikel"] ) && isset( $_POST["stregkode"] ) && isset( $_POST["skuffenr"] ) && isset( $_POST["antal"] ) &&
	     isset( $_POST["kategori"] ) ) {
		$sql = "INSERT INTO artikler (Navn, Stregkode, Skuffenummer, Antal, FK_kategori_ID) 
					VALUES (:navn, :stregkode, :skuffenummer, :antal, :FK_kategori_ID)";
		$sth = $conn->prepare( $sql );
		$sth->bindParam( ':navn', $_POST["artikel"], PDO::PARAM_STR );
		$sth->bindParam( ':stregkode', $_POST["stregkode"], PDO::PARAM_STR );
		$sth->bindParam( ':skuffenummer', $_POST["skuffenr"], PDO::PARAM_INT );
		$sth->bindParam( ':antal', $_POST["antal"], PDO::PARAM_INT );
		$sth->bindParam( ':FK_kategori_ID', $_POST["kategori"], PDO::PARAM_INT );
		$sth->execute();
	}
}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>