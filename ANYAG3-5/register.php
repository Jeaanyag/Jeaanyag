<?php
// =======================
// DATABASE CONNECTION
// =======================
$host = "localhost";
$user = "root";      // default WAMP username
$pass = "";          // default WAMP password (empty)
$db   = "user_db";  

// Connect to MySQL
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// =======================
// REGISTRATION LOGIC
// =======================
if (isset($_POST['register'])) {
    // Get form inputs safely
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname  = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username  = mysqli_real_escape_string($conn, $_POST['username']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm'];

    // Check if passwords match
    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Check if username already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username already taken!'); window.history.back();</script>";
        exit();
    }

    // Hash password before saving
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $query = "INSERT INTO users (firstname, lastname, username, password)
              VALUES ('$firstname', '$lastname', '$username', '$hashedPassword')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registration successful!'); window.location.href='login.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
