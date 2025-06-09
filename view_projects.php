<?php
include 'db_connect.php';

// Initialize $search variable
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Use prepared statements for security
$sql = "SELECT p.*, GROUP_CONCAT(d.department_name SEPARATOR ', ') AS departments 
        FROM project p 
        LEFT JOIN project_department pd ON p.project_id = pd.project_id 
        LEFT JOIN department d ON pd.dept_id = d.dept_id 
        WHERE p.project_name LIKE ? OR d.department_name LIKE ?
        GROUP BY p.project_id ORDER BY p.project_id";

$stmt = $conn->prepare($sql);
$search_param = "%$search%";
$stmt->bind_param("ss", $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: auto;
            background-color: #f4f4f4;
        }

        /* Header and Search Bar */
        .header {
            display: flex;
            justify-content: flex-end; /* Aligns search to the right */
            align-items: center;
            padding: 15px;
        }

        .search-box input {
            padding: 6px;
            width: 220px; /* Smaller size */
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-box button {
            padding: 6px 10px;
            font-size: 14px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
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
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            padding: 15px;
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
            width: 35px;
            height: 35px;
            border-radius: 50%;
            text-decoration: none;
            font-size: 18px;
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

<!-- Header with Search Bar -->
<div class="header">
    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>
</div>

<!-- Projects Table -->
<table>
    <tr>
        <th>ID</th>
        <th>Project Name</th>
        <th>Status</th>
        <th>Department</th>
        <th>Created By</th>
        <th>Created Date</th>
        <th>Created IP</th>
        <th>Updated By</th>
        <th>Updated Date</th>
        <th>Updated IP</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['project_id']}</td>
                    <td>{$row['project_name']}</td>
                    <td>{$row['p_status']}</td>
                    <td>" . (!empty($row['departments']) ? $row['departments'] : '-') . "</td>
                    <td>{$row['createdBy']}</td>
                    <td>{$row['createdDate']}</td>
                    <td>{$row['createdIP']}</td>
                    <td>" . (!empty($row['updatedBy']) ? $row['updatedBy'] : '-') . "</td>
                    <td>" . (!empty($row['updatedDate']) ? $row['updatedDate'] : '-') . "</td>
                    <td>" . (!empty($row['updatedIP']) ? $row['updatedIP'] : '-') . "</td>
                    <td>
                        <a href='edit_project.php?id={$row['project_id']}' class='action-btn edit-btn'>
                            <i class='fas fa-pencil-alt'></i>
                        </a>
                        <a href='delete_project.php?id={$row['project_id']}' class='action-btn delete-btn' 
                           onclick='return confirm(\"Are you sure you want to delete this project?\")'>
                            <i class='fas fa-trash-alt'></i>
                        </a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No projects found</td></tr>";
    }
    ?>

</table>

</body>
</html>

<?php $conn->close(); ?>
