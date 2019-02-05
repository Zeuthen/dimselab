<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Content-Type: application/json; charset=UTF-8" );
header( "Access-Control-Allow-Methods: POST" );
header( "Access-Control-Max-Age: 3600" );
header( "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
{

	try
	{
		// include database and object file
		include_once '../config/database.php';
		include_once '../objects/article.php';

		// prepare article object
		$article = new Article( $conn );

		// get article id
		//$data = json_decode(file_get_contents("php://input"));

		// set article id to be deleted
		if ( isset( $_POST['article_id'] ) )
		{
			$article->id = $_POST['article_id'];
		}

		// delete the article
		if ( $article->delete() )
		{
			// tell the user
			echo json_encode( array( "message" => "Artiklen blev slettet" ) );

			// set response code - 200 OK
			http_response_code( 200 );
		}
		// if unable to delete the article
		else
		{
			// set response code - 503 service unavailable
			http_response_code( 503 );

			// tell the user
			die( json_encode( array( "message" => "Det var ikke muligt at slette artiklen, server fejl" ) ) );

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