<?php

$payload = file_get_contents('php://input');
if (!empty($payload)) {
    $requestData = json_decode($payload, true);

    if (isset($requestData["username"]) && isset($requestData["password"])) {

        require_once ("loginAmin.php");

        $result = login($requestData["username"], $requestData["password"]);

        echo $result;
    } else {
        $response = array("code" => "400", "message" => "Username or password not exist");
        echo json_encode($response);
    }
} else {
    $response = array("code" => "400", "message" => "No data received.");
    echo json_encode($response);
}
