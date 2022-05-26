<?php

    require_once("dbconfig.php");

    session_start();

    if(isset($_SESSION["username"])){
        header("Location: home.php");
        exit;
    }

    if(isset($_POST["username"]) && isset($_POST["password"])) {
        $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

        $username=mysqli_real_escape_string($conn, $_POST['username']);
        $password =mysqli_real_escape_string($conn, $_POST['password']);

        $SQL = "SELECT PasswordHash FROM Utenti where Username='".$username."'";
        $result = mysqli_query($conn, $SQL);
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_assoc($result);

            if(password_verify($password, $row['PasswordHash'])) {
                $_SESSION["username"] = $username;
                header("Location: home.php");
                exit;
            }
            else{
                $errore = true;
            }
        }
        else{
            $errore = true;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport"content="width=device-width, initial-scale=1">

        <title>Riddler - Login</title>

        <link rel="stylesheet" href="mainStyle.css"/>
        <link rel="stylesheet" href="loginSignup.css"/>
        <script src="scripts/login.js" defer="true"></script>
    </head>
    <body>
        <section id="main">
            <div class="leftPresentazione">
                <img src="img/Logo.png">
            </div>
            <form name="login" method='post'>
                <h3>Accedi</h3>
                <div class="formContent spaziati">
                    <label>Username: </label>
                    <input id="username" type="text" name="username" <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                </div>
                <div class="formContent spaziati">
                    <label>Password: </label>
                    <input id="password" type="text" name="password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                </div>

                <div class = 'serverError'>
                    <?php if(isset($errore)){ echo "Username o Password errati! "; } ?>
                </div>

                <div class="formContent">
                    <input id = "loginButton" type="submit" value="Login" >
                </div>
                
                <div class="login">
                    Non hai un account? <a href="signup.php">Registrati</a>
                </div>
                
            </form>
        </section>
    </body>
</html>

