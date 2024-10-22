
<?php
require('connection.php'); 
session_start();

if (isset($_POST['task_id']) && isset($_POST['status'])) {
    $taskId = mysqli_real_escape_string($conn, $_POST['task_id']);
    $newStatus = mysqli_real_escape_string($conn, $_POST['status']);

    // Validate status values
    $validStatuses = ['Pending', 'Completed'];
    if (!in_array($newStatus, $validStatuses)) {
        echo "Invalid status value.";
        exit();
    }

    // Update query to change the task status
    $query = "UPDATE `tasks` SET `status`='Completed' WHERE task_id= $taskId";
    
    if (mysqli_query($conn, $query)) {
        echo "Task status updated to '$newStatus' successfully!";
    } else {
        echo "Error updating task status: " . mysqli_error($conn);
    }
} else {
    echo "Required data not sent (task_id or status missing).";
}

mysqli_close($conn);
?>
