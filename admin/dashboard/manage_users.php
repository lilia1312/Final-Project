<?php
require('../../connect.php');
include '../../header.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// Fetch all users
$query = "SELECT * FROM Users";
$statement = $db->query($query);
$users = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Manage Users</title>
</head>
<style>
    #sort {
        padding: 5px;
        font-size: 16px;
    }
    th {
        text-align: left;
        cursor: pointer;
    }
    .sort-indicator {
        font-size: 12px;
        color: #666;
    }
    .asc::after {
        content: ' ▲';
    }
    .desc::after {
        content: ' ▼';
    }

    .container {
        padding-left: 150px;
        }
        .sidebar {
            width: 200px;
            height: 750px;
            position: absolute;
            background-color: #343a40;
            padding-top: 30px;
            color: white;
        }
        .sidebar .nav-link {
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: #007bff;
        }
</style>
<body>
        <div class="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="../dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add_user.php">Add New Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_posts.php">Manage Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_users.php">Manage Users</a>
                </li>
            </ul>
        </div>

    <div class="container mt-5">
        <h1>Manage Users</h1>
            <a href="add_user.php" class="btn btn-primary mb-3">Add Admin</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo ($user['id']); ?></td>
                        <td><?php echo ($user['username']); ?></td>
                        <td><?php echo ($user['role']); ?></td>
                        <td>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
