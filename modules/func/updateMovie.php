<?php
function updateMovieFromPayload($payload)
{
    // Giải mã dữ liệu từ payload JSON
    $payloadData = json_decode($payload, true);

    if ($payloadData === null) {
        return json_encode(array("error" => "Invalid JSON payload"));
    }

    if (empty($payloadData['id'])) {
        return json_encode(array("error" => "Movie ID not provided"));
    }

    if (empty($payloadData['token'])) {
        return json_encode(array("error" => "Token not provided"));
    }



    $api_url = 'http://192.168.2.10:8083/cinema/updateFilm';

    $jsonData = $payloadData['jsonData'];
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

echo updateMovieFromPayload($payload);