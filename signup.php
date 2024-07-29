<?php
require 'vendor/autoload.php';
use SendGrid\Mail\Mail;

$mysqli = new mysqli("localhost", "root", "", "webassignment2");

$SENDGRID_API_KEY='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';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $password = hash('sha256', $_POST['password']);
    $verification_token = bin2hex(random_bytes(64));

    $stmt = $mysqli->prepare("INSERT INTO users (email, name, birthday, password, verification_token) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $name, $birthday, $password, $verification_token);
    $stmt->execute();

    $email = new Mail();
    $email->setFrom("eason@umatech.work", "Eason");
    $email->setSubject("Verify your email address");
    $email->addTo($_POST['email'], $_POST['name']);
    $email->addContent("text/plain", "Please verify your email using this link: http://localhost/assignment2/verify.php?token=" . $verification_token);

    $sendgrid = new \SendGrid($SENDGRID_API_KEY);
    
    try {
        $response = $sendgrid->send($email);
        echo 'Email sent successfully';
    } catch (Exception $e) {
        echo 'Caught exception: '. $e->getMessage() ."\n";
    }
}
?>
