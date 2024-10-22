<?php
require("connection.php");

// Fetch tasks from the database
$query = "SELECT * FROM tasks";
$result = mysqli_query($conn, $query);

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - TO-DO List</title>
    <style>
        /* Add some basic CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .logout-btn {
            background-color: #ff4c4c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        
        .logout-btn:hover {
            background-color: #e63e3e;
        }
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
        }
        .task-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .task-list table th, .task-list table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .task-list table th {
            background-color: #4CAF50;
            color: white;
        }
        .task-list table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .task-form input {
            padding: 10px;
            margin-right: 10px;
            width: 200px;
        }
        .task-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .task-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Admin - Manage TO-DO List</h1>
        <form method="POST" action="logout.php">
            <button type="submit" class="logout-btn">Sign Out</button>
        </form>
        <!-- Task List -->
        <div class="task-list">
            <h3>All Tasks</h3>
            <table id="taskTable">
                <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are tasks to display
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $row['task_name'] . "</td>
                                    <td>" . ($row['created_by'] ? $row['created_by'] : 'Admin') . "</td>
                                    <td>" . $row['status'] . "</td>
                                    
                                    <td>
                                        <button class='edit-btn' onclick='editTask(" . $row['task_id'] . ")'>Edit</button>
                                        <button class='delete-btn' onclick='deleteTask(" . $row['task_id'] . ")'>Delete</button>
                                        <button class='complete-btn' onclick='changeStatus(" . $row['task_id'] . ", \"" . $row['status'] . "\")'>Completed</button>


                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No tasks available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Add Task Form -->
        <div class="task-form">
            <input type="text" id="newTask" placeholder="Enter new task">
            <button onclick="addNewTask()">Add Task</button>
        </div>
    </div>

    <script>
        // Add new task to the database
        function addNewTask() {
            const taskName = document.getElementById("newTask").value;
            if (taskName) {
                const formData = new FormData();
                formData.append('task_name', taskName);

                fetch('add_task.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(response => {
                    alert(response);
                    location.reload(); // Reload page to see updated tasks
                });
            } else {
                alert("Please enter a task name");
            }
        }

        // Edit task (this will prompt the user to enter a new task name)
        function editTask(taskId) {
            const newTaskName = prompt("Enter new task name");
            if (newTaskName) {
                const formData = new FormData();
                formData.append('task_id', taskId);
                formData.append('task_name', newTaskName);

                fetch('edit_task.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(response => {
                    alert(response);
                    location.reload(); // Reload page to see updated tasks
                });
            }
        }

        // Delete task
        function deleteTask(taskId) {
            if (confirm("Are you sure you want to delete this task?")) {
                const formData = new FormData();
                formData.append('task_id', taskId);

                fetch('delete_task.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(response => {
                    alert(response);
                    location.reload(); // Reload page to see updated tasks
                });
            }
        }

    function changeStatus(taskId, currentStatus) {
    const newStatus = currentStatus == 'Pending' ? 'Completed' : 'Pending';

    if (confirm(`Are you sure you want to change the status to ${newStatus}?`)) {
        const formData = new FormData();
        formData.append('task_id', taskId);
        formData.append('status', newStatus);

        fetch('change_status.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(response => {
            alert(response);
            if (response.includes("successfully")) {
                // Update the status in the table
                document.getElementById(`task-status-${taskId}`).innerText = newStatus;

                // Update the button onclick
                const statusButton = document.querySelector(`button[onclick*='${taskId}']`);
                statusButton.setAttribute('onclick', `changeStatus(${taskId}, '${newStatus}')`);
            }
        })
        .then(response => {
                    alert(response);
                    location.reload(); // Reload page to see updated tasks
        })
        .catch(error => {
            console.error('Error:', error);
        }); 
    }
}


        // function changeStatus(taskId, currentStatus) {
        //     const newStatus = currentStatus === 'Pending' ? 'Complete' : 'Pending';

        //     if (confirm(`Are you sure you want to change the status to ${newStatus}?`)) {
        //         const formData = new FormData();
        //         formData.append('task_id', taskId);
        //         formData.append('status', newStatus);

        //          fetch('change_status.php', {
        //          method: 'POST',
        //          body: formData
        //         })
        //         .then(response => response.text())
        //         .then(response => {
        //             alert(response);
        //             if (response.includes("successfully")){
        //                 document.getElementById(`task-status-${taskId}`).innerText = newStatus;
            
        //                 const statusButton = document.querySelector(`button.status-btn[onclick*='${taskId}']`);
        //                 statusButton.setAttribute('onclick', `changeStatus(${taskId}, '${newStatus}')`);
        //                 }    
        //         })
        //         .catch(error => {
        //          console.error('Error:', error);
        //         });
        //     }
        // }


    </script>
</body>
</html>
