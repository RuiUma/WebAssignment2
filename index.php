<?php
// Load Composer's autoloader
require 'vendor/autoload.php';

// Your code here (e.g., routing logic, database connections, etc.)

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Authentication</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Signup</h2>
    <form action="signup.php" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="name" placeholder="Name" required>
        <input type="date" name="birthday" placeholder="Birthday" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Signup</button>
    </form>

    <h2>Login</h2>
    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
