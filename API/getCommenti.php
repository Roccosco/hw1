<?php

    require_once("../dbconfig.php");

    session_start();

    if(isset($_SESSION["username"]) && isset($_GET["indovinello"])){

        $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

        $indovinello=mysqli_real_escape_string($conn, $_GET["indovinello"]);

        if(isset($_GET['minSorrisi'])){
            $minSorrisi = mysqli_real_escape_string($conn, $_GET['minSorrisi']);
            $SQL = "SELECT C.ID, C.Utente, C.Indovinello, C.Testo, C.Data, C.Sorrisi, EXISTS(SELECT S.Utente FROM Sorrisi S WHERE S.Commento = C.ID AND S.Utente = '".$_SESSION["username"]."') AS MessoSorriso FROM Commenti C where C.Indovinello=". $indovinello ." AND C.Sorrisi<".$minSorrisi." order by C.Sorrisi DESC LIMIT 10";
        }
        else
            $SQL = "SELECT C.ID, C.Utente, C.Indovinello, C.Testo, C.Data, C.Sorrisi, EXISTS(SELECT S.Utente FROM Sorrisi S WHERE S.Commento = C.ID AND S.Utente = '".$_SESSION["username"]."') AS MessoSorriso FROM Commenti C where C.Indovinello=". $indovinello ." order by C.Sorrisi DESC LIMIT 10";

        $result = mysqli_query($conn, $SQL);
        $output=[];
        while($row = mysqli_fetch_assoc($result))
            $output[] = $row;

        echo json_encode($output);
    }
    
?>