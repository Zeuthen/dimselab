<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: POST" );
header( "Content-Type: application/json; charset=UTF-8" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
{
	try
	{
		// include database and object files
		require_once '../config/database.php';
		require_once '../objects/project.php';

		// initialize object
		$project = new Project( $conn );

		// set ID property of record to read
		$project->id = isset( $_POST['project_id'] ) ? $_POST['project_id'] : die();

		// read the details of project to be edited
		$stmt = $project->readOne();

		if ( $project->name != null )
		{
			//  create array
			$project_arr = array(
				"project_id"  => $project->id,
				"project"     => $project->name,
				"description" => $project->description,
				"user"        => $project->user,
				"user_id"     => $project->user_id,
				"user_name"   => $project->user_name
			);

			echo json_encode( $project_arr );

			// set response code - 200 OK
			http_response_code( 200 );
		}
		// no projects found will be here
		else
		{
			// set response code - 404 Not found
			http_response_code( 404 );

			// tell the user no projects found
			die( json_encode( array( "message" => "Intet projekt fundet." ) ) );
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