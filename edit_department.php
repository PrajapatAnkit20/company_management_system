<?php
include 'db_connect.php';
session_start(); 

if (isset($_GET['id'])) {
    $dept_id = $_GET['id'];

    $sql = "SELECT * FROM Department WHERE dept_id = $dept_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    
    $createdBy = $row['createdBy'] ?? 'Unknown';
}

if (isset($_POST['update'])) {
    $department_name = trim($_POST['department_name']);
    $status = $_POST['status'];

    
    $updatedBy = $_SESSION['username'] ?? $createdBy;


    $updatedIP = $_SERVER['REMOTE_ADDR'];

    // Check if department name already exists (excluding current ID)
    $check_sql = "SELECT * FROM Department WHERE department_name = '$department_name' AND dept_id != $dept_id";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Department name already exists. Please choose a different name.');</script>";
    } else {
     
        $update_sql = "UPDATE Department 
                       SET department_name='$department_name', 
                           d_status='$status', 
                           updatedBy='$updatedBy', 
                           updatedIP='$updatedIP', 
                           updatedDate=NOW() 
                       WHERE dept_id=$dept_id";

        if ($conn->query($update_sql) === TRUE) {
            echo "<script>alert('Department updated successfully.'); window.location='view_dept.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
        }
    }
}
?>  

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>
    <style>
     
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 40%;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 12px 0 6px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

       
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            flex: 1;
            text-align: center;
            padding: 12px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-update {
            background-color: #28a745;
            margin-right: 10px;
        }

        .btn-update:hover {
            background-color: #218838;
        }

        .btn-back {
            background-color: #007bff;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        
        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            .btn-container {
                flex-direction: column;
            }

            .btn {
                margin-bottom: 10px;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Department</h2>
        <form method="post">
            <label>Department Name:</label>
            <input type="text" name="department_name" value="<?php echo htmlspecialchars($row['department_name']); ?>" required>

            <label>Status:</label>
            <select name="status">
                <option value="Enable" <?php if ($row['d_status'] == 'Enable') echo 'selected'; ?>>Enable</option>
                <option value="Disable" <?php if ($row['d_status'] == 'Disable') echo 'selected'; ?>>Disable</option>
                <option value="Delete" <?php if ($row['d_status'] == 'Delete') echo 'selected'; ?>>Delete</option>
            </select>

            <div class="btn-container">
                <input type="submit" name="update" value="Update" class="btn btn-update">
                <a href="view_dept.php" class="btn btn-back">Back</a>
            </div>
        </form>
    </div>

</body>

</html>

<?php $conn->close(); ?>
