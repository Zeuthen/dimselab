<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: POST" );
header( "Content-Type: application/json; charset=UTF-8" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
	// include database and object files
	include_once '../config/core.php';
	include_once '../config/database.php';
	include_once '../objects/project.php';

	// initialize object
	$project = new Project( $conn );

	// get keywords
	$keywords = isset( $_POST["search"] ) ? $_POST["search"] : "";

	// query projects
	$stmt = $project->search( $keywords );
	$num  = $stmt->rowCount();

	// check if more than 0 record found
	if ( $num > 0 ) {
		//  categories_array
		$projects_arr = array();

		while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ) {
			//  extract row
			//  this will make $row['name'] to
			//  just $name only
			extract( $row );

			$project_item = array(
				"project_id"  => $project_id,
				"project"     => $project,
				"tray_number" => $tray_number,
				"barcode"     => $barcode,
				"on_loan"     => $on_loan,
				"quantity"    => $quantity,
				"category_id" => $category_id,
				"category"    => $category
			);

			array_push( $projects_arr, $project_item );
		}
		echo json_encode( $projects_arr );

		// set response code - 200 OK
		http_response_code( 200 );
	}
	// no projects found will be here
	else {
		// set response code - 404 Not found
		http_response_code( 404 );

		// tell the user no projects found
		die( json_encode( array( "message" => "Ingen projekter blev fundet" ) ) );
	}
}
?>