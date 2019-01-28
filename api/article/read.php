<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: GET" );
header( "Content-Type: application/json; charset=UTF-8" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
{
	// include database and object files
	require_once '../config/database.php';
	require_once '../objects/article.php';

	// initialize object
	$article = new Article( $conn );

	// query articles
	$stmt = $article->read();
	$num  = $stmt->rowCount();

	// check if more than 0 record found
	if ( $num > 0 )
	{
		//  categories_array
		$articles_arr = array();

		// set response code - 200 OK
		http_response_code( 200 );

		while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) )
		{
			//  extract row
			//  this will make $row['name'] to
			//  just $name only
			extract( $row );

			$article_item = array(
				"id"          => $article_id,
				"article"     => $article,
				"tray_number" => $tray_number,
				"barcode"     => $barcode,
				"on_loan"     => $on_loan,
				"quantity"    => $quantity,
				"category_id" => $category_id,
				"category"    => $category
			);

			array_push( $articles_arr, $article_item );
		}
		echo json_encode( $articles_arr );
	}
	// no articles found will be here
	else
	{
		// set response code - 404 Not found
		http_response_code( 404 );

		// tell the user no articles found
		echo json_encode( array( "message" => "Ingen artikler fundet." ) );

		echo "<tr>";
		echo "<td colspan='8'>Ingen artikler fundet</td>";
		echo "</tr>";
	}
}
?>