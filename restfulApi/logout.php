<?php
    include("../db.php");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_COOKIE['session_token'])) {
            $sessionId = $_COOKIE['session_token'];

            $stmt = $mysqli->prepare("UPDATE users SET session_token = null, session_expiry = null WHERE session_token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
        }
    }
?>

