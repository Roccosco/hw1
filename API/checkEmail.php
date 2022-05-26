<?php

    require_once("../dbconfig.php");

    if(isset($_GET["email"])){
        $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

        $email=mysqli_real_escape_string($conn, $_GET['email']);
        
        $SQL = "SELECT * FROM Utenti where Email='".$email."'";
        $result = mysqli_query($conn, $SQL);
        if(mysqli_num_rows($result) > 0) {
            echo 0;
        }
        else{
            echo 1;
        }
    }
?>