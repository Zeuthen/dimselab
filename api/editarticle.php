<?php
require_once "config.php";

try
{
	if ( isset( $_POST["articleid"] ) && isset( $_POST["artikel"] ) && isset( $_POST["skuffenummer"] ) && isset( $_POST["stregkode"] ) &&
	     isset( $_POST["antal"] ) && isset( $_POST["kategori"] ) )
	{
		$sql =
			"UPDATE artikler SET Navn = :navn, Skuffenummer = :skuffenummer, Stregkode = :stregkode, Antal = :antal, FK_kategori_ID = :kategori WHERE ID = :id";
		$sth = $conn->prepare( $sql );
		$sth->bindParam( ':id', $_POST["articleid"], PDO::PARAM_INT );
		$sth->bindParam( ':navn', $_POST["artikel"], PDO::PARAM_STR );
		$sth->bindParam( ':stregkode', $_POST["stregkode"], PDO::PARAM_STR );
		$sth->bindParam( ':skuffenummer', $_POST["skuffenummer"], PDO::PARAM_INT );
		$sth->bindParam( ':antal', $_POST["antal"], PDO::PARAM_INT );
		$sth->bindParam( ':kategori', $_POST["kategori"], PDO::PARAM_INT );
		$sth->execute();
	}
}
catch( PDOException $e )
{
	echo $e->getMessage();
}
?>