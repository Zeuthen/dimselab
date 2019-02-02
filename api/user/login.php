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
		// include database and object files
		require_once '../config/database.php';
		require_once '../objects/user.php';

		// initialize object
		$user = new User( $conn );

		// get posted data
		//$data = json_decode( file_get_contents( "php://input" ) );

		if ( isset( $_POST['email'] ) && isset( $_POST['password'] ) )
		{
			// set user property values
			$user->email    = $_POST['email'];
			$user->password = $_POST['password'];

			$stmt = $user->login();

			if ( $user->id != null )
			{
				// set response code - 200 OK
				http_response_code( 200 );

				session_start();
				$_SESSION["USER"]    = $user->name;
				$_SESSION["USER_ID"] = $user->id;

				// tell the user
				echo json_encode( array( "message" => "login was successful" ) );
			}
			// if unable to create the login, tell the user
			else
			{
				// set response code - 501 Not Implemented
				http_response_code( 501 );

				// tell the user
				echo json_encode( array( "message" => "Unable to create user." ) );
			}
		}
		// tell the user data is incomplete
		else
		{
			// set response code - 400 bad request
			http_response_code( 400 );

			// tell the user
			echo json_encode( array( "message" => "Unable to create user. Data is incomplete." ) );
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