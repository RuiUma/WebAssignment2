<?php
$mysqli = new mysqli("localhost", "root", "", "webassignment2");

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $mysqli->prepare("UPDATE users SET status = 'active', verification_token = NULL WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Account verified!";
    } else {
        echo "Invalid verification link!";
    }
}
?>
