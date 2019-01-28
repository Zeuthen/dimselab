<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json; charset=UTF-8" );
header( "Access-Control-Allow-Methods: POST" );
header( "Access-Control-Max-Age: 3600" );
header( "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
{
	// include database and object files
	require_once '../config/database.php';
	require_once '../objects/article.php';

	// initialize object
	$article = new Article( $conn );

	// get posted data
	//$data = json_decode( file_get_contents( "php://input" ) );

	// set ID property of record to read
	$article->id = isset( $_POST['article_id'] ) ? $_POST['article_id'] : die();

	if ( isset( $_POST['article'] ) && isset( $_POST['category'] ) && isset( $_POST['barcode'] ) && isset( $_POST['tray_number'] ) &&
	     isset( $_POST['quantity'] ) )
	{
		// set product property values
		$article->name        = $_POST['article'];
		$article->tray_number = $_POST['tray_number'];
		$article->barcode     = $_POST['barcode'];
		$article->quantity    = $_POST['quantity'];
		$article->category_id = $_POST['category'];

		// create the product
		if ( $article->update() )
		{
			// tell the user
			echo json_encode( array( "message" => "Artiklen er ændret" ) );

			// set response code - 200 ok
			http_response_code( 200 );
		}
		// if unable to update the product, tell the user
		else
		{

			// set response code - 503 service unavailable
			http_response_code( 503 );

			// tell the user
			die( json_encode( array( "message" => "Fejl under ændring af artikel" ) ) );
		}
	}
}
?>