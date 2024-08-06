<?php
session_start();
require('../connect.php');

// Check if the user is logged in and is an admin
/*if (!isset($_SESSION['user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: http://localhost:4000/login.php");
    exit();
}
*/
// Get the ID from the query string


if(isset($_GET['id' ])){
$id = $_GET['id'];

// Ensure the ID is valid before attempting to delete

    $query = "DELETE FROM Posts WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute([
        ':id' => $id
    ]);
    header("Location: http://localhost:4000/index.php");
}
?>
