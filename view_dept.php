<?php
include 'db_connect.php';

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM Department WHERE department_name LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM Department";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Department List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border: none;
        }

        .edit-btn {
            background-color: #4CAF50;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .search-container {
            float: right;
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 8px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-container button {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="search-container">
        <form method="GET">
            <input type="text" name="search" placeholder="Search Department Name" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Department Name</th>
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
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['dept_id']}</td>
                        <td>{$row['department_name']}</td>
                        <td>{$row['d_status']}</td>
                        <td>{$row['createdBy']}</td>
                        <td>{$row['createdDate']}</td>
                        <td>{$row['createdIP']}</td>
                        <td>{$row['updatedBy']}</td>
                        <td>{$row['updatedDate']}</td>
                        <td>{$row['updatedIP']}</td>
                        <td>
                            <a href='edit_department.php?id={$row['dept_id']}' class='btn edit-btn'><i class='fas fa-pencil-alt'></i></a>
                            <a href='delete_department.php?id={$row['dept_id']}' class='btn delete-btn' onclick='return confirm(\"Are you sure you want to delete this?\")'><i class='fas fa-trash-alt'></i></a>
                        </td>
                      </tr>";

            }
        } else {
            echo "<tr><td colspan='10'>No Departments Found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
