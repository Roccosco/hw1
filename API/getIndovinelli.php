<?php

    require_once("../dbconfig.php");

    session_start();

    if(isset($_SESSION["username"])){

        $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

        if(isset($_GET['lista'])){
            $SQL = "SELECT * FROM Indovinelli where Utente = '". $_SESSION["username"] ."' order by Stato DESC";
        }
        else if(isset($_GET['utente'])){
            $utente = mysqli_real_escape_string($conn, $_GET['utente']);
            if(isset($_GET['minSorrisi'])){
                $minSorrisi = mysqli_real_escape_string($conn, $_GET['minSorrisi']);
                $SQL = "SELECT * FROM Indovinelli where Utente = '". $utente ."' AND Stato='ACCETTATO' AND Sorrisi<".$minSorrisi." order by Sorrisi DESC LIMIT 10";
            }
            else
            $SQL = "SELECT * FROM Indovinelli where Utente = '". $utente ."' AND Stato='ACCETTATO' order by Sorrisi DESC LIMIT 10";
        }
        else
            if(isset($_GET['minSorrisi'])){
                $minSorrisi = mysqli_real_escape_string($conn, $_GET['minSorrisi']);
                $SQL = "SELECT * FROM Indovinelli where Utente not like '". $_SESSION["username"] ."' AND Stato='ACCETTATO' AND Sorrisi<".$minSorrisi." order by Sorrisi DESC LIMIT 10";
            }
            else
                $SQL = "SELECT * FROM Indovinelli where Utente not like '". $_SESSION["username"] ."' AND Stato='ACCETTATO' order by Sorrisi DESC LIMIT 10";

        $result = mysqli_query($conn, $SQL);
        $output=[];
        while($row = mysqli_fetch_assoc($result))
            $output[] = $row;

        echo json_encode($output);
    }
    
?>