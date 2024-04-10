<?php
$url = "http://192.168.2.10:8083/cinema/categories";
$data = file_get_contents($url);

if ($data !== false) {
    $categories = [];
    $result = json_decode($data, true);

    if ($result !== null) {

        return $result;
    } else {
        echo "Failed to decode JSON.";
    }
} else {
    echo "Failed to fetch data from the URL.";
}
?>