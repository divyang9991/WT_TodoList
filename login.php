<?php
require("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
   
    $email_username = mysqli_real_escape_string($conn, $_POST['email_username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    
    $query = "SELECT * FROM register_user WHERE username = '$email_username' OR email = '$email_username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

       
        if (password_verify($password, $hashed_password)) {
           
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            header("Location: admin.php?message=login_success");
            exit();
        } else {
           
            header("Location: index.php?message=incorrect_password");
            exit();
        }
    } else {
        header("Location: index.php?message=user_not_found");
        exit();
    }
}


mysqli_close($conn);
?>