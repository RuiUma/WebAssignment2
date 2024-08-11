<?php
function authenticate($mysqli, $token) {
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE session_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $user_id = $stmt->get_result()-> fetch_assoc();
    

    $stmt->close();

    return $user_id ? $user_id['id'] : false;
}
?>
