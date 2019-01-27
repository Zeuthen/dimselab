<?php
require_once "database1.php";

try
{
	if ( isset( $_POST["projectid"] ) && isset( $_POST["projekt"] ) && isset( $_POST["beskrivelse"] ) )
	{
		$sql = "UPDATE projekter SET Navn = :navn, Beskrivelse = :beskrivelse WHERE ID = :id";
		$sth = $conn->prepare( $sql );
		$sth->bindParam( ':id', $_POST["projectid"], PDO::PARAM_INT );
		$sth->bindParam( ':navn', $_POST["projekt"], PDO::PARAM_STR );
		$sth->bindParam( ':beskrivelse', $_POST["beskrivelse"], PDO::PARAM_STR );
		$sth->execute();
	}
}
catch( PDOException $e )
{
	echo $e->getMessage();
}
?>