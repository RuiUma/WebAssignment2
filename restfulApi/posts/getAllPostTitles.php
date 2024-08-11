<?php
    include_once '../../db.php';

    $data = json_decode(file_get_contents("php://input"));
    
    $query = "SELECT id, title FROM posts";

    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $postSums = array();
    while ($row = $result->fetch_assoc()) {
        array_push($postSums, $row);
    }
    http_response_code(200);
    echo json_encode($postSums);
?>