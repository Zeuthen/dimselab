<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: GET" );
header( "Content-Type: text/plain; charset=UTF-8" );
//header( "Content-Type: application/json; charset=UTF-8" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
	// include database and object files
	require_once '../config/database.php';
	require_once '../objects/category.php';

	// initialize object
	$category = new Category( $conn );

	// query articles
	$stmt = $category->read();
	$num  = $stmt->rowCount();

	// check if more than 0 record found
	if ( $num > 0 ) {
		// set response code - 200 OK
		http_response_code( 200 );

		echo "<option value=''>Vælg Kategori</option>";
		while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ) {
			echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
		}

	}
	// no articles found will be here
	else {
		// set response code - 404 Not found
		http_response_code( 404 );

		// tell the user no categories found
		echo "<option value=''>Ingen kategorier</option>";
	}

}
?>