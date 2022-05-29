<?php

    require_once("../dbconfig.php");

    session_start();

    if(isset($_SESSION["username"])){

        $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);


        $SQL = "SELECT I.ID, I.Utente, U.GifProfilo, I.Titolo, I.Descrizione, I.Data, I.Stato, I.Sorrisi, I.NCommenti 
        FROM Indovinelli I, Utenti U
        where I.Utente=U.Username AND ";

        if(isset($_GET['lista'])){
            $SQL = $SQL."I.Utente = '". $_SESSION["username"] ."' order by I.Stato DESC";
        }
        else if(isset($_GET['utente'])){
            $utente = mysqli_real_escape_string($conn, $_GET['utente']);
            if(isset($_GET['minSorrisi']) && isset($_GET['maxTimeStamp'])){
                $minSorrisi = mysqli_real_escape_string($conn, $_GET['minSorrisi']);
                $maxTimeStamp = mysqli_real_escape_string($conn, $_GET['maxTimeStamp']);
                $maxDate = date('Y-m-d H:i:s', $maxTimeStamp);

                $SQL = $SQL."I.Utente = '". $utente ."' AND I.Stato='ACCETTATO' AND (I.Sorrisi<".$minSorrisi." OR (I.Sorrisi=".$minSorrisi." AND I.Data>'".$maxDate."')) order by I.Sorrisi DESC, I.Data LIMIT 10";
            }
            else
            $SQL = $SQL."I.Utente = '". $utente ."' AND I.Stato='ACCETTATO' order by I.Sorrisi DESC LIMIT 10";
        }
        else
            if(isset($_GET['minSorrisi']) && isset($_GET['maxTimeStamp'])){
                $minSorrisi = mysqli_real_escape_string($conn, $_GET['minSorrisi']);
                $maxTimeStamp = mysqli_real_escape_string($conn, $_GET['maxTimeStamp']);
                $maxDate = date('Y-m-d H:i:s', $maxTimeStamp);

                $SQL = $SQL."I.Utente not like '". $_SESSION["username"] ."' AND I.Stato='ACCETTATO' AND (I.Sorrisi<".$minSorrisi." OR (I.Sorrisi=".$minSorrisi." AND I.Data>'".$maxDate."')) order by I.Sorrisi DESC LIMIT 10";
            }
            else
                $SQL = $SQL."I.Utente not like '". $_SESSION["username"] ."' AND I.Stato='ACCETTATO' order by I.Sorrisi DESC LIMIT 10";

        $result = mysqli_query($conn, $SQL);
        $output=[];
        while($row = mysqli_fetch_assoc($result))
            $output[] = $row;

        echo json_encode($output);

        mysqli_free_result($result);
        mysqli_close($conn);
    }
    
?>