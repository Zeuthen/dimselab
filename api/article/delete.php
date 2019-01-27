<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json; charset=UTF-8" );
header( "Access-Control-Allow-Methods: POST" );
header( "Access-Control-Max-Age: 3600" );
header( "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
	// include database and object file
	include_once '../config/database.php';
	include_once '../objects/article.php';

	// prepare article object
	$article = new Article( $conn );

	// get article id
	//$data = json_decode(file_get_contents("php://input"));

	// set article id to be deleted
	$article->id = isset( $_POST['article_id'] ) ? $_POST['article_id'] : die();

	// delete the article
	if ( $article->delete() ) {

		// set response code - 200 ok
		http_response_code( 200 );

		// tell the user
		echo json_encode( array( "message" => "Article was deleted." ) );
	}

	// if unable to delete the article
	else {

		// set response code - 503 service unavailable
		http_response_code( 503 );

		// tell the user
		echo json_encode( array( "message" => "Unable to delete article." ) );
	}
}
?>