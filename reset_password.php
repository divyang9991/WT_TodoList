<?php
require("connection.php");
session_start();

if (!isset($_SESSION['reset_email'])) {
    echo "
    <script>
    alert('Unauthorized access.');
    window.location.href = 'forgot_password.php';
    </script>
    ";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $email = $_SESSION['reset_email']; 

    
    $update_query = "UPDATE register_user SET password = '$hashed_password' WHERE email = '$email'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        unset($_SESSION['reset_email']);
        echo "
        <script>
        alert('Password has been successfully reset.');
        window.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Failed to reset the password. Please try again.');
        window.location.href = 'reset_password.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }


        .reset-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            text-align: left;
            color: #555;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

       
        @media (max-width: 600px) {
            .reset-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password</h2>
        <form method="POST" action="reset_password.php">
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required>
            <button type="submit" name="reset_password">Reset Password</button>
        </form>
    </div>
</body>
</html>