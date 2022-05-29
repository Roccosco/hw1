<?php

    require_once("../dbconfig.php");

    session_start();

    if(isset($_SESSION["username"]) && isset($_GET["indovinello"])){

        $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

        $indovinello=mysqli_real_escape_string($conn, $_GET["indovinello"]);

        if(isset($_GET['minSorrisi']) && isset($_GET['maxTimeStamp'])){
            $minSorrisi = mysqli_real_escape_string($conn, $_GET['minSorrisi']);
            $maxTimeStamp = mysqli_real_escape_string($conn, $_GET['maxTimeStamp']);
            $maxDate = date('Y-m-d H:i:s', $maxTimeStamp);

            $SQL = "SELECT C.ID, C.Utente, U.GifProfilo, C.Indovinello, C.Testo, C.Data, C.Sorrisi, 
                EXISTS(SELECT S.Utente FROM Sorrisi S WHERE S.Commento = C.ID AND S.Utente = '".$_SESSION["username"]."') AS MessoSorriso 
            FROM Commenti C, Utenti U 
            where C.Indovinello=". $indovinello ." AND (C.Sorrisi<".$minSorrisi." OR (C.Sorrisi=".$minSorrisi." AND C.Data>'".$maxDate."')) AND C.Utente = U.Username order by C.Sorrisi DESC, C.Data LIMIT 10";
        }
        else
            $SQL = "SELECT C.ID, C.Utente, U.GifProfilo, C.Indovinello, C.Testo, C.Data, C.Sorrisi,
                EXISTS(SELECT S.Utente FROM Sorrisi S WHERE S.Commento = C.ID AND S.Utente = '".$_SESSION["username"]."') AS MessoSorriso 
            FROM Commenti C, Utenti U 
            where C.Indovinello=". $indovinello ." AND C.Utente = U.Username order by C.Sorrisi DESC, C.Data LIMIT 10";

        $result = mysqli_query($conn, $SQL);
        $output=[];
        while($row = mysqli_fetch_assoc($result))
            $output[] = $row;

        echo json_encode($output);

        mysqli_free_result($result);
        mysqli_close($conn);
    }
    
?>