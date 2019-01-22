<?php
require_once "config.php";

try
{
	$result = "";

	$sql = "SELECT ID, projekter.Navn as Projekt, Beskrivelse FROM projekter";
	$sth = $conn->prepare( $sql );
	$sth->execute();
	$result = $sth->fetchAll( PDO::FETCH_ASSOC );


	echo "<option value=''>Vælg Projekt</option>";
	foreach ( $result as $row )
	{
		echo "<option value='" . $row['ID'] . "'>" . $row['Projekt'] . ", ". $row['Beskrivelse'] ."</option>";
	}
}
catch( PDOException $e )
{
	echo $e->getMessage();
}
?>