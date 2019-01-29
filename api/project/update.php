<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json; charset=UTF-8" );
header( "Access-Control-Allow-Methods: POST" );
header( "Access-Control-Max-Age: 3600" );
header( "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
	// include database and object files
	require_once '../config/database.php';
	require_once '../objects/project.php';

	// initialize object
	$project = new Project( $conn );

	// get posted data
	//$data = json_decode( file_get_contents( "php://input" ) );

	// set ID property of record to read
	$project->id = isset( $_POST['project_id'] ) ? $_POST['project_id'] : die();

	if ( isset( $_POST["projekt"] ) && isset( $_POST["beskrivelse"] ) ) {
		// set product property values
		$project->name        = $_POST['project'];
		$project->description = $_POST['tray_number'];

		// create the product
		if ( $project->update() ) {
			// tell the user
			echo json_encode( array( "message" => "Projektet blev ændret" ) );

			// set response code - 200 ok
			http_response_code( 200 );
		}
		// if unable to update the product, tell the user
		else {

			// set response code - 503 service unavailable
			http_response_code( 503 );

			// tell the user
			die( json_encode( array( "message" => "Fejl under ændring af projekt" ) ) );
		}
	}
}

?>