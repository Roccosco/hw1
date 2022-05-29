<?php

    require_once("dbconfig.php");

    session_start();

    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit;
    }

    $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

    $username=mysqli_real_escape_string($conn, $_SESSION['username']);

    $SQL = "SELECT * FROM Utenti where Username='".$username."'";
    $result = mysqli_query($conn, $SQL);
    if(mysqli_num_rows($result) > 0)
        $row = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport"content="width=device-width, initial-scale=1">

        <title>Riddler - Home</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="styles/mainStyle.css"/>
        <link rel="stylesheet" href="styles/profilo.css"/>
        <script src="scripts/profilo.js" defer="true"></script>
    </head>

    <body>
        <main>
        <nav>
            <div>
                <img class="logo" src="img/LogoBeige.png">
            </div>

            <div class="navbuttons">
                <a class="other" href="home.php">Home</a>
                <a class="button" href="indovinelli.php">Indovinelli</a>
            </div>
        </nav>

        <header>
            <h1>PROFILO</h1>
        </header>

        <section class="main">
            <div class="userInfo">
                <h1> <?php echo $row['Username']; ?> </h1>
                <div>
                    <h3>Nome: <span> <?php echo $row['Nome']; ?> </span></h3>
                    <h3>Email: <span> <?php echo $row['Email']; ?> </span></h3>
                    <h3>Data di nascita: <span> <?php echo $row['DataNascita']; ?> </span></h3>
                    <div class="userAction">
                        <button id="modificaPassword">Modifica password</button>
                        <a class="disconnettiti" href="signout.php">Disconnettiti</a>
                    </div>
                </div>
            </div>
            <div class="containerImage">
                <img id="profileImage" src="<?php if($row['GifProfilo'] === null) echo 'img/profilo.png'; else echo $row['GifProfilo']; ?>">
            </div>
        </section>

        <section id="modalGiphy" class="modal hidden">
            <div class="modal-content">
                <button class="closeModale">
                    <span>X</span>
                </button>

                <h2>Modifica icona</h2>

                <div>
                    <input id="textGiphy" type="text" placeholder="Cerca...">
                    <button id="cercaGiphy">Cerca</button>
                </div>

                <div id="containerGif">

                </div>
            </div>
        </section>

        <section id="modalConferma" class="modal hidden">
            <div class="modal-content">
                <img src="img/okcheck.png" class="okcheck">
                <p>Tutto fatto!</p>
                <button class="close">
                    Ok
                </button>
            </div>
        </section>

        <section id="modalPassword" class="modal hidden">
            <div class="modal-content">
                <button class="closeModale">
                    <span>X</span>
                </button>

                <h2>Modifica password</h2>

                <div id="oldPasswordContent" class="passwordContent">
                    <input id="oldPassword" class="passwordText" type="password" placeholder="Vecchia password">
                    <div class="divError">
                        La password è errata
                    </div>
                </div>
                <div class="passwordContent">
                    <input id="newPassword" class="passwordText" type="password" placeholder="Nuova password">
                    <div class="divError">
                        La password deve contenere almeno 8 caratteri
                    </div>
                </div>
                <div class="passwordContent">
                    <input id="confirmPassword" class="passwordText" type="password" placeholder="Conferma nuova password">
                    <div class="divError">
                        Le due password non coincidono
                    </div>
                </div>

                <button id="sendNewPassword">
                    Modifica
                </button>
            </div>
        </section>
        </main>

        <footer>
            <div>
                <p>Riddler</p>
                <p>	Rocco Mattia Di Mauro - <?php echo date("Y"); ?></p>
            </div>
        </footer>
    </body>
</html>

