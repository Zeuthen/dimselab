<?php
$db       = "dimselab";
$host     = "localhost";
$username = "root";
$password = "";

try {

	$conn = new PDO( "mysql:host=$host;dbname=$db", $username, $password );
	// set the PDO error mode to exception
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$result = "";
	if ( isset( $_GET["search"] ) ) {

		$sql    = "SELECT artikler.Navn as Artikel, artikler.Stregkode, kategorier.Navn as Kategori, brugere.Brugernavn as Bruger, projekter.Navn as Projekt
				FROM statistik
				INNER JOIN brugere ON brugere.ID = statistik.FK_bruger_ID
				INNER JOIN artikler ON artikler.ID = statistik.FK_artikel_ID
				INNER JOIN projekter ON projekter.ID = statistik.FK_projekt_ID
				INNER JOIN kategorier ON kategorier.ID = statistik.FK_kategori_ID
				WHERE artikler.Navn LIKE :artikel";
		$sth    = $conn->prepare( $sql );
		$search = "%" . $_GET["search"] . "%";
		$sth->bindParam( ':artikel', $search, PDO::PARAM_STR );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	} else {
		$sql = "SELECT artikler.Navn as Artikel, artikler.Stregkode, artikler.Skuffenummer, kategorier.Navn as Kategori, brugere.Brugernavn as Bruger, projekter
.Navn as Projekt, projekter.Beskrivelse
				FROM statistik
				INNER JOIN brugere ON brugere.ID = statistik.FK_bruger_ID
				INNER JOIN artikler ON artikler.ID = statistik.FK_artikel_ID
				INNER JOIN projekter ON projekter.ID = statistik.FK_projekt_ID
				INNER JOIN kategorier ON kategorier.ID = statistik.FK_kategori_ID";
		$sth = $conn->prepare( $sql );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	}

	$sth = $conn->prepare( $sql );
	$sth->execute();
	$result = $sth->fetchAll( PDO::FETCH_ASSOC );

	foreach ( $result as $row ) {
		echo "<tr>";
		echo "<td>" . $row["Artikel"] . "</td>";
		echo "<td>" . $row["Stregkode"] . "</td>";
		echo "<td>" . $row["Skuffenummer"] . "</td>";
		echo "<td>" . $row["Bruger"] . "</td>";
		echo "<td>" . $row["Projekt"] . "</td>";
		echo "<td>" . $row["Beskrivelse"] . "</td>";;
		echo "<td> </td>";
		echo "<td> </td>";
		echo "</tr>";
	}
}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>