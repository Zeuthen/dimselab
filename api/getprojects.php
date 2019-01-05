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

		$sql = "SELECT projekter.Navn as Projekt, projekter.Beskrivelse, brugere.Brugernavn as Bruger, artikler.Navn as Artikel
				FROM projekter
				INNER JOIN brugere ON brugere.ID = projekter.FK_bruger_ID
				INNER JOIN artikler ON artikler.ID = projekter.FK_artikel_ID
				WHERE projekter.Navn LIKE :projekt";
		$sth    = $conn->prepare( $sql );
		$search = "%" . $_GET["search"] . "%";
		$sth->bindParam( ':projekt', $search, PDO::PARAM_STR );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	} else {
		$sql = "SELECT projekter.Navn as Projekt, projekter.Beskrivelse, brugere.Brugernavn as Bruger, artikler.Navn as Artikel
				FROM projekter
				INNER JOIN brugere ON brugere.ID = projekter.FK_bruger_ID
				INNER JOIN artikler ON artikler.ID = projekter.FK_artikel_ID";
		$sth = $conn->prepare( $sql );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	}

	$sth = $conn->prepare( $sql );
	$sth->execute();
	$result = $sth->fetchAll( PDO::FETCH_ASSOC );

	foreach ( $result as $row ) {
		echo "<tr>";
		echo "<td>" . $row["Projekt"] . "</td>";
		echo "<td>" . $row["Beskrivelse"] . "</td>";
		echo "<td>" . $row["Artikel"] . "</td>";
		echo "<td>" . $row["Bruger"] . "</td>";
		echo "</tr>";
	}
}
catch( PDOException $e ) {
	echo $e->getMessage();
}
?>