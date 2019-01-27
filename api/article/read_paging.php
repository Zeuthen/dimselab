<?php
require_once "database1.php";

try {
	if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		if ( isset( $_POST["search"] ) ) {
			$search = $_POST["search"];
		}
		$sql = "SELECT articles.ID as Article_ID, FK_Category_ID as Category_ID, articles.Name as Article, articles.TrayNumber, articles.Barcode, articles.Stock, 
articles.Quantity, categories.Name as Category
				FROM articles 
				INNER JOIN categories ON categories.ID = articles.FK_Category_ID";
		if ( isset( $search ) ) {
			$sql .= " WHERE articles.Name LIKE :article";
		}
		$sth = $conn->prepare( $sql );
		if ( isset( $search ) ) {
			$searchQuery = "%" . $search . "%";
			$sth->bindParam( ':article', $searchQuery, PDO::PARAM_STR );
		}
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );

		if ( count($result)>0 ) {
			foreach ( $result as $row ) {
				echo "<tr>";
				echo "<td>" . $row["Article"] . "</td>";
				echo "<td>" . $row["Category"] . "</td>";
				echo "<td>" . $row["Barcode"] . "</td>";
				echo "<td>" . $row["TrayNumber"] . "</td>";
				echo "<td>" . $row["Stock"] . "</td>";
				echo "<td>" . abs( $row["Quantity"] - $row["Stock"] ) . "</td>";
				echo "<td>" . $row["Quantity"] . "</td>";
				echo "<td><a href='#' data-toggle='modal' data-target='#editArticleModal' data-article-id='" . $row["Article_ID"] . "' data-article='" . $row["Article"] . "' data-category='" . $row["KategoriID"] . "' data-barcode='" . $row["Stregkode"] . "' data-traynumber='" . $row["TrayNumber"] .
				     "' data-quantity='" . $row["Quantity"] . "'>Redigér</a></td>";
				echo "<td><a href='#' onclick='return confirm_click(\"" . $row["Article_ID"] . "\",\"" . $row["Article"] . "\");' data-article-id='" . $row["Article_ID"] . "' data-article='" . $row["Article"] . "'>Slet</a></td>";
				echo "</tr>";
			}
		}
		else {
			echo "<tr>";
			echo "<td colspan='8'>Ingen artikler fundet</td>";
			echo "</tr>";
		}
	}
}
catch( PDOException $e ) {
	exit( $e->getMessage() );
}
?>