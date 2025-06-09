<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_name = trim($_POST['project_name']);
    $createdBy = trim($_POST['createdBy']);
    $p_status = trim($_POST['p_status']);
    $createdIP = $_SERVER['REMOTE_ADDR'];
    $departments = isset($_POST['department']) ? $_POST['department'] : [];

    if (empty($project_name) || empty($createdBy) || empty($p_status) || empty($departments)) {
        echo "<script>alert('All fields, including at least one department, are required!'); window.history.back();</script>";
        exit();
    }

    $sql = "INSERT INTO project (project_name, p_status, createdBy, createdIP) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $project_name, $p_status, $createdBy, $createdIP);

    if ($stmt->execute()) {
        $project_id = $stmt->insert_id;
        foreach ($departments as $dept_id) {
            $conn->query("INSERT INTO project_department (project_id, dept_id) VALUES ($project_id, $dept_id)");
        }
        echo "<script>alert('Project added successfully!'); window.location='project.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
    }
    $stmt->close();
    $conn->close();
}