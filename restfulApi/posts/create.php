<?php

include_once '../../db.php';
include_once '../auth.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($_COOKIE['session_token'])) {
    $sessionId = $_COOKIE['session_token'];
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Unauthorized."));
}

if(!empty($data->title) && !empty($data->content) && !empty($sessionId)) {
    $user_id = authenticate($mysqli, $sessionId);
    if($user_id) {
        $stmt = $mysqli->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $data->title, $data->content, $user_id);

        if($stmt->execute()) {
            http_response_code(201);
            echo json_encode(array("message" => "Post created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create post."));
        }

        $stmt->close();
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Unauthorized."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}

?>
