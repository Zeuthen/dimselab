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
		require_once '../objects/category.php';

		// initialize object
		$category = new Category( $conn );

		// query categories
		$stmt = $category->read();
		$num  = $stmt->rowCount();

		// check if more than 0 record found
		if ( $num > 0 )
		{
			//  categories_array
			$categories_arr = array();

			//  retrieve our table contents
			while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) )
			{
				//  extract row
				//  this will make $row['name'] to
				//  just $name only
				extract( $row );

				$category_item = array(
					"id"   => $id,
					"name" => $name
				);

				array_push( $categories_arr, $category_item );
			}
			echo json_encode( $categories_arr );

			// set response code - 200 OK
			http_response_code( 200 );
		}
		// no categories found will be here
		else
		{
			// set response code - 404 Not found
			http_response_code( 404 );

			// tell the user no categories found
			echo "<option value=''>Ingen kategorier</option>";
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