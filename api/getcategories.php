<?php
require_once "config.php";

try {

	$conn = new PDO( "mysql:host=$host;dbname=$db", $username, $password );
	// set the PDO error mode to exception
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	$sql = "SELECT ID, Navn as Kategori
				FROM kategorier";
	$sth = $conn->prepare( $sql );
	$sth->execute();
	$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	echo "<option value='ingen'>Kategori</option>";
	foreach ( $result as $row ) {
		echo "<option value='" . $row['ID'] . "'>" . $row['Kategori'] . "</option>";
	}

}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>