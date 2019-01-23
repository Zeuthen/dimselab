<?php
    session_start();
    
    require_once "config.php";
    
    try
    {
        
        if(isset($_POST["artikel"]) && isset($_POST["stregkode"]) && isset($_POST["projekt"]) && isset($_SESSION["userid"]))
        {

            /*$sql = "INSERT INTO projekter (Navn, Beskrivelse, FK_artikel_ID, FK_bruger_ID)
					VALUES (:projekt, :beskrivelse, (SELECT artikler.ID as Artikel FROM artikler WHERE artikler.Navn = :artikel LIMIT 1), :bruger)";

            $sth = $conn->prepare($sql);
            $sth->bindParam(':projekt', $_POST["projekt"], PDO::PARAM_STR);
            $sth->bindParam(':beskrivelse', $_POST["beskrivelse"], PDO::PARAM_STR);
            $sth->bindParam(':artikel', $_POST["artikel"], PDO::PARAM_STR);
            $sth->bindParam(':bruger', $_SESSION["userid"], PDO::PARAM_INT);
            $sth->execute();*/

            $sql = "INSERT INTO statistik (FK_artikel_ID, FK_bruger_ID, FK_projekt_ID)
					VALUES ((SELECT artikler.ID FROM artikler WHERE artikler.Stregkode = :stregkode LIMIT 1), :bruger, 
					:projekt)";
            
            $sth = $conn->prepare($sql);
	        $sth->bindParam(':stregkode', $_POST["stregkode"], PDO::PARAM_STR);
            $sth->bindParam(':bruger', $_SESSION["userid"], PDO::PARAM_INT);
            $sth->bindParam(':projekt', $_POST["projekt"], PDO::PARAM_INT);
            $sth->execute();
        }
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
?>