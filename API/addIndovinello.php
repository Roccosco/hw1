<?php

    require_once("../dbconfig.php");

    session_start();

    if(isset($_SESSION["username"])){
        if(isset($_POST['titolo']) && strlen($_POST['titolo']) > 0 && isset($_POST['descrizione']) && strlen($_POST['descrizione']) > 0){
            $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

            $descrizione = mysqli_real_escape_string($conn, $_POST['descrizione']);
            $titolo = mysqli_real_escape_string($conn, $_POST['titolo']);
            if(isset($_POST['soluzione']))
                $soluzione=$_POST['soluzione'];
            else
                $soluzione="";

            $SQL = "INSERT INTO Indovinelli (ID, Utente, Titolo, Descrizione, Soluzione, Data, Stato) 
                VALUES (NULL,'".$_SESSION["username"]."','".$titolo."', '".$descrizione."','".$soluzione."', (select now()), 'ATTESA')";
            $result = mysqli_query($conn, $SQL);
            if($result)
                echo json_encode(array(
                    'ID' => mysqli_insert_id($conn)."",
                    'Utente' => $_SESSION["username"],
                    'Titolo' => $_POST['titolo'],
                    'Descrizione' => $_POST['descrizione'],
                    'Soluzione' => $soluzione,
                    'Data' => date('Y-m-d H:i:s'),
                    'Stato' => "ATTESA",
                    'Sorrisi' => 0,
                    'NCommenti' => 0
                )); 
            else
                die("Errore: qualcosa è andato storto!");
        }
        else
            die("Errore: manca la descrizione");

    }
    
?>