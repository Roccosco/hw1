<?php

    require_once("../dbconfig.php");

    session_start();

    if(isset($_SESSION["username"])){
        if(isset($_POST['commento'])){
            $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

            $commento = mysqli_real_escape_string($conn, $_POST['commento']);

            $SQL = "INSERT INTO Sorrisi (Utente, Commento, Data) 
                VALUES ('".$_SESSION["username"]."', ".$commento.", (select now()))";
            $result = mysqli_query($conn, $SQL);
            if($result){
                $SQL = "SELECT Sorrisi FROM Commenti where ID=".$commento;
                $result = mysqli_query($conn, $SQL);
                echo json_encode(array(
                    "sorrisi"=> mysqli_fetch_assoc($result)["Sorrisi"], 
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