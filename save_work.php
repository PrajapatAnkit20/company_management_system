<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $project_id = $_POST['project_id'];
    $work_description = $_POST['work_description'];
    $work_hours_before_break = $_POST['work_hours_before_break'];
    $break_time = $_POST['break_time'];
    $work_hours_after_break = $_POST['work_hours_after_break'];
    $createdBy = $_POST['createdBy'];
    $createdIP = $_POST['createdIP'];

    // Use prepared statement
    $stmt = $conn->prepare("INSERT INTO WorkSheet (employee_id, project_id, work_description, work_hours_before_break, break_time, work_hours_after_break, createdBy, createdIP) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssss", $employee_id, $project_id, $work_description, $work_hours_before_break, $break_time, $work_hours_after_break, $createdBy, $createdIP);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('Your work has been successfully saved.');
                window.location.href = 'worksheet.php'; 
              </script>";
    } else {
        echo "<script>
                alert('Error: " . addslashes($stmt->error) . "');
                window.history.back(); // Go back to the previous page
              </script>";
    }
    
    $stmt->close();
}
$conn->close();
?>
