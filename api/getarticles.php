<?php
require_once "config.php";

try {
	$result = "";
	if ( isset( $_GET["search"] ) ) {
		$sql = "SELECT artikler.Navn as Artikel, artikler.Stregkode, artikler.Skuffenummer, artikler.Antal, kategorier.Navn as Kategori 
				FROM artikler 
				INNER JOIN kategorier ON kategorier.ID = artikler.FK_kategori_ID 
				WHERE artikler.Navn LIKE :artikel";
		$sth    = $conn->prepare( $sql );
		$search = "%" . $_GET["search"] . "%";
		$sth->bindParam( ':artikel', $search, PDO::PARAM_STR );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	} else {
		$sql = "SELECT artikler.Navn as Artikel, artikler.Stregkode, artikler.Skuffenummer, artikler.Antal, kategorier.Navn as Kategori 
				FROM artikler 
				INNER JOIN kategorier ON kategorier.ID = artikler.FK_kategori_ID";
		$sth = $conn->prepare( $sql );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	}
	foreach ( $result as $row ) {
		echo "<tr>";
		echo "<td>" .$row["Artikel"] ."</td>";
		echo "<td>" .$row["Kategori"] ."</td>";
		echo "<td>" .$row["Stregkode"] ."</td>";
		echo "<td>" .$row["Skuffenummer"] ."</td>";
		echo "<td> </td>";
		echo "<td> </td>";
		echo "<td>" .$row["Antal"] ."</td>";
		echo "</tr>";
	}
}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>