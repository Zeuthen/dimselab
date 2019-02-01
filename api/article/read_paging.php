<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: GET" );
header( "Content-Type: application/json; charset=UTF-8" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
{
	// include database and object files
	require_once '../config/core.php';
	require_once '../shared/utilities.php';
	require_once '../config/database.php';
	require_once '../objects/article.php';

	// utilities
	$utilities = new Utilities();

	// initialize object
	$article = new Article( $conn );

	// query articles
	$stmt = $article->readPaging( $from_record_num, $records_per_page );
	$num  = $stmt->rowCount();

	if ( $num > 0 )
	{
		//  articles_array
		$articles_arr             = array();
		$articles_arr["articles"] = array();
		$articles_arr["paging"]   = array();

		while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) )
		{
			//  extract row
			//  this will make $row['name'] to
			//  just $name only
			extract( $row );

			$article_item = array(
				"article_id"          => $article_id,
				"article"     => $article,
				"tray_number" => $tray_number,
				"barcode"     => $barcode,
				"on_loan"     => $on_loan,
				"quantity"    => $quantity,
				"category_id" => $category_id,
				"category.js"    => $category
			);

			array_push( $articles_arr, $article_item );
		}

		// include paging
		$total_rows = $article->count();
		$page_url   = "{$home_url}article/read_paging.php?";
		$paging     = $utilities->getPaging( $page, $total_rows, $records_per_page, $page_url );

		echo json_encode( $articles_arr );

		// set response code - 200 OK
		http_response_code( 200 );
	}
}
?>