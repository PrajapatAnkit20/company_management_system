<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="homestyle.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .sidebar img.logo {
            width: 100%;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            margin: 5px 0;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #495057;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <img src="logo.png" alt="Company Logo" class="logo">
        <a href="dept.php" target="contentFrame"><i class="fas fa-building"></i> Department</a>
        <a href="emp.php" target="contentFrame"><i class="fas fa-user"></i> Employee</a>
        <a href="project.php" target="contentFrame"><i class="fas fa-tasks"></i> Project</a>
        <a href="worksheet.php" target="contentFrame"><i class="fas fa-file-alt"></i> Worksheet</a>
    </div>

    <div class="content">
        <iframe name="contentFrame" src="dept.php"></iframe>
    </div>

</body>
</html>
