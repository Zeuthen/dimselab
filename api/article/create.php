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

	if ( isset( $_POST['article'] ) && isset( $_POST['category'] ) && isset( $_POST['barcode'] ) && isset( $_POST['tray_number'] ) &&
	     isset( $_POST['quantity'] ) )
	{
		// set user property values
		$article->name        = $_POST['article'];
		$article->tray_number = $_POST['tray_number'];
		$article->barcode     = $_POST['barcode'];
		$article->quantity    = $_POST['quantity'];
		$article->category_id = $_POST['category'];

		// create the user
		if ( $article->create() )
		{
			// tell the user
			echo json_encode( array( "message" => "Article was created." ) );

			// set response code - 201 created
			http_response_code( 201 );
		}
		// if unable to create the user, tell the user
		else
		{
			// set response code - 503 service unavailable
			http_response_code( 503 );

			// tell the user
			die( json_encode( array( "message" => "Unable to create article." ) ) );
		}
	}
	// tell the user data is incomplete
	else
	{
		// set response code - 400 bad request
		http_response_code( 400 );

		// tell the user
		die( json_encode( array( "message" => "Unable to create user. Data is incomplete." ) ) );
	}
}
?>