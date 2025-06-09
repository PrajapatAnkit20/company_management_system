<?php
include 'db_connect.php';

// Initialize search query variable
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Prepare SQL query with prepared statements to prevent SQL injection
$sql = "SELECT * FROM worksheet 
        WHERE employee_id LIKE ? 
        OR CreatedBY LIKE ? 
        OR work_description LIKE ?";

$stmt = $conn->prepare($sql);
$search_param = "%$search_query%";
$stmt->bind_param("sss", $search_param, $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkSheet Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background-color: #f4f4f4; */
            text-align: center;
            /* margin: 20px; */
        }

        .container {
            width: 100%;
            background: white;
            margin: auto;
            /* padding: 20px; */
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
            /* border-radius: 10px; */
        }

        .header {
            display: flex;
            justify-content: flex-end;
            /* Aligns content to the right */
            align-items: center;
            margin-bottom: 20px;
        }


        input[type="text"] {
            padding: 8px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 8px 12px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            text-decoration: none;
            font-size: 16px;
            color: white;
            margin: 2px;
        }

        .edit-btn {
            background-color: #28a745;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <form method="GET">
                <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="table-container">
            <?php if ($result->num_rows > 0) { ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>E_ID</th>
                        <th>P_ID</th>
                        <th>Work Description</th>
                        <th>WHBB</th>
                        <th>Break Time</th>
                        <th>WHAB</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                        <th>Created IP</th>
                        <th>Updated By</th>
                        <th>Updated Date</th>
                        <th>Updated IP</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['worksheet_id']; ?></td>
                            <td><?php echo $row['employee_id']; ?></td>
                            <td><?php echo $row['project_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['work_description']); ?></td>
                            <td><?php echo $row['work_hours_before_break']; ?></td>
                            <td><?php echo $row['break_time']; ?></td>
                            <td><?php echo $row['work_hours_after_break']; ?></td>
                            <td><?php echo htmlspecialchars($row['createdBy']); ?></td>
                            <td><?php echo $row['createdDate']; ?></td>
                            <td><?php echo $row['createdIP']; ?></td>
                            <td><?php echo htmlspecialchars($row['updatedBy']); ?></td>
                            <td><?php echo $row['updatedDate']; ?></td>
                            <td><?php echo $row['updatedIP']; ?></td>
                            <td>
                                <a href="edit_work.php?id=<?php echo urlencode($row['worksheet_id']); ?>" class="action-btn edit-btn">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_work.php?id=<?php echo urlencode($row['worksheet_id']); ?>" class="action-btn delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this record?');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>No records found.</p>
            <?php } ?>
        </div>
    </div>

</body>

</html>

<?php
$stmt->close();
$conn->close();
?>