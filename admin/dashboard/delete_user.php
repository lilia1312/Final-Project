<?php
session_start();
require('../../connect.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM Users WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute([
        ':id' => $id
    ]);
    header("Location: http://localhost:4000/admin/dashboard/manage_users.php");

} else {
    die("Invalid user ID.");
}
?>