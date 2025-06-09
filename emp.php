<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 50px;
        }

        .button-container {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            background-color: #5dade2;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 20px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #3498db;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            color: black;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

    <div class="button-container">
        <a href="view_emp.php" class="btn">Overview</a>
        <a href="#" class="btn">Add New Department</a>
    </div>

    <div class="container">

        <form action="save_emp.php" method="post">
            <h2>Add New Employee Details</h2>

            <label>Employee Name:</label>
            <input type="text" name="e_Name" required>

            <label>Employee Salary:</label>
            <input type="number" step="0.01" name="salary" required>

            <label>Created By:</label>
            <input type="text" name="createdBy" required>

            <label>Employee Department:</label>
            <select name="dept_id" required>
                <option value="">Select Department</option>
                <?php
                if (!$conn) {
                    die("<option value=''>Database Connection Failed</option>");
                }
                $query = "SELECT dept_id, department_name FROM department ORDER BY dept_id ASC";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    die("<option value=''>Query Failed: " . mysqli_error($conn) . "</option>");
                }
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['dept_id'] . "'>" . $row['department_name'] . " - " . $row['dept_id'] . "</option>";
                }
                ?>
            </select>
            <label>Status:</label>
            <select name="e_status">
                <option value="enable">Enable</option>
                <option value="disable">Disable</option>
                <option value="delete">Delete</option>
            </select>

            <input type="submit" name="submit" value="Add Employee Detail">

        </form>
    </div>
</body>

</html>