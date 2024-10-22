<?php
require("connection.php");

$query = "SELECT * FROM tasks";
$result = mysqli_query($conn, $query);

$tasks = array();
while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;  // Collect tasks into an array
}

echo json_encode($tasks);  // Return the tasks as JSON response
mysqli_close($conn);
?>

