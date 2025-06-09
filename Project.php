<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Project</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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

        /* Form Container */
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

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        /* Checkbox Container */
        .checkbox-group {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .checkbox-group label {
            background: #f0f0f0;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-group input {
            accent-color: #28a745;
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

        /* Responsive Design */
        @media (max-width: 420px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>

<body>



    <div class="button-container">
        <a href="view_projects.php" class="btn">Overview</a>
        <a href="#" class="btn">Add New Department</a>
    </div>
    <div class="container">
        <h2>Add New Project</h2>
        <form action="save_project.php" method="post">
            <label>Project Name:</label>
            <input type="text" name="project_name" required>

            <label>Created By:</label>
            <input type="text" name="createdBy" required>

            <label>Status:</label>
            <select name="p_status" required>
                <option value="ongoing">Ongoing</option>
                <option value="completed">Completed</option>
                <option value="on-hold">On-Hold</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <label>Select Department:</label>
            <div class="checkbox-group">
                <?php
                include 'db_connect.php'; // Ensure connection is included
                $sql = "SELECT * FROM department";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<label><input type="checkbox" name="department[]" value="' . $row['dept_id'] . '"> ' . htmlspecialchars($row['department_name']) . '</label>';
                    }
                } else {
                    echo "<p>No departments available.</p>";
                }
                ?>
            </div>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>