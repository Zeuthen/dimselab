<?php
require_once "database1.php";

try
{
	$result = "";
	if ( isset( $_GET["search"] ) )
	{
		$sql    = "SELECT projekter.ID as ProjektID, projekter.Navn as Projekt, projekter.Beskrivelse, brugere.Brugernavn as Bruger
				FROM projekter
				INNER JOIN brugere ON brugere.ID = projekter.FK_bruger_ID
				WHERE projekter.Navn LIKE :project";
		$sth    = $conn->prepare( $sql );
		$search = "%" . $_GET["search"] . "%";
		$sth->bindParam( ':project', $search, PDO::PARAM_STR );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	}
	else
	{
		$sql = "SELECT projekter.ID as ProjektID, projekter.Navn as Projekt, projekter.Beskrivelse, brugere.Brugernavn as Bruger
				FROM projekter
				INNER JOIN brugere ON brugere.ID = projekter.FK_bruger_ID";
		$sth = $conn->prepare( $sql );
		$sth->execute();
		$result = $sth->fetchAll( PDO::FETCH_ASSOC );
	}

	if ( count( $result ) > 0 )
	{
		foreach ( $result as $row )
		{
			echo "<tr>";
			echo "<td>" . $row["Projekt"] . "</td>";
			echo "<td>" . $row["Beskrivelse"] . "</td>";
			echo "<td>" . $row["Bruger"] . "</td>";
			echo "<td><a href='#' data-toggle='modal' data-target='#editProjectModal' data-project-id='" . $row["ProjektID"] . "' data-project='" .
			     $row["Projekt"] . "' data-description='" . $row["Beskrivelse"] . "'>Redigér</a></td>";
			echo "<td><a href='#' onclick='return confirm_click(\"" . $row["ProjektID"] . "\",\"" . $row["Projekt"] . "\");' data-project-id='" .
			     $row["ProjektID"] . "' data-project='" . $row["Projekt"] . "'>Slet</a></td>";
			echo "</tr>";
		}
	}
	else
	{
		echo "<tr>";
		echo "<td colspan='5'>Ingen projekter fundet</td>";
		echo "</tr>";
	}
}
catch( PDOException $e )
{
	echo $e->getMessage();
}
?>