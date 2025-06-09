<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $worksheet_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM WorkSheet WHERE worksheet_id = $worksheet_id");
    $worksheet = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $worksheet_id = $_POST['worksheet_id'];
    $employee_id = $_POST['employee_id'];
    $project_id = $_POST['project_id'];
    $work_description = $_POST['work_description'];
    $work_hours_before_break = $_POST['work_hours_before_break'];
    $break_time = $_POST['break_time'];
    $work_hours_after_break = $_POST['work_hours_after_break'];
    $updatedBy = $_POST['updatedBy'];
    $updatedIP = $_SERVER['REMOTE_ADDR'];

    $sql = "UPDATE WorkSheet SET 
            employee_id=?, 
            project_id=?, 
            work_description=?, 
            work_hours_before_break=?, 
            break_time=?, 
            work_hours_after_break=?, 
            updatedBy=?, 
            updatedDate=NOW(), 
            updatedIP=? 
            WHERE worksheet_id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissddssi", $employee_id, $project_id, $work_description, $work_hours_before_break, $break_time, $work_hours_after_break, $updatedBy, $updatedIP, $worksheet_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('WorkSheet updated successfully!'); window.location='view_work.php';</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch employees
$employee_query = "SELECT employee_id, e_name FROM employee";
$employee_result = $conn->query($employee_query);

// Fetch projects
$project_query = "SELECT project_id, project_name FROM project";
$project_result = $conn->query($project_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee Worksheet</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: black;
            margin-bottom: 15px;
        }
        label {
            font-weight: 600;
            display: block;
            margin-top: 12px;
            color: black;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 18px;
            transition: 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Employee Worksheet</h2>
        <form action="" method="post">
            <input type="hidden" name="worksheet_id" value="<?= htmlspecialchars($worksheet['worksheet_id'] ?? '') ?>">
            
            <label>Employee:</label>
            <select name="employee_id" required>
                <option value="">Select Employee</option>
                <?php while ($row = $employee_result->fetch_assoc()) { ?>
                    <option value="<?= $row['employee_id'] ?>" <?= ($worksheet['employee_id'] ?? '') == $row['employee_id'] ? 'selected' : '' ?>><?= htmlspecialchars($row['e_name']) ?></option>
                <?php } ?>
            </select>
            
            <label>Project:</label>
            <select name="project_id" required>
                <option value="">Select Project</option>
                <?php while ($row = $project_result->fetch_assoc()) { ?>
                    <option value="<?= $row['project_id'] ?>" <?= ($worksheet['project_id'] ?? '') == $row['project_id'] ? 'selected' : '' ?>><?= htmlspecialchars($row['project_name']) ?></option>
                <?php } ?>
            </select>
            
            <label>Work Description:</label>
            <textarea name="work_description" required><?= htmlspecialchars($worksheet['work_description'] ?? '') ?></textarea>
            
            <label>Work Hours Before Break:</label>
            <input type="text" name="work_hours_before_break" value="<?= htmlspecialchars($worksheet['work_hours_before_break'] ?? '') ?>" required>
            
            <label>Break Time:</label>
            <input type="text" name="break_time" value="<?= htmlspecialchars($worksheet['break_time'] ?? '') ?>" required>
            
            <label>Work Hours After Break:</label>
            <input type="text" name="work_hours_after_break" value="<?= htmlspecialchars($worksheet['work_hours_after_break'] ?? '') ?>" required>
            
            <label>Updated By:</label>
            <input type="text" name="updatedBy" required>
            
            <button type="submit">Update WorkSheet</button>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>