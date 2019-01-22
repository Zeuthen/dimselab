<?php
require_once "config.php";

try {

	$sql = "SELECT ID, Navn as Kategori
				FROM kategorier";
	$sth = $conn->prepare( $sql );
	$sth->execute();
	$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	echo "<option value='ingen'>Vælg Kategori</option>";
	foreach ( $result as $row ) {
		echo "<option value='" . $row['ID'] . "'>" . $row['Kategori'] . "</option>";
	}

}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>