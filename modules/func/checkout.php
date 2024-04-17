<?php

session_start();

function checkout($bearerToken)
{
    if (empty($bearerToken)) {
        return ["error" => "Bearer token not found in request payload"];
    }

    $url = "http://192.168.2.10:8083/cinema/checkout";
    $options = [
        'http' => [
            'header' => "Authorization: Bearer $bearerToken"
        ]
    ];
    $context = stream_context_create($options);
    $data = @file_get_contents($url, false, $context);

    if ($data !== false) {
        $result = json_decode($data, true);
        if ($result !== null) {
            return $result;
        } else {
            return ["error" => "Failed to decode JSON"];
        }
    } else {
        return ["error" => "Failed to fetch data from the URL"];
    }
}

$payload = json_decode(file_get_contents('php://input'), true);
$bearerToken = $payload['token'] ?? null;

header('Content-Type: application/json');
echo json_encode(checkout($bearerToken));
?>