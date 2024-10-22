<?php
require("connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forgot_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "SELECT * FROM register_user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        
        $_SESSION['reset_email'] = $email; 
        echo "
        <script>
        alert('Email found. Proceed to reset your password.');
        window.location.href = 'reset_password.php';
        </script>
        ";
    } else {
       
        echo "
        <script>
        alert('Email not found.');
        window.location.href = 'forgot_password.php';
        </script>
        ";
    }
}
?>