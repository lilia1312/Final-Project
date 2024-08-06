<?php
require('../connect.php');
include '../header.php';

// Sanitize $_GET['id'] to ensure it's a number.
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Fetch the post data from the database based on id
$query = "SELECT * FROM Posts WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch(PDO::FETCH_ASSOC);

if ($post === false) {
    // Redirect to the public posts page if the post does not exist
    echo "Post not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title><?php echo $post['title']; ?></title>
</head>
<body>
    <div class="container mt-5">
        <h1><?php echo $post['title']; ?></h1>
        <p><?php echo ($post['content']); ?></p>
        <a href="dashboard/manage_posts.php" class="btn btn-secondary">Back to Posts</a>
    </div>
</body>
</html>
