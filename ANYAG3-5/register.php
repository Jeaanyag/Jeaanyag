<?php
include('config.php');

if (isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password == $confim){
        if (strlen($password)>= 8 && strlen($password)<= 20 && preg_match('/[A-Za-z]/', $password) && preg_match ('/[0-9]/', $password)){
            $hashed_password = md5($password);

            $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($conn, $query)){
                echo '<p style = "color:green;">Registration Successful!</p>';
            }else{
                echo '<p style="color:red;">Error:'. mysqli_error($conn) . '</p>';
            }
        }else{
            echo '<p style = "color:red;">Password must be *-20 characters long and contain letters and numbers. </p>';
        }
    }else{
        echo '<p style = "color:red;">Passwords do not match1 </p>';
    }
}
?>

