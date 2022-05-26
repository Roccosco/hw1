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
        <link rel="stylesheet" href="indovinelli.css"/>
        <script src="scripts/time.js" defer="true"></script>
        <script src="scripts/indovinelli.js" defer="true"></script>
    </head>

    <body>
        <nav>
            <div>
                <a class="logo" href="home.php">Riddler</a>
            </div>

            <div class="navbuttons">
                <a class="other" href="home.php">Home</a>
                <div id="navbuttons" > 
                    <a class="button">Profilo</a>
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

        <section class="modal-view hidden">
            <div id="modal-content">
                <button id="closeNewIndovinello">
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
    </body>
</html>
