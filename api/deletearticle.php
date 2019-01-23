<?php
require_once "config.php";

try
{
	if ( isset( $_POST["articleid"] ) )
	{
		$sql = "DELETE FROM artikler WHERE ID = :id";
		$sth = $conn->prepare( $sql );
		$sth->bindParam( ':id', $_POST["articleid"], PDO::PARAM_INT );
		$sth->execute();
	}
}
catch( Exception $e )
{
	echo $e->getMessage();
}
?>