<?php
require('../../connect.php');
include '../../header.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = 'admin';
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    if (!empty($username) && !empty($password)) {
        $query = "INSERT INTO Users (username, password, email, role) VALUES (:username, :password, :email, :role)";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':role', $role);
        $statement->execute();

    } else {
        echo "Please provide a username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Add User</title>
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

        <div class="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="../dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../create.php">Add New Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_posts.php">Manage Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_users.php">Manage Users</a>
                </li>
            </ul>
        </div>
    <div class="container mt-5" style="max-width:600px">
        <h1>Add User</h1>
        <form method="POST" action="">
            <div class="form-field mb-4">
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
            </div>
            <div class="form-field mb-4">
                <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
            </div>
            <div class="form-field mb-4">
                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>
</body>
</html>
