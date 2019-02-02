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
		require_once '../objects/article.php';

		// initialize object
		$article = new Article( $conn );

		// set ID property of record to read
		$article->barcode = isset( $_POST['barcode'] ) ? $_POST['barcode'] : die();

		// read the details of article to be edited
		$stmt = $article->readOne();

		if ( $article->name != null )
		{
			//  create array
			$article_arr = array(
				"article_id"  => $article->id,
				"article"     => $article->name,
				"tray_number" => $article->tray_number,
				"barcode"     => $article->barcode,
				"on_loan"     => $article->on_loan,
				"quantity"    => $article->quantity,
				"category_id" => $article->category_id,
				"category"    => $article->category
			);

			echo json_encode( $article_arr );

			// set response code - 200 OK
			http_response_code( 200 );
		}
		// no articles found will be here
		else
		{
			// set response code - 404 Not found
			http_response_code( 404 );

			// tell the user no articles found
			exit( json_encode( array( "message" => "Ingen artikel fundet." ) ) );
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