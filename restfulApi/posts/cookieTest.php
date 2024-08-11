<?php

if (isset($_COOKIE['session_token'])) {
    $sessionId = $_COOKIE['session_token'];
}

$data = json_decode(file_get_contents("php://input"));

echo json_encode(array("message" => $sessionId, "id"=> $data->id));
?>