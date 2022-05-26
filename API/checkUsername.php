<?php

    require_once("../dbconfig.php");

    if(isset($_GET["username"])){
        $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

        $username=mysqli_real_escape_string($conn, $_GET['username']);
        
        $SQL = "SELECT * FROM Utenti where Username='".$username."'";
        $result = mysqli_query($conn, $SQL);
        if(mysqli_num_rows($result) > 0) {
            echo 0;
        }
        else{
            echo 1;
        }
    }
?>