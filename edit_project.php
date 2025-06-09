<?php
include 'db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$project = [];
$departments = [];

if ($id > 0) {
    // Fetch project details using prepared statements
    $stmt = $conn->prepare("SELECT * FROM project WHERE project_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();
    $stmt->close();

    if (!$project) {
        die("Project not found.");
    }

    // Fetch assigned departments
    $stmt = $conn->prepare("SELECT dept_id FROM project_department WHERE project_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $departments = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_name = htmlspecialchars($_POST['project_name']);
    $p_status = htmlspecialchars($_POST['p_status']);
    $updatedBy = htmlspecialchars($_POST['updatedBy']);
    $updatedIP = $_SERVER['REMOTE_ADDR'];
    $selected_departments = $_POST['department'] ?? [];

    // Update project
    $sql = "UPDATE project SET project_name=?, p_status=?, updatedBy=?, updatedDate=NOW(), updatedIP=? WHERE project_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $project_name, $p_status, $updatedBy, $updatedIP, $id);

    if ($stmt->execute()) {
        $stmt->close();

        // Insert new department assignments
        if (!empty($selected_departments)) {
            $stmt = $conn->prepare("INSERT INTO project_department (project_id, dept_id) VALUES (?, ?)");
            foreach ($selected_departments as $dept_id) {
                $stmt->bind_param("ii", $id, $dept_id);
                $stmt->execute();
            }
            $stmt->close();
        }

        echo "<script>alert('Project updated successfully!'); window.location='view_projects.php';</script>";
    } else {
        echo "<script>alert('Error updating project.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { width: 400px; background: #ffffff; padding: 25px; border-radius: 12px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: black; margin-bottom: 15px; }
        label { font-weight: 600; display: block; margin-top: 12px; color: black; }
        input, select { width: 100%; padding: 10px; margin-top: 6px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
        .checkbox-group { margin-top: 10px; display: flex; flex-wrap: wrap; gap: 10px; }
        .checkbox-group label { background: #f0f0f0; padding: 8px 12px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 8px; }
        .checkbox-group input { accent-color: #28a745; }
        button { width: 100%; padding: 12px; background-color: #28a745; border: none; color: white; font-size: 16px; border-radius: 6px; cursor: pointer; margin-top: 18px; transition: 0.3s; }
        button:hover { background-color: #218838; }
        @media (max-width: 420px) { .container { width: 90%; } }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Project</h2>
        <form action="" method="post">
            <label>Project Name:</label>
            <input type="text" name="project_name" value="<?= htmlspecialchars($project['project_name'] ?? '') ?>" required>

            <label>Updated By:</label>
            <input type="text" name="updatedBy" required>

            <label>Status:</label>
            <select name="p_status" required>
                <option value="ongoing" <?= ($project['p_status'] ?? '') == 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                <option value="completed" <?= ($project['p_status'] ?? '') == 'completed' ? 'selected' : '' ?>>Completed</option>
                <option value="on-hold" <?= ($project['p_status'] ?? '') == 'on-hold' ? 'selected' : '' ?>>On-Hold</option>
                <option value="cancelled" <?= ($project['p_status'] ?? '') == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>

            <label>Select Department:</label>
            <div class="checkbox-group">
                <?php
                $sql = "SELECT * FROM department";
                $result = $conn->query($sql);
                $selected_departments = array_column($departments, 'dept_id');
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $checked = in_array($row['dept_id'], $selected_departments) ? 'checked' : '';
                        echo '<label><input type="checkbox" name="department[]" value="' . $row['dept_id'] . '" ' . $checked . '> ' . htmlspecialchars($row['department_name']) . '</label>';
                    }
                } else {
                    echo "<p>No departments available.</p>";
                }
                ?>
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
</body>

</html>
