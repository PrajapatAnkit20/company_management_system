<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM project WHERE project_id=$id");
    echo "<script>alert('Project deleted successfully!'); window.location='view_projects.php';</script>";
}
?>