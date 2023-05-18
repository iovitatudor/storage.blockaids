<?php

function getMyUrl()
{
    $protocol = (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) ? 'https://' : 'http://';
    $server = $_SERVER['SERVER_NAME'];
    $port = $_SERVER['SERVER_PORT'] ? ':'.$_SERVER['SERVER_PORT'] : '';
    return 'https://'.$server.$port;
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $json = file_get_contents('json-data/collections.json');
    $json_data = json_decode($json);
    $key = array_search($id, array_column($json_data, "id"));

    if ($key) {
        header('Content-type: application/json');
        $nftJson = $json_data[$key];
        unset($nftJson->id);
        echo json_encode($nftJson);
    } else {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
        echo "No found NFT, try again!";
        die();
    }
} else {
    $json = file_get_contents('json-data/collections.json');
    $json_data = json_decode($json);
    echo "<table>";
    foreach ($json_data as $key => $item) {
        echo "<tr><td>";
        echo $item->name;
        echo "<hr/></td>";
        echo "<td><a href='" . $_SERVER['REQUEST_URI'] . "?id=" . $item->id . "'>";
        echo getMyUrl() . "?id=" . $item->id;
        echo "</a><hr/></td>";
        echo "</tr>";
    }
    echo "</table>";
}
