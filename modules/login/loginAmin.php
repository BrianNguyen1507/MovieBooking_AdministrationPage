<?php
function login($username, $password)
{
    $requestData = array(
        'user_name' => $username,
        'password' => $password
    );

    $jsonData = json_encode($requestData);

    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => $jsonData,
            'ignore_errors' => true
        )
    );

    $context = stream_context_create($options);

    $response = file_get_contents('http://192.168.2.10:8083/cinema/login', false, $context);

    return $response;

}




