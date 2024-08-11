<?php
require('connect.php');
include 'header.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the post data from the database based on id
    $query = "SELECT * FROM Posts WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $post = $statement->fetch(PDO::FETCH_ASSOC);

} else {
    die("Invalid page ID.");
}

if (isset($_POST['submit'])) {
    $comment = trim($_POST['comment']);
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : trim($_POST['username']);
    $captcha = trim($_POST['captcha']);
    
    if ($captcha != $_SESSION['captcha']) {
        $error = "Invalid CAPTCHA.";
    // Check if the comment field is not empty
    } elseif (!empty($comment)) {
        $comment = $_POST['comment'];
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : $_POST['username'];

    
        $query = "INSERT INTO Comments (post_id, username, comment) VALUES (:post_id, :username, :comment)";
        $statement = $db->prepare($query);
        $statement->bindValue(':post_id', $id, PDO::PARAM_INT);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':comment', $comment);
        $statement->execute();
        
        // Redirect to avoid re-submission on refresh
        //header('Location: view.php?id=' . $id);
        //exit;
    } else {
        $error = "Comment field cannot be empty.";
    }
}
// Fetch comments for the post
$query = "SELECT * FROM Comments WHERE post_id = :post_id AND hidden = 0 ORDER BY created_at DESC";
$statement = $db->prepare($query);
$statement->bindValue(':post_id', $id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title><?php echo $post['title']; ?></title>
    <style>
        .captcha-container {
            display: flex;
            align-items: center;
        }
        .captcha-container img {
            margin-left: 10px; 
        }
        .captcha-container input[type="text"] {
            max-width: 150px; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1><?php echo $post['title']; ?></h1>
            <p><?php echo $post['content']; ?></p>
            <a href="index.php" class="btn btn-secondary mb-5" >Back to Posts</a>
                <?php 
                    $statement = 'SELECT * FROM MediaContent WHERE id = :id' ;
                    $image = $statement->fetch(PDO::FETCH_ASSOC);
                ?>
            <h4>Comments</h4>
                <?php foreach ($comments as $comment): ?>
                    <div class="mb-3">
                        <strong><?php echo ($comment['username']); ?></strong>
                        <p><?php echo ($comment['comment']); ?></p>
                        <small><?php echo ($comment['created_at']); ?></small>
                    </div>
                <?php endforeach; ?>    

            <h4>Leave a Comment</h4>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo ($error); ?></div>
                <?php endif; ?>    

            <form method="POST" action="view.php?id=<?php echo $id; ?>">
                <div class="mb-3">
                    <textarea class="form-control" placeholder="Leave a comment" name="comment" columns="3" rows="3"></textarea>
                </div>
                <?php if (!isset($_SESSION['username'])): ?>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Your name" name="username" required>
                    </div>
                <?php endif; ?>
            <div class="mb-3 captcha-container">
                <input type="text" class="form-control" placeholder="Enter Captcha" name="captcha" required>
                <img src="captcha.php" alt="CAPTCHA">
            </div>
                <button type="submit" class="btn btn-primary" name="submit">Post Comment</button>
            </form>
    </div>
</body>
</html>
