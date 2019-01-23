<?php
require_once "config.php";

try
{
	if ( isset( $_POST["artikel"] ) && isset( $_POST["skuffenummer"] ) && isset( $_POST["stregkode"] ) && isset( $_POST["antal"] ) &&
	     isset( $_POST["kategori"] ) )
	{
		$sql = "INSERT INTO artikler (Navn, Skuffenummer, Stregkode, Antal, FK_kategori_ID) 
					VALUES (:navn, :skuffenummer, :stregkode, :antal, :FK_kategori_ID)";
		$sth = $conn->prepare( $sql );
		$sth->bindParam( ':navn', $_POST["artikel"], PDO::PARAM_STR );
		$sth->bindParam( ':stregkode', $_POST["stregkode"], PDO::PARAM_STR );
		$sth->bindParam( ':skuffenummer', $_POST["skuffenummer"], PDO::PARAM_INT );
		$sth->bindParam( ':antal', $_POST["antal"], PDO::PARAM_INT );
		$sth->bindParam( ':FK_kategori_ID', $_POST["kategori"], PDO::PARAM_INT );
		$sth->execute();
	}
}
catch( Exception $e )
{

	echo $e->getMessage();
}
?>