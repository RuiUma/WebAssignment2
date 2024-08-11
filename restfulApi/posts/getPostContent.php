<?php
    include_once '../../db.php';

    $data = json_decode(file_get_contents("php://input"));
    
    $query = "SELECT * FROM posts WHERE id = ?";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $data->id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    http_response_code(200);
    echo json_encode($post);
?>