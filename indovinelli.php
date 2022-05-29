<?php

    require_once("dbconfig.php");

    session_start();

    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit;
    }
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
        <link rel="stylesheet" href="styles/indovinelli.css"/>
        <script src="scripts/time.js" defer="true"></script>
        <script src="scripts/indovinelli.js" defer="true"></script>
    </head>

    <body>
        <main>
        <nav>
            <div>
                <img class="logo" src="img/LogoBeige.png">
            </div>

            <div class="navbuttons">
                <a class="other" href="home.php">Home</a>
                <div id="navbuttons" > 
                    <a class="button" href="profilo.php">Profilo</a>
                </div>
            </div>
        </nav>

        <header>
            <h1>I MIEI INDOVINELLI</h1>
        </header>

        <section>
            <div id="container">
                <button id="showModal">
                    <span>+</span>
                </button>
            </div>
        </section>

        <section id="modalIndovinelli" class="modal hidden">
            <div class="modal-content">
                <button class="closeModale">
                    <span>X</span>
                </button>

                <h2>Aggiungi un indovinello</h2>

                <input id="titolo" class="newIndovinelloText" type="text" placeholder="Titolo">
                <textarea class="newIndovinelloText newTesto" type="text" placeholder="Indovinello"></textarea>
                <input id="soluzione" class="newIndovinelloText" type="text" placeholder="Soluzione proposta">

                <button id="newIndovinelloButton">
                    Aggiungi
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

