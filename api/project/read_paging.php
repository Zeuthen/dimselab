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
		require_once '../config/core.php';
		require_once '../shared/utilities.php';
		require_once '../config/database.php';
		require_once '../objects/project.php';

		// utilities
		$utilities = new Utilities();

		// initialize object
		$project = new Project( $conn );

		// query projects
		$stmt = $project->readPaging( $from_record_num, $records_per_page );
		$num  = $stmt->rowCount();

		if ( $num > 0 )
		{
			//  projects_array
			$projects_arr             = array();
			$projects_arr["projects"] = array();
			$projects_arr["paging"]   = array();

			while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) )
			{
				//  extract row
				//  this will make $row['name'] to
				//  just $name only
				extract( $row );

				$project_item = array(
					"project_id"  => $project->id,
					"project"     => $project->name,
					"description" => $project->description,
					"user"        => $project->user,
					"user_id"     => $project->user_id,
					"user_name"   => $project->user_name
				);

				array_push( $projects_arr, $project_item );
			}

			// include paging
			$total_rows = $project->count();
			$page_url   = "{$home_url}project/read_paging.php?";
			$paging     = $utilities->getPaging( $page, $total_rows, $records_per_page, $page_url );

			echo json_encode( $projects_arr );

			// set response code - 200 OK
			http_response_code( 200 );
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