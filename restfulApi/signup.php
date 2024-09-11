<?php
require '../vendor/autoload.php';
use SendGrid\Mail\Mail;

include '../db.php';

$SENDGRID_API_KEY='';

$data = json_decode(file_get_contents("php://input"));


    $email = $data->email;
    $name = $data->username;
    $password = hash('sha512', $data->password);
    $verification_token = bin2hex(random_bytes(64));

    $stmt = $mysqli->prepare("INSERT INTO users (email, name, password, verification_token) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $name, $password, $verification_token);
    $stmt->execute();

    $email = new Mail();
    $email->setFrom("eason@umatech.work", "Eason");
    $email->setSubject("Verify your email address");
    $email->addTo($data->email, $data->username);
    $email->addContent("text/plain", "Please verify your email using this link: http://localhost/assignment2/verify.php?token=" . $verification_token);

    $sendgrid = new \SendGrid($SENDGRID_API_KEY);
    
    try {
        $response = $sendgrid->send($email);
        echo 'Email sent successfully';
    } catch (Exception $e) {
        echo 'Caught exception: '. $e->getMessage() ."\n";
    }

?>
