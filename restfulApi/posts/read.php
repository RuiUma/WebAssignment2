<?php

include_once '../../db.php';

$query = "SELECT p.id, p.title, p.content, p.created_at, u.name as author 
          FROM posts p 
          JOIN users u ON p.user_id = u.id 
          ORDER BY p.created_at DESC";

$result = $mysqli->query($query);

if($result->num_rows > 0) {
    $posts_arr = array();
    while ($row = $result->fetch_assoc()) {
        $post_item = array(
            "id" => $row['id'],
            "title" => $row['title'],
            "content" => $row['content'],
            "author" => $row['author'],
            "created_at" => $row['created_at']
        );
        array_push($posts_arr, $post_item);
    }
    http_response_code(200);
    echo json_encode($posts_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No posts found."));
}
?>
