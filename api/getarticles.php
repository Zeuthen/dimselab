<?php
require_once "config.php";

try
{
	$result = "";
	if ( isset( $_GET["search"] ) )
	{
		$sql    = "SELECT artikler.ID as ArtikelID, artikler.Navn as Artikel, artikler.Skuffenummer, artikler.Stregkode, artikler.AntalUde, artikler.Antal, FK_kategori_ID as KategoriID, kategorier.Navn as Kategori
				FROM artikler
				INNER JOIN kategorier ON kategorier.ID = artikler.FK_kategori_ID 
				WHERE artikler.Navn LIKE :artikel";
		$sth    = $conn->prepare( $sql );
		$search = "%" . $_GET["search"] . "%";
		$sth->bindParam( ':artikel', $search, PDO::PARAM_STR );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	}
	else
	{
		$sql = "SELECT artikler.ID as ArtikelID, artikler.Navn as Artikel, artikler.Skuffenummer, artikler.Stregkode, artikler.AntalUde, artikler.Antal, FK_kategori_ID as KategoriID, kategorier.Navn as Kategori
				FROM artikler 
				INNER JOIN kategorier ON kategorier.ID = artikler.FK_kategori_ID";
		$sth = $conn->prepare( $sql );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	}


	if ( count( $result ) > 0 )
	{
		foreach ( $result as $row )
		{
			echo "<tr>";
			echo "<td>" . $row["Artikel"] . "</td>";
			echo "<td>" . $row["Kategori"] . "</td>";
			echo "<td>" . $row["Stregkode"] . "</td>";
			echo "<td>" . $row["Skuffenummer"] . "</td>";
			echo "<td>" . abs( $row["Antal"] - $row["AntalUde"] ) . "</td>";
			echo "<td>" . $row["AntalUde"] . "</td>";
			echo "<td>" . $row["Antal"] . "</td>";
			echo "<td><a href='#' data-toggle='modal' data-target='#editArticleModal' data-article-id='" . $row["ArtikelID"] . "' data-article='" .
			     $row["Artikel"] . "' data-category='" . $row["KategoriID"] . "' data-stregkode='" . $row["Stregkode"] . "' data-skuffenummer='" .
			     $row["Skuffenummer"] . "' data-antal='" . $row["Antal"] . "'>Slet/Redigér</a></td>";
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
catch( PDOException $e )
{
	echo $e->getMessage();
}
?>