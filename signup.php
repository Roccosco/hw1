<?php

    require_once("dbconfig.php");

    session_start();

    $errore=false;

    if(isset($_SESSION["username"])){
        header("Location: home.php");
        exit;
    }

    if(isset($_POST["hidden"]))
    if(isset($_POST["nome"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["conferma"]) && isset($_POST["email"]) && 
    isset($_POST["dataNascita"]) && isset($_POST["sesso"])) {
        $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

        $nome=mysqli_real_escape_string($conn, $_POST['nome']);
        $username= $_POST['username'];
        $password = $_POST['password'];
        $confirm = $_POST['conferma'];
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        $email =mysqli_real_escape_string($conn, $_POST['email']);
        $dataNascita =mysqli_real_escape_string($conn, $_POST['dataNascita']);
        $sesso =mysqli_real_escape_string($conn, $_POST['sesso']);

        if($sesso!="M" && $sesso!="F")
            $errore=true;
            
        if (strlen($password) < 8 || !preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/', $password))
            $errore = true;
        if (strcmp($password, $confirm))
            $errore = true;

        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $username))
            $errore=true;
        else{
            $query = "SELECT Username FROM utenti WHERE Username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0)
                $errore = true;
        }
        
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $errore = true;
        else{
            $query = "SELECT Email FROM utenti WHERE Email = '$email'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0)
                $errore = true;
        }

        $dateTimestamp = strtotime($dataNascita);
        if(!$dateTimestamp || $dateTimestamp < strtotime("1900-01-01") || $dateTimestamp > strtotime(date("Y-m-d"))){
            $errore = true;
        }

        if(!$errore) {
            $SQL = "INSERT INTO Utenti (Username, PasswordHash, Email, Nome, DataNascita, Sesso, GifProfilo) 
            VALUES ('".$username."','".$passwordhash."','".$email."','".$nome."','".$dataNascita."','".$sesso."', NULL)";
            $result = mysqli_query($conn, $SQL);
            if($result) {
                $_SESSION["username"] = $username;
                header("Location: home.php");
                
                mysqli_close($conn);
                exit;
            }
            else{
                $errore = true;
            }
        }

        mysqli_close($conn);
    }
    else
        $errore=true;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport"content="width=device-width, initial-scale=1">

        <title>Riddler - Registrati</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="styles/mainStyle.css"/>
        <link rel="stylesheet" href="styles/loginSignup.css"/>
        <script src="scripts/signup.js" defer="true"></script>
    </head>
    <body>
        <section id="main">
            <div class="leftPresentazione">
                <div>
                    <img src="img/Logo.png">
                </div>
                <div id="slideshow-container">
                    <a class="prev">&#10094;</a>
                    <a class="next">&#10095;</a>
                </div>
            </div>
            <div id="dati">
                <form method="POST" >
                    <h3>Registrati</h3>
                    <input type="hidden" name="hidden" value="web"/>
                    <div class="formContent">
                        <label>Nome: </label>
                        <input id="nome" type="text" name="nome" <?php if(isset($_POST["nome"])){echo "value=".$_POST["nome"];} ?>>
                        <div class="divError">
                            Nome vuoto
                        </div>
                    </div>
                    <div class="formContent">
                        <label>Username: </label>
                        <input id="username" type="text" name="username" <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                        <div class="divError">
                            Inserisci solo lettere, numeri e underscore. Max. 64
                        </div>
                    </div>
                    <div class="formContent">
                        <label>Password: </label>
                        <input id="password" type="password" name="password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                        <div class="divError">
                            La password deve contenere almeno 8 caratteri
                        </div>
                    </div>
                    <div class="formContent">
                        <label>Conferma Password: </label>
                        <input id="conferma" type="password" name="conferma" <?php if(isset($_POST["conferma"])){echo "value=".$_POST["conferma"];} ?>>
                        <div class="divError">
                            Le due password non coincidono
                        </div>
                    </div>
                    <div class="formContent">
                        <label>Email: </label>
                        <input id="email" type="text" name="email" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                        <div class="divError">
                            Email non valida
                        </div>
                    </div>
                    <div class="formContent" id="altriCampi">
                        <div class="formContent" id="dataInput">
                            <label>Data di nascita: </label>
                            <input id="dataNascita" type="date" name="dataNascita" <?php if(isset($_POST["dataNascita"])){echo "value=".$_POST["dataNascita"];} ?>>
                            <div class="divError">
                                Data non valida
                            </div>
                        </div>
                        <div class="formContent" id="sessoInput">
                            <label>Sesso: </label>
                            <label>M <input type="radio" class="radio" name="sesso" value="M" <?php if(isset($_POST["sesso"])){if($_POST["sesso"] == 'M') echo "checked=true";} ?>></label>
                            <label>F <input type="radio" class="radio" name="sesso" value="F" <?php if(isset($_POST["sesso"])){if($_POST["sesso"] == 'F') echo "checked=true";} ?>></label>
                        </div>
                    </div>
                    <?php if($errore) echo "<span class='serverError'>Controlla i campi!</span>" ?>
                    <input id = "signupButton" type="submit" value="Signup!" disabled=true>
                </form>
                <div class="login">
                    Hai già un account? <a href="login.php">Accedi</a>
                </div>
            </div>
        </section>
    </body>
</html>

