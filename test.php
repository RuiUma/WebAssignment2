<?php
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data) {
        // echo json_encode($data);

        $key1 = $data['email'];
        $key2 = $data['password'];

        // Process data
        $response = ['status' => 'success', 'email' => $key1, 'password' => $key2];
    } else {
        $response = ['status' => 'error', 'message' => 'No data received'];
    }

    // Send response
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);

?>