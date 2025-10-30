<?php
// =======================
// DATABASE CONNECTION
// =======================
$host = "localhost";
$user = "root";
$pass = "";
$db   = "user_db";  // same database used in register.php

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// =======================
// LOGIN LOGIC
// =======================
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Find user in the database
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            // Start a session and store user data
            session_start();
            $_SESSION['username'] = $user['username'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];

            // Redirect to a welcome page
            header("Location: index.html");
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Username not found!'); window.history.back();</script>";
    }
}
?>
