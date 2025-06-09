<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $emp_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM Employee WHERE employee_id = ?");
    $stmt->bind_param("i", $emp_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}

if (isset($_POST['submit'])) {
    $e_Name = trim($_POST['e_Name']);
    $salary = $_POST['salary'];
    $dept_id = $_POST['dept_id'];
    $e_status = $_POST['e_status'];
    $created_by = trim($_POST['created_by']);
    $updatedIP = $_SERVER['REMOTE_ADDR'];

    // If updatedBy is not set, assign it the value of createdBy
    $updated_by = empty($row['updatedBy']) ? $created_by : $row['updatedBy'];

    $stmt = $conn->prepare("UPDATE Employee 
                            SET e_Name=?, salary=?, dept_id=?, e_status=?, createdBy=?, updatedBy=?, updatedIP=?, updatedDate=NOW() 
                            WHERE employee_id=?");
    $stmt->bind_param("sdsssssi", $e_Name, $salary, $dept_id, $e_status, $created_by, $updated_by, $updatedIP, $emp_id);

    if ($stmt->execute()) {
        echo "<script>alert('Employee updated successfully.'); window.location='view_emp.php';</script>";
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin:  auto;
            /* background: white; */
            padding: 20px;
            border-radius: 10px;
            /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
        }

        .card {
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        select.form-control {
            height: 40px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .text-center {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center">Edit Employee Details</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Employee Name</label>
                    <input type="text" class="form-control" name="e_Name" value="<?= isset($row['e_Name']) ? htmlspecialchars($row['e_Name']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Salary</label>
                    <input type="number" class="form-control" step="0.01" name="salary" value="<?= isset($row['salary']) ? htmlspecialchars($row['salary']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Created By</label>
                    <input type="text" class="form-control" name="created_by" value="<?= isset($row['createdBy']) ? htmlspecialchars($row['createdBy']) : '' ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Employee Department</label>
                    <select class="form-control" name="dept_id" required>
                        <option value="">Select Department</option>
                        <?php
                        $query = "SELECT dept_id, department_name FROM Department ORDER BY dept_id ASC";
                        $result = $conn->query($query);
                        while ($dept = $result->fetch_assoc()) {
                            $selected = (isset($row['dept_id']) && $dept['dept_id'] == $row['dept_id']) ? 'selected' : '';
                            echo "<option value='{$dept['dept_id']}' $selected>{$dept['department_name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="e_status">
                        <option value="enable" <?= (isset($row['e_status']) && $row['e_status'] == 'enable') ? 'selected' : '' ?>>Enable</option>
                        <option value="disable" <?= (isset($row['e_status']) && $row['e_status'] == 'disable') ? 'selected' : '' ?>>Disable</option>
                        <option value="delete" <?= (isset($row['e_status']) && $row['e_status'] == 'delete') ? 'selected' : '' ?>>Delete</option>
                    </select>
                </div>


                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary">Update Employee</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>