<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: POST" );
header( "Content-Type: application/json; charset=UTF-8" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
	// include database and object files
	include_once '../config/core.php';
	include_once '../config/database.php';
	include_once '../objects/statistic.php';

	// initialize object
	$statistic = new Statistic( $conn );

	// get keywords
	$keywords = isset( $_POST["search"] ) ? $_POST["search"] : "";

	// query statistics
	$stmt = $statistic->search( $keywords );
	$num  = $stmt->rowCount();

	// check if more than 0 record found
	if ( $num > 0 ) {
		//  categories_array
		$statistics_arr = array();

		while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ) {
			//  extract row
			//  this will make $row['name'] to
			//  just $name only
			extract( $row );

			$statistic_item = array(
				"statistic_id" => $statistic_id,
				"statistic"    => $statistic,
				"description"  => $description,
				"user"         => $username,
				"user_id"      => $user_id,
				"user_name"    => $user_name
			);

			array_push( $statistics_arr, $statistic_item );
		}
		echo json_encode( $statistics_arr );

		// set response code - 200 OK
		http_response_code( 200 );
	}
	// no statistics found will be here
	else {
		// set response code - 404 Not found
		http_response_code( 404 );

		// tell the user no statistics found
		die( json_encode( array( "message" => "Ingen statistikker blev fundet" ) ) );
	}
}

try {

	$result = "";
	if ( isset( $_GET["search"] ) ) {

		$sql    = "SELECT artikler.Navn as Artikel, artikler.Stregkode, brugere.Navn as Bruger, statistikker.Navn as Projekt, statistik.Created
				FROM statistik
				INNER JOIN brugere ON brugere.ID = statistik.FK_bruger_ID
				INNER JOIN artikler ON artikler.ID = statistik.FK_artikel_ID
				INNER JOIN statistikker ON statistikker.ID = statistik.FK_projekt_ID
				WHERE artikler.Navn LIKE :artikel";
		$sth    = $conn->prepare( $sql );
		$search = "%" . $_GET["search"] . "%";
		$sth->bindParam( ':artikel', $search, PDO::PARAM_STR );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	}
	else {
		$sql = "SELECT artikler.Navn as Artikel, artikler.Stregkode, brugere.Navn as Bruger, statistikker.Navn as Projekt, statistik.Created
				FROM statistik
				INNER JOIN brugere ON brugere.ID = statistik.FK_bruger_ID
				INNER JOIN artikler ON artikler.ID = statistik.FK_artikel_ID
				INNER JOIN statistikker ON statistikker.ID = statistik.FK_projekt_ID";
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