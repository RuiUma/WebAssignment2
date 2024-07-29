<?php
$mysqli = new mysqli("localhost", "root", "", "webassignment2");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = hash('sha512', $_POST['password']);

    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE email = ? AND status = 'active'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    echo $result->num_rows;
    echo '<br>';

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['password'] === $password) {
            $token = bin2hex(random_bytes(64));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $stmt = $mysqli->prepare("UPDATE users SET session_token = ?, session_expiry = ? WHERE id = ?");
            $stmt->bind_param("ssi", $token, $expiry, $user['id']);
            $stmt->execute();

            setcookie('session_token', $token, time() + 3600, "/");
            echo "Login successful!";
        } else {
            echo "Invalid email or password!";
        }
    } else {
        echo "Invalid email or password!";
    }
}
?>
