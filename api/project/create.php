<?php
session_start();
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json; charset=UTF-8" );
header( "Access-Control-Allow-Methods: POST" );
header( "Access-Control-Max-Age: 3600" );
header( "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
{
	try
	{
		// include database and object files
		require_once '../config/database.php';
		require_once '../objects/project.php';

		// initialize object
		$project = new Project( $conn );

		// get posted data
		//$data = json_decode( file_get_contents( "php://input" ) );

		if ( isset( $_POST["project"] ) && isset( $_POST["description"] ) && isset( $_SESSION["USER_ID"] ) )
		{
			// set user property values
			$project->name        = $_POST['project'];
			$project->description = $_POST['description'];
			$project->user_id     = $_SESSION["USER_ID"];

			// create the user
			if ( $project->create() )
			{
				// tell the user
				echo json_encode( array( "message" => "Projektet er oprettet" ) );

				// set response code - 201 created
				http_response_code( 201 );
			}
			// if unable to create the user, tell the user
			else
			{
				// set response code - 503 service unavailable
				http_response_code( 503 );

				// tell the user
				die( json_encode( array( "message" => "Fejl under oprettelse af projekt" ) ) );
			}
		}
		// tell the user data is incomplete
		else
		{
			// set response code - 400 bad request
			http_response_code( 400 );

			// tell the user
			die( json_encode( array( "message" => "Fejl under oprettelse af projekt. Data er ikke korrekt" ) ) );
		}
	}
	catch( Exception $e )
	{
		// set response code - 400 bad request
		http_response_code( 500 );

		// tell the user
		die( json_encode( array( "message" => "Fejl på siden, kontakt administrator" ) ) );
	}
}

?>