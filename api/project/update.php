<?php
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

		if ( isset( $_POST["project_id"] ) )
		{
			// set ID property of record to read
			$project_id    = filter_var( $_POST['project_id'], FILTER_SANITIZE_STRING );
			$valid_project = filter_var( $project_id, FILTER_VALIDATE_REGEXP, array( 'options' => array( 'regexp' => "/^[0-9]+$/" ) ) );
			//$validID     = filter_var( $id, FILTER_VALIDATE_REGEXP, array( 'options' => array( 'regexp' => "/^[a-zA-Z0-9]+$/" ) ) );
			if ( $valid_project )
			{
				$project->id = $_POST['project_id'];

				if ( isset( $_POST["project"] ) && isset( $_POST["description"] ) )
				{
					// set project property values

					$project->name        = $_POST['project'];
					$project->description = $_POST['description'];

					// update the project
					if ( $project->update() )
					{
						// tell the user
						echo json_encode( array( "message" => "Projektet blev ændret" ) );

						// set response code - 200 ok
						http_response_code( 200 );
					}
					// if unable to update the project, tell the user
					else
					{
						// set response code - 500 internal server error
						http_response_code( 500 );

						// tell the user
						die( json_encode( array( "message" => "Fejl opstod under ændringen af projektet" ) ) );
					}
				}
				else
				{
					// set response code - 400 bad request
					http_response_code( 400 );

					// tell the user
					die( json_encode( array( "message" => "Fejl opstod under ændringen af projektet. Data er ikke korrekt" ) ) );
				}
			}
		}
		else
		{
			// set response code - 503 service unavailable
			http_response_code( 503 );

			// tell the user
			die( json_encode( array( "message" => "Fejl opstod under ændringen af projektet. Data blev ikke modtaget" ) ) );
		}
	}
	catch( Exception $e )
	{
		// set response code - 500 internal server error
		http_response_code( 500 );

		// tell the user
		die( json_encode( array( "message" => "Fejl på siden, kontakt administrator" ) ) );
	}
}

?>