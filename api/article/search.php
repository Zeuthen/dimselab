<?php
// required headers
header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: POST" );
header( "Content-Type: text/plain; charset=UTF-8" );
//header("Content-Type: application/json; charset=UTF-8");

if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
	// include database and object files
	include_once '../config/core.php';
	include_once '../config/database.php';
	include_once '../objects/article.php';

	// initialize object
	$article = new Article( $conn );

	// get keywords
	$keywords = isset( $_POST["search"] ) ? $_POST["search"] : "";

	// query articles
	$stmt = $article->search( $keywords );
	$num  = $stmt->rowCount();

	// check if more than 0 record found
	if ( $num > 0 ) {
		// set response code - 200 OK
		http_response_code( 200 );

		while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ) {
			echo "<tr>";
			echo "<td>" . $row["article"] . "</td>";
			echo "<td>" . $row["category"] . "</td>";
			echo "<td>" . $row["barcode"] . "</td>";
			echo "<td>" . $row["tray_number"] . "</td>";
			echo "<td>" . abs( $row["quantity"] - $row["on_loan"] ) . "</td>";
			echo "<td>" . $row["on_loan"] . "</td>";
			echo "<td>" . $row["quantity"] . "</td>";
			echo "<td><a href='#' data-toggle='modal' data-target='#editArticleModal' data-article-id='" . $row["article_id"] . "' data-article='" . $row["article"] . "' data-category='" . $row["category_id"] . "' data-barcode='" . $row["barcode"] . "' data-traynumber='" . $row["tray_number"] .
			     "' data-quantity='" . $row["quantity"] . "'>Redigér</a></td>";
			echo "<td><a href='#' onclick='return confirm_click(\"" . $row["article_id"] . "\",\"" . $row["article"] . "\");' data-article-id='" . $row["article_id"] . "' data-article='" . $row["article"] . "'>Slet</a></td>";
			echo "</tr>";
		}
	}
	// no articles found will be here
	else {
		// set response code - 404 Not found
		http_response_code( 404 );


		// tell the user no articles found
		echo "<tr>";
		echo "<td colspan='8'>Ingen artikler fundet</td>";
		echo "</tr>";
	}
}
?>