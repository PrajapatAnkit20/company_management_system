<?php
include 'db_connect.php';

$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $sql = "SELECT * FROM Employee WHERE e_Name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("s", $search_param);
} else {
    $sql = "SELECT * FROM Employee";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 10px 5px;
            text-align: center;
        }

        /* Search bar container */
        .search-container {
            display: flex;
            justify-content: flex-end; /* Aligns search to the right */
            align-items: center;
            padding: 10px 20px;
            margin-bottom: 10px;
        }

        .search-box input {
            padding: 6px;
            width: 200px; /* Smaller input field */
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-box button {
            padding: 6px 10px;
            font-size: 14px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 5px;
        }

        .search-box button:hover {
            background-color: #0056b3;
        }

        /* Table Styling */
        table {
            width: 100%;
            margin: auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            padding: 12px;
        }

        td {
            background-color: #ffffff;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e2e6ea;
        }

        /* Button Styling */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
            border: none;
        }

        .edit-btn {
            background-color: #ffc107;
            color: black;
        }

        .edit-btn:hover {
            background-color: #e0a800;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>

</head>

<body>

<!-- Search Bar -->
<div class="search-container">
    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Search Employee Name" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>
</div>

<!-- Employee Table -->
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Salary</th>
        <th>Dept ID</th>
        <th>Status</th>
        <th>Created By</th>
        <th>Created Date</th>
        <th>Created IP</th>
        <th>Updated By</th>
        <th>Updated Date</th>
        <th>Updated IP</th>
        <th>Actions</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['employee_id']}</td>
                <td>{$row['e_Name']}</td>
                <td>{$row['salary']}</td>
                <td>{$row['dept_id']}</td>
                <td>{$row['e_status']}</td>
                <td>{$row['createdBy']}</td>
                <td>{$row['createdDate']}</td>
                <td>{$row['createdIP']}</td>
                <td>" . (!empty($row['updatedBy']) ? $row['updatedBy'] : '-') . "</td>
                <td>" . (!empty($row['updatedDate']) ? $row['updatedDate'] : '-') . "</td>
                <td>" . (!empty($row['updatedIP']) ? $row['updatedIP'] : '-') . "</td>
                <td>
                    <a href='edit_emp.php?id={$row['employee_id']}' class='action-btn edit-btn'>
                        <i class='fas fa-pencil-alt'></i>
                    </a>
                    <a href='delete_emp.php?id={$row['employee_id']}' class='action-btn delete-btn' 
                       onclick='return confirm(\"Are you sure you want to delete this employee?\")'>
                        <i class='fas fa-trash-alt'></i>
                    </a>
                </td>
            </tr>";
    }
    ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
