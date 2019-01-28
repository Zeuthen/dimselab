<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: POST" );
header( "Content-Type: text/plain; charset=UTF-8" );
//header( "Content-Type: application/json; charset=UTF-8" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
{
	// include database and object files
	require_once '../config/database.php';
	require_once '../objects/article.php';

	// initialize object
	$article = new Article( $conn );

	// set ID property of record to read
	$article->id = isset( $_POST['barcode'] ) ? $_POST['barcode'] : die();

	// read the details of product to be edited
	$stmt = $article->readOne();

	if ( $article->name != null )
	{

		// set response code - 200 OK
		http_response_code( 200 );

		$article_arr = array(
			"article" => $article->name
		);

		// make it json format
		echo json_encode( $article_arr );
	}
}
?>