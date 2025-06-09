<?php
include 'db_connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure it's a valid integer

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM worksheet WHERE worksheet_id = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Employee Work deleted successfully!'); window.location='view_work.php';</script>";
        } else {
            echo "<script>alert('Error deleting record. Please try again.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error: Unable to prepare statement.');</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='view_work.php';</script>";
}

$conn->close();
?>
