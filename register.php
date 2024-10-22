<?php

require("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
   
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email_username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

   
    $check_user_query = "SELECT * FROM register_user WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $check_user_query);

    if (mysqli_num_rows($result) > 0) {
       
        header("Location: index.php?message=exists");
        exit(); 
    } else {
        
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

  
        $insert_user_query = "INSERT INTO register_user (full_name, username, email, password) 
                              VALUES ('$full_name', '$username', '$email', '$hashed_password')";

        if (mysqli_query($conn, $insert_user_query)) {
            
            header("Location: index.php?message=registered_successfully");
            exit();
        } else {
            
            header("Location: index.php?message=error");
            exit();
        }
    }
}

mysqli_close($conn);
?>