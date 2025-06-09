<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $employee_id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM Employee WHERE employee_id = ?");
    $stmt->bind_param("i", $employee_id);

    if ($stmt->execute()) {
        echo "<script>alert('Employee deleted successfully.'); window.location='view_emp.php';</script>";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}
?>
