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
	$stmt = $article->readPaging( $from_Record_num, $records_per_page );
	$num  = $stmt->rowCount();

	if ( $num > 0 )
	{
		//  categories_array
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

		// include paging
		$total_rows = $article->count();
		$page_url   = "{$home_url}article/read_paging.php?";
		$paging     = $utilities->getPaging( $page, $total_rows, $records_per_page, $page_url );

		echo json_encode( $articles_arr );

		// set response code - 200 OK
		http_response_code( 200 );
	}
}


try
{
	if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
	{
		if ( isset( $_POST["search"] ) )
		{
			$search = $_POST["search"];
		}
		$sql = "SELECT articles.ID as Article_ID, FK_Category_ID as Category_ID, articles.Name as Article, articles.TrayNumber, articles.Barcode, articles.Stock, 
articles.Quantity, categories.Name as Category
				FROM articles 
				INNER JOIN categories ON categories.ID = articles.FK_Category_ID";
		if ( isset( $search ) )
		{
			$sql .= " WHERE articles.Name LIKE :article";
		}
		$sth = $conn->prepare( $sql );
		if ( isset( $search ) )
		{
			$searchQuery = "%" . $search . "%";
			$sth->bindParam( ':article', $searchQuery, PDO::PARAM_STR );
		}
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );

		if ( count( $result ) > 0 )
		{
			foreach ( $result as $row )
			{
				echo "<tr>";
				echo "<td>" . $row["Article"] . "</td>";
				echo "<td>" . $row["Category"] . "</td>";
				echo "<td>" . $row["Barcode"] . "</td>";
				echo "<td>" . $row["TrayNumber"] . "</td>";
				echo "<td>" . $row["Stock"] . "</td>";
				echo "<td>" . abs( $row["Quantity"] - $row["Stock"] ) . "</td>";
				echo "<td>" . $row["Quantity"] . "</td>";
				echo "<td><a href='#' data-toggle='modal' data-target='#editArticleModal' data-article-id='" . $row["Article_ID"] .
				     "' data-article='" . $row["Article"] . "' data-category='" . $row["KategoriID"] . "' data-barcode='" . $row["Stregkode"] .
				     "' data-traynumber='" . $row["TrayNumber"] . "' data-quantity='" . $row["Quantity"] . "'>Redigér</a></td>";
				echo "<td><a href='#' onclick='return confirm_click(\"" . $row["Article_ID"] . "\",\"" . $row["Article"] . "\");' data-article-id='" .
				     $row["Article_ID"] . "' data-article='" . $row["Article"] . "'>Slet</a></td>";
				echo "</tr>";
			}
		}
		else
		{
			echo "<tr>";
			echo "<td colspan='8'>Ingen artikler fundet</td>";
			echo "</tr>";
		}
	}
}
catch( PDOException $e )
{
	exit( $e->getMessage() );
}
?>