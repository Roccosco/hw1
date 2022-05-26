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

        <link rel="stylesheet" href="mainStyle.css"/>
        <link rel="stylesheet" href="home.css"/>
        <script src="scripts/time.js" defer="true"></script>
        <script src="scripts/home.js" defer="true"></script>
    </head>

    <body>
        <nav>
            <div>
                <a class="logo" href="home.php">Riddler</a>
            </div>

            <div class="navbuttons">
                <a class="other" href="indovinelli.php">Indovinelli</a>
                <div id="navbuttons" > 
                    <a class="button">Profilo</a>
                </div>
            </div>
        </nav>

        <header>

        </header>

        <section>
            <div id="container">
                
            </div>
            <a id="newPost" class="caricaAltro">Carica altro</a>
        </section>
    </body>
</html>

