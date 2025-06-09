<?php
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_name = trim($_POST["department_name"]);
    $d_status = $_POST["d_status"];
    $createdBy = trim($_POST["createdBy"]);
    $createdIP = $_SERVER['REMOTE_ADDR']; // Get user IP
    $createdDate = date("Y-m-d H:i:s"); 

    // Check if department name already exists
    $check_query = "SELECT * FROM department WHERE department_name = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $department_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Department already exists
        echo "<script>alert('Department name already exists!'); window.history.back();</script>";
        exit;
    } else {
        // Insert into the database

        $insert_query = "INSERT INTO department (department_name, d_status, createdBy, createdIP, createdDate) 
                         VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);  
        $stmt->bind_param("sssss", $department_name, $d_status, $createdBy, $createdIP, $createdDate);

        if ($stmt->execute()) {
            echo "<script>alert('Department saved successfully!'); window.location.href='dept.php';</script>";
        } else {
            echo "<script>alert('Error saving department. Please try again.'); window.history.back();</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
