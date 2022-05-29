<?php

    require_once("../dbconfig.php");

    session_start();

    if(isset($_SESSION["username"])){
        if(isset($_POST['oldPassword']) && isset($_POST['newPassword'])){

            $old = $_POST['oldPassword'];
            $new = $_POST['newPassword'];

            if (strlen($new) < 8 || !preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/', $new)){
                echo 0;
                exit;
            }

            $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

            $SQL = "SELECT PasswordHash FROM Utenti where Username='".$_SESSION["username"]."'";
            $result = mysqli_query($conn, $SQL);
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_assoc($result);
    
                if(password_verify($old, $row['PasswordHash'])) {
                    $hash = password_hash($new, PASSWORD_DEFAULT);

                    $SQL = "UPDATE Utenti set PasswordHash='".$hash."' where Username='".$_SESSION["username"]."'";
                    $result = mysqli_query($conn, $SQL);
                    if($result){
                        echo 1;
                        exit;
                    }
                }
            }
            
            mysqli_close($conn);
        }
    }
    echo 0;
?>