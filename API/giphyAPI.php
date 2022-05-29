<?php

    $apikey = "1D02q4R5AJcTgyT1nqQj5aThJpONVIfe";
    
    if(!isset($_GET["q"]))
        die("Errore");

    $searchContent=$_GET['q'];
    $page=$_GET['page'];
    $offset = $page*20;

    $url = "https://api.giphy.com/v1/gifs/search?q=".urlencode($searchContent)."&limit=20&offset=".$offset."&api_key=".$apikey;
    
    $curl=curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data=curl_exec($curl);
    curl_close($curl);

    $json = json_decode($data, true);
    $newJson = array();
    foreach ($json['data'] as $gif)
        $newJson[] = $gif['images']['original']['url'];

    echo json_encode($newJson);

?>