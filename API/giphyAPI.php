<?php

    $apikey = "123";
    
    if(!isset($_GET["q"]))
        die("Errore");

    $searchContent=$_GET['q'];

    $url = "http://api.giphy/q=".$searchContent."&api_key=".$apikey;

    $curl=curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data=curl_exec($curl);
    curl_close($curl);

    echo $data;
?>