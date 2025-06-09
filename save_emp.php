<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $e_Name = trim($_POST["e_Name"]);
    $salary = trim($_POST["salary"]);
    $e_status = $_POST["e_status"];
    $createdBy = trim($_POST["createdBy"]);
    $createdIP = $_SERVER['REMOTE_ADDR'];
    $dept_id = $_POST["dept_id"];

    // Use prepared statements for security
    $insert_query = "INSERT INTO Employee (e_Name, salary, e_status, createdBy, createdIP, dept_id) 
                     VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sdsssi", $e_Name, $salary, $e_status, $createdBy, $createdIP, $dept_id);

    if ($stmt->execute()) {
        echo "<script>alert('Employee added successfully!'); window.location.href='emp.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
