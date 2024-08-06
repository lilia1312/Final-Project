<?php
require('../../connect.php');

if (isset($_POST['comment_id']) && is_numeric($_POST['comment_id'])) {
    $id = $_POST['comment_id'];

    $query = "DELETE FROM Comments WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute([
        ':id' => $id
    ]);
    header("Location: http://localhost:4000/admin/dashboard/manage_comments.php");

} else {
    die("Invalid comment ID.");
}
?>