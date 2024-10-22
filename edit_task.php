<?php
require("connection.php");


if (isset($_POST['task_id']) && isset($_POST['task_name'])) {
    $taskId = mysqli_real_escape_string($conn, $_POST['task_id']);
    $taskName = mysqli_real_escape_string($conn, $_POST['task_name']);

    
    $query = "UPDATE tasks SET task_name = '$taskName' WHERE task_id = $taskId";

   
    if (mysqli_query($conn, $query)) {
        echo "Task updated successfully.";
    } else {
        echo "Error updating task: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Required parameters are missing.";
}
?>
