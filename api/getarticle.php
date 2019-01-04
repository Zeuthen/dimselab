<?php
$db       = "dimselab";
$host     = "localhost";
$username = "root";
$password = "";

try {

	$conn = new PDO( "mysql:host=$host;dbname=$db", $username, $password );
	// set the PDO error mode to exception
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	if ( isset( $_GET["stregkode"] ) ) {
		$sql    = "SELECT artikler.Navn as Artikel, artikler.Stregkode, artikler.Skuffenummer, artikler.Antal, kategorier.Navn as Kategori 
				FROM artikler 
				INNER JOIN kategorier ON kategorier.ID = artikler.FK_kategori_ID 
				WHERE artikler.Stregkode = :stregkode";
		$sth    = $conn->prepare( $sql );
		$sth->bindParam( ':stregkode', $_GET["stregkode"], PDO::PARAM_STR );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
		foreach ( $result as $item ) {
			echo "<tr>";
			echo "<td>";
			echo $item["Artikel"];
			echo "</td>";
			echo "<td>";
			echo $item["Kategori"];
			echo "</td>";
			echo "<td>";
			echo $item["Stregkode"];
			echo "</td>";
			echo "<td>";
			echo $item["Skuffenummer"];
			echo "</td>";
			echo "<td>";

			echo "</td>";
			echo "<td>";

			echo "</td>";
			echo "<td>";
			echo $item["Antal"];
			echo "</td>";
			echo "</tr>";
		}
	}
}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>