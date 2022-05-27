<?php

    require_once("../dbconfig.php");

    session_start();

    if(isset($_SESSION["username"])){
        if(isset($_POST['commento'])){
            $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

            $commento = mysqli_real_escape_string($conn, $_POST['commento']);

            $SQL = "DELETE FROM Sorrisi where 
                Utente='".$_SESSION["username"]."' AND  Commento=".$commento."";
            $result = mysqli_query($conn, $SQL);
            if($result){
                $SQL = "SELECT I.Sorrisi as SorrisiIndovinello, C.Sorrisi as SorrisiCommento FROM Commenti C, Indovinelli I where C.Indovinello=I.ID AND C.ID=".$commento;
                $result = mysqli_query($conn, $SQL);
                $row = mysqli_fetch_assoc($result);
                echo json_encode(array(
                    "sorrisiIndovinello"=> $row["SorrisiIndovinello"], 
                    "sorrisiCommento" => $row["SorrisiCommento"], 
                    "errore" => false
                ));
            }
            else
                echo json_encode(array(
                    "errore" => true
                ));
        }
        else
            echo json_encode(array(
                "errore" => true
            ));

    }
    
?>