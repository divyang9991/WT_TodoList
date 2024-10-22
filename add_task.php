<?php
require("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $created_by = 'Admin'; 

    
    $query = "INSERT INTO tasks (task_name, created_by) VALUES ('$task_name', '$created_by')";
    
    if (mysqli_query($conn, $query)) {
        echo "Task added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>