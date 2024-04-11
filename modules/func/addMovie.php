<?php

function addMovieFromPayload($payload)
{
    $payloadData = json_decode($payload, true);

    if ($payloadData === null) {
        return json_encode(array("error" => "Invalid JSON payload"));
    }
    if (empty($payloadData['token'])) {
        return json_encode(array("error" => "Token not provided"));
    }



    $api_url = 'http://192.168.2.9:8083/cinema/addFilm';

    $jsonData = $payloadData['movieData'];
    $token = $payloadData['token'];

    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n" .
                "Authorization: Bearer " . $token,
            'content' => json_encode($jsonData),
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($api_url, false, $context);

    if ($result === false) {
        return json_encode(array("error" => "Failed to communicate with the API"));
    } else {
        return $result;
    }
}

$payload = file_get_contents('php://input');

echo addMovieFromPayload($payload);
