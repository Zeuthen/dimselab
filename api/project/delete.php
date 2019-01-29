<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json; charset=UTF-8" );
header( "Access-Control-Allow-Methods: POST" );
header( "Access-Control-Max-Age: 3600" );
header( "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
{
	// include database and object file
	include_once '../config/database.php';
	include_once '../objects/project.php';

	// prepare project object
	$project = new Project( $conn );

	// get project id
	//$data = json_decode(file_get_contents("php://input"));

	// set project id to be deleted
	$project->id = isset( $_POST['project_id'] ) ? $_POST['project_id'] : die();

	// delete the project
	if ( $project->delete() )
	{
		// tell the user
		echo json_encode( array( "message" => "Projektet blev slettet" ) );

		// set response code - 200 OK
		http_response_code( 200 );
	}

	// if unable to delete the project
	else
	{

		// set response code - 503 service unavailable
		http_response_code( 503 );

		// tell the user
		die( json_encode( array( "message" => "Fejl under slettelse af projekt" ) ) );
	}
}
?>