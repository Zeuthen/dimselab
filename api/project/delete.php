<?php
require_once "database1.php";

try
{
	if ( isset( $_POST["projectid"] ) )
	{
		$sql = "DELETE FROM projekter WHERE ID = :id";
		$sth = $conn->prepare( $sql );
		$sth->bindParam( ':id', $_POST["projectid"], PDO::PARAM_INT );
		$sth->execute();
	}
}
catch( Exception $e )
{
	echo $e->getMessage();
}
?>