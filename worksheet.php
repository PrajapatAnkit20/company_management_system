<?php
include 'db_connect.php';

// Fetch employees
$employee_query = "SELECT employee_id, e_name FROM employee";
$employee_result = $conn->query($employee_query);

// Fetch projects
$project_query = "SELECT project_id, project_name FROM project";
$project_result = $conn->query($project_query);

// Get the user's IP address
$createdIP = $_SERVER['REMOTE_ADDR'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Worksheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
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

        form {
            background: white;
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }

        select,
        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

        
    <div class="button-container">
        <a href="view_work.php" class="btn">Overview</a>
        <a href="#" class="btn">Add New Department</a>
    </div>

    <form method="POST" action="save_work.php">
        <h2>Employee Worksheet</h2>

        <label for="employee_id">Employee:</label>
        <select name="employee_id" required>
            <option value="">Select Employee</option>
            <?php while ($row = $employee_result->fetch_assoc()) { ?>
                <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['e_name']; ?></option>
            <?php } ?>
        </select>

        <label for="project_id">Project:</label>
        <select name="project_id" required>
            <option value="">Select Project</option>
            <?php while ($row = $project_result->fetch_assoc()) { ?>
                <option value="<?php echo $row['project_id']; ?>"><?php echo $row['project_name']; ?></option>
            <?php } ?>
        </select>

        <label for="work_description">Work Description:</label>
        <textarea name="work_description" required></textarea>

        <label for="work_hours_before_break">Work Hours Before Break:</label>
        <input type="text" name="work_hours_before_break" required>

        <label for="break_time">Break Time:</label>
        <input type="text" name="break_time" required>

        <label for="work_hours_after_break">Work Hours After Break:</label>
        <input type="text" name="work_hours_after_break" required>

        <label for="createdBy">Created By:</label>
        <input type="text" name="createdBy" required>

        <!-- Hidden input to pass IP address automatically -->
        <input type="hidden" name="createdIP" value="<?php echo $createdIP; ?>">

        <button type="submit">Add WorkSheet</button>
    </form>

</body>

</html>

<?php $conn->close(); ?>