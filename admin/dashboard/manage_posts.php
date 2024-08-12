<?php

require('../../connect.php');
include '../../header.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// Default sort column and direction
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$sort_direction = isset($_GET['direction']) && $_GET['direction'] == 'desc' ? 'desc' : 'asc';

// Validate sort column
$valid_columns = ['title', 'author', 'created_at','updated_at' ];
if (!in_array($sort_column, $valid_columns)) {
    $sort_column = 'created_at'; // Default to 'created_at' if invalid
}

$success = "Post deleted successfully";


// Validate sort direction
$sort_direction = ($sort_direction === 'desc') ? 'desc' : 'asc';

// Prepare SQL query with dynamic sorting
$query = "SELECT * FROM Posts ORDER BY $sort_column $sort_direction";
$statement = $db->prepare($query);
$statement->execute();
$pages = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Admin Dashboard</title>

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
        <h1>Posts</h1>
        <a href="manage_comments.php" class="btn btn-primary mb-3">Manage Comments</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        <a href="?sort=title&direction=<?php echo ($sort_column == 'title' && $sort_direction == 'asc') ? 'desc' : 'asc'; ?>" class="<?php echo ($sort_column == 'title') ? ($sort_direction == 'asc' ? 'asc' : 'desc') : ''; ?>">Title</a>
                    </th>
                    <th>
                        <a href="?sort=created_at&direction=<?php echo ($sort_column == 'created_at' && $sort_direction == 'asc') ? 'desc' : 'asc'; ?>" class="<?php echo ($sort_column == 'created_at') ? ($sort_direction == 'asc' ? 'asc' : 'desc') : ''; ?>">Created At</a>
                    </th>
                    <th>
                        <a href="?sort=updated_at&direction=<?php echo ($sort_column == 'updated_at' && $sort_direction == 'asc') ? 'desc' : 'asc'; ?>" class="<?php echo ($sort_column == 'updated_at') ? ($sort_direction == 'asc' ? 'asc' : 'desc') : ''; ?>">Updated At</a>
                    </th>
                    <th style="width:25%;">Article</th>
                    <th style="width:20%;">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><?php echo ($page['title']); ?></td>
                        <td><?php echo ($page['created_at']); ?></td>
                        <td><?php echo ($page['updated_at']); ?></td>
                        <td><?php echo (substr($page["content"], 0, 50)); ?></td>
                        <td>
                            <a class="btn btn-info btn-sm" href="http://localhost:4000/admin/view.php?id=<?php echo $page["id"]; ?>">View</a>
                            <a class="btn btn-warning btn-sm" href="http://localhost:4000/admin/edit.php?id=<?php echo $page["id"]; ?>">Edit</a>
                            <a class="btn btn-danger btn-sm" href="http://localhost:4000/admin/delete.php?id=<?php echo $page["id"]; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>