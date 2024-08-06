<?php
require('../../connect.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment_id']) && isset($_POST['current_status'])) {
        $comment_id = $_POST['comment_id'];
        $current_status = $_POST['current_status'];

        // Toggle the hidden status
        $new_status = $current_status == 1 ? 0 : 1;

        $query = "UPDATE Comments SET hidden = :hidden WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':hidden', $new_status, PDO::PARAM_INT);
        $statement->bindValue(':id', $comment_id, PDO::PARAM_INT);
        $statement->execute();

        header('Location: manage_comments.php');
        exit;
    }
}
die("Invalid request.");
?>