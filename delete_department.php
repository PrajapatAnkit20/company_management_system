<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $dept_id = $_GET['id'];

    // Check if the ID is valid
    if (!is_numeric($dept_id)) {
        die("Invalid Department ID");
    }

    // SQL Query to Delete the Department
    $sql = "DELETE FROM Department WHERE dept_id = $dept_id";

    if ($conn->query($sql) === TRUE) {
        echo "Department deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No Department ID provided.";
}

// Redirect back to the list page after 2 seconds
header("refresh:2; url=view_dept.php");
$conn->close();
?>
