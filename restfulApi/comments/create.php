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

if (!empty($data->post_id) && !empty($data->content) && !empty($sessionId)) {
    $user_id = authenticate($mysqli, $sessionId);
    echo json_encode(array("user_id" => $user_id));
    if ($user_id) {
        $stmt = $mysqli->prepare("INSERT INTO Comments (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $data->post_id, $user_id, $data->content);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("message" => "Comment added."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to add comment."));
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
