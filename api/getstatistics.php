<?php
require_once "config.php";

try {

	$result = "";
	if ( isset( $_GET["search"] ) ) {

		$sql = "SELECT artikler.Navn as Artikel, artikler.Stregkode, brugere.Navn as Bruger, projekter.Navn as Projekt, statistik.Created
				FROM statistik
				INNER JOIN brugere ON brugere.ID = statistik.FK_bruger_ID
				INNER JOIN artikler ON artikler.ID = statistik.FK_artikel_ID
				INNER JOIN projekter ON projekter.ID = statistik.FK_projekt_ID
				WHERE artikler.Navn LIKE :artikel";
		$sth = $conn->prepare( $sql );
		$search = "%" . $_GET["search"] . "%";
		$sth->bindParam( ':artikel', $search, PDO::PARAM_STR );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	} else {
		$sql = "SELECT artikler.Navn as Artikel, artikler.Stregkode, brugere.Navn as Bruger, projekter.Navn as Projekt, statistik.Created
				FROM statistik
				INNER JOIN brugere ON brugere.ID = statistik.FK_bruger_ID
				INNER JOIN artikler ON artikler.ID = statistik.FK_artikel_ID
				INNER JOIN projekter ON projekter.ID = statistik.FK_projekt_ID";
		$sth = $conn->prepare( $sql );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	}

	foreach ( $result as $row ) {
		echo "<tr>";
		echo "<td>" . $row["Artikel"] . "</td>";
		echo "<td>" . $row["Stregkode"] . "</td>";
		echo "<td>" . $row["Bruger"] . "</td>";
		echo "<td>" . $row["Projekt"] . "</td>";
		echo "<td>" . $row["Created"] . "</td>";
		echo "</tr>";
	}
}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>