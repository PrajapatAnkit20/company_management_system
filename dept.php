<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
            margin: 0;
            flex-direction: column;
            position: relative;
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
            padding: 35px;
            width: 350px;
            text-align: center;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: left;
            color: #555;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            border-color: #28a745;
            outline: none;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="button-container">
        <a href="view_dept.php" class="btn">Overview</a>
        <a href="#" class="btn">Add New Department</a>
    </div>
    <hr>
    <form action="save_dept.php" method="post">
        <h2>Add Department</h2>
        <label>Department Name:</label>
        <input type="text" name="department_name" required>

        <label>Created By:</label>
        <input type="text" name="createdBy" required>

        <label>Status:</label>
        <select name="d_status">
            <option value="enable">Enable</option>
            <option value="disable">Disable</option>
            <option value="delete">Delete</option>
        </select>

        <input type="submit" name="submit" value="Save Department">
    </form>
</body>

</html>