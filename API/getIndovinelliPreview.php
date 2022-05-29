<?php

    require_once("../dbconfig.php");


    $conn = mysqli_connect(DBCONFIG["Host"], DBCONFIG["Username"], DBCONFIG["Password"], DBCONFIG["DB"]);

    $SQL = "SELECT Titolo,Descrizione FROM Indovinelli WHERE Stato='ACCETTATO' order by Sorrisi DESC";
    
    $result = mysqli_query($conn, $SQL);
    $output=[];
    while($row = mysqli_fetch_assoc($result))
        $output[] = $row;

    echo json_encode($output);

    mysqli_free_result($result);
    mysqli_close($conn);
?>