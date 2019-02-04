<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: GET" );
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

		// query projects
		$stmt = $project->read();
		$num  = $stmt->rowCount();

		// check if more than 0 record found
		if ( $num > 0 )
		{
			//  projects_array
			$projects_arr = array();

			while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) )
			{
				//  extract row
				//  this will make $row['name'] to
				//  just $name only
				extract( $row );

				$project_item = array(
					"project_id"  => $project_id,
					"project"     => $project,
					"description" => $description,
					"user"        => $username,
					"user_id"     => $user_id,
					"user_name"   => $user_name,
					"date"        => $date
				);

				array_push( $projects_arr, $project_item );
			}
			echo json_encode( $projects_arr );

			// set response code - 200 OK
			http_response_code( 200 );
		}
		// no projects found will be here
		else
		{
			// set response code - 404 Not found
			http_response_code( 404 );

			// tell the user no projects found
			die( json_encode( array( "message" => "Ingen projekter blev fundet" ) ) );
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