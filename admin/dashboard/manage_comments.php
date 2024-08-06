<?php

require('../../connect.php');
include '../../header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// Fetch all comments
$query = "SELECT * FROM Comments ORDER BY created_at DESC";
$statement = $db->prepare($query);
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Comments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
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
        <h1>Manage Comments</h1>
        <div class="list-group">
            <?php foreach ($comments as $comment): ?>
                <div class="list-group-item">
                    <strong><?php echo htmlspecialchars($comment['username']); ?></strong>
                    <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                    <small><?php echo htmlspecialchars($comment['created_at']); ?></small>

                    <form method="POST" action="mod_comment.php" class="mt-2 d-inline">
                        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                        <input type="hidden" name="current_status" value="<?php echo $comment['hidden']; ?>">
                        <button type="submit" name="action" value="toggle" class="btn btn-warning btn-sm">
                            <?php echo $comment['hidden'] ? 'Unhide' : 'Hide'; ?>
                        </button>
                    </form>
                    <form method="POST" action="delete_comment.php" class="mt-2 d-inline">
                        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                        <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
