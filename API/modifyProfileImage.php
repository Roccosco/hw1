<?php

    require_once("../dbconfig.php");

    session_start();

    if(isset($_SESSION["username"])){
        if(isset($_POST['url'])){
            $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

            $url = mysqli_real_escape_string($conn, $_POST['url']);

            $SQL = "UPDATE Utenti set GifProfilo='".$url."' where Username='".$_SESSION["username"]."'";
            $result = mysqli_query($conn, $SQL);
            if($result){
                echo 1;
                exit;
            }

            mysqli_close($conn);
        }
    }
    echo 0;
?>