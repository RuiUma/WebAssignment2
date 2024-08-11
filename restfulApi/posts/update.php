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

if (!empty($data->id) && !empty($data->title) && !empty($data->content) && !empty($sessionId)) {
    $user_id = authenticate($mysqli, $sessionId);
    if ($user_id) {
        $stmt = $mysqli->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ? ");
        $stmt->bind_param("ssi", $data->title, $data->content, $data->id);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("message" => "Post updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update post."));
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
