<?php

    require_once("../dbconfig.php");

    session_start();

    if(isset($_SESSION["username"])){
        if(isset($_POST['testo']) && strlen($_POST['testo']) > 0 && isset($_POST['indovinello'])){
            $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

            $testo = mysqli_real_escape_string($conn, $_POST['testo']);
            $indovinello = mysqli_real_escape_string($conn, $_POST['indovinello']);

            $SQL = "INSERT INTO Commenti (ID, Utente, Indovinello, Testo, Data, Sorrisi) 
                VALUES (NULL,'".$_SESSION["username"]."',".$indovinello.", '".$testo."', (select now()), 0)";
            $result = mysqli_query($conn, $SQL);
            if($result)
                echo json_encode(array(
                    'ID' => mysqli_insert_id($conn)."",
                    'Utente' => $_SESSION["username"],
                    'Indovinello' => $indovinello,
                    'Testo' => $_POST['testo'],
                    'Data' => date('Y-m-d H:i:s'),
                    'Sorrisi' => 0
                ));
            else
                die("Errore: qualcosa è andato storto!");
        }
        else
            die("Errore: mancano informazioni necessarie");

    }
    
?>