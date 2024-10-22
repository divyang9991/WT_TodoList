<?php
require("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    
    $query = "DELETE FROM tasks WHERE task_id = '$task_id'";
    if ($conn->query($query) === TRUE) {
        echo "Task deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
