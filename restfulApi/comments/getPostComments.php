<?php
    include_once '../../db.php';

    $data = json_decode(file_get_contents("php://input"));
    
    $query = "select * from comments where post_id = ?";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $data->id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $comments = array();
    while ($data) {
        array_push($comments, $data);
        $data = $result->fetch_assoc();
    }

    http_response_code(200);
    echo json_encode($comments);
?>