<?php
require_once "database1.php";

try
{
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
			echo "<td><a href='#' data-project-id='" . $row["ProjektID"] . "' data-project='" . $row["Projekt"] . "'>Slet</a></td>";
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