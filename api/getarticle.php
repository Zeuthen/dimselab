<?php
require_once "config.php";

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
		echo json_encode($result);
		/*foreach ( $result as $row ) {
			echo "<tr>";
			echo "<td>" .$row["Artikel"] ."</td>";
			echo "<td>" .$row["Kategori"] ."</td>";
			echo "<td>" .$row["Stregkode"] ."</td>";
			echo "<td>" .$row["Skuffenummer"] ."</td>";
			echo "<td>" .$row["Antal"] ."</td>";
			echo "</tr>";
		}*/
	}
}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>