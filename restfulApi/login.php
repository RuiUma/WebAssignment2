<?php
    $data = json_decode(file_get_contents('php://input'), true);
    include("../db.php");
    

    if ($data) {

        $email = $data['email'];
        $password = hash('sha512',$data['password']);

        $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE email = ? AND status = 'active'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $response = ['status' => 'error', 'msg' => 'Invalid email or password!', 'session_token' => ''];


        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['password'] === $password) {
                $token = bin2hex(random_bytes(64));
                $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                $stmt = $mysqli->prepare("UPDATE users SET session_token = ?, session_expiry = ? WHERE id = ?");
                $stmt->bind_param("ssi", $token, $expiry, $user['id']);
                $stmt->execute();

                setcookie('session_token', $token, time() + 3600, "/");
                $response['session_token'] = $token;
                $response['status'] = 'success';
                $response['msg'] = 'Login successful!';
            } 
        }
    }

    // Send response
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($response);

?>

