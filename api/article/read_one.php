<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: POST" );
header( "Content-Type: text/plain; charset=UTF-8" );
//header( "Content-Type: application/json; charset=UTF-8" );

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
	// include database and object files
	require_once '../config/database.php';
	require_once '../objects/article.php';

	// initialize object
	$article = new Article( $conn );

	// set ID property of record to read
	$article->id = isset( $_POST['barcode'] ) ? $_POST['barcode'] : die();

	// read the details of product to be edited
	$stmt = $article->readOne();

	if ( $article->name != null ) {

		// set response code - 200 OK
		http_response_code( 200 );

		$articles = array();

		while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ) {
			$article_item = array( "article" => $row["article"] );

			array_push( $articles, $article_item );
		}
		/*foreach ( $result as $row ) {
			echo "<tr>";
			echo "<td>" .$row["Artikel"] ."</td>";
			echo "<td>" .$row["Kategori"] ."</td>";
			echo "<td>" .$row["Stregkode"] ."</td>";
			echo "<td>" .$row["Skuffenummer"] ."</td>";
			echo "<td>" .$row["Antal"] ."</td>";
			echo "</tr>";
		}*/

		// make it json format
		echo json_encode( $articles );
	}
}
?>