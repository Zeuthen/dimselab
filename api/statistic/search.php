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
		if ( $num > 0 )
		{
			//  categories_array
			$statistics_arr = array();

			while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) )
			{
				//  extract row
				//  this will make $row['name'] to
				//  just $name only
				extract( $row );

				$statistic_item = array(
					"article" => $article,
					"barcode" => $barcode,
					"user"    => $user,
					"project" => $project,
					"date"    => date( "d-m-Y", strtotime( $date ) )
				);

				array_push( $statistics_arr, $statistic_item );
			}
			echo json_encode( $statistics_arr );

			// set response code - 200 OK
			http_response_code( 200 );
		}
		// no statistics found will be here
		else
		{
			// set response code - 404 Not found
			http_response_code( 404 );

			// tell the user no statistics found
			die( json_encode( array( "message" => "Ingen statistikker blev fundet" ) ) );
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