<?php
require('connect.php');
include 'header.php';




// Check if the user is an admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the post data 
    $query = "SELECT * FROM Posts WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $post = $statement->fetch(PDO::FETCH_ASSOC);

} else {
    die("Invalid page ID.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $comment = trim($_POST['comment']);
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : trim($_POST['username']);
        $captcha = trim($_POST['captcha']);
        
        if ($captcha != $_SESSION['captcha']) {
            $error = "Invalid CAPTCHA.";
        } elseif (!empty($comment)) {
            $query = "INSERT INTO Comments (post_id, username, comment) VALUES (:post_id, :username, :comment)";
            $statement = $db->prepare($query);
            $statement->bindValue(':post_id', $id, PDO::PARAM_INT);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':comment', $comment);
            $statement->execute();
            
            // Redirect 
            //header('Location: view.php?id=' . $id);
            //exit;
        } else {
            $error = "Comment field cannot be empty.";
        }
    }

    if (isset($_POST['assign_category']) && $isAdmin) {
        $category_id = $_POST['category_id'];

        if (is_numeric($category_id)) {
            $query = "UPDATE Posts SET category_id = :category_id WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $success = "Category assigned successfully.";
        } else {
            $error = "Invalid category.";
        }
    }
}

// Fetch comments for the post
$query = "SELECT * FROM Comments WHERE post_id = :post_id AND hidden = 0 ORDER BY created_at DESC";
$statement = $db->prepare($query);
$statement->bindValue(':post_id', $id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);

// Fetch categories for dropdown
$query = "SELECT * FROM Categories ORDER BY name ASC";
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
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

        <?php if ($isAdmin): ?>
            <h4>Assign Category</h4>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo$error; ?></div>
            <?php endif; ?>

            <form method="POST" action="view.php?id=<?php echo $id; ?>">
                <div class="mb-3">
                    <select name="category_id" class="form-select" aria-label="Default select example" required>
                        <option value="" disabled selected>Categories</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo $post['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                <?php echo $category['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="assign_category" class="btn btn-primary btn-sm mb-5">Assign Category</button>
            </form>
        <?php endif; ?>

        <h4>Comments</h4>
        <?php foreach ($comments as $comment): ?>
            <div class="mb-3">
                <strong><?php echo $comment['username']; ?></strong>
                <p><?php echo $comment['comment']; ?></p>
                <small><?php echo $comment['created_at']; ?></small>
            </div>
        <?php endforeach; ?>    

        <div>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>    
        </div>

        <form method="POST" action="view.php?id=<?php echo $id; ?>">
            <div class="mb-3">
                <textarea class="form-control" placeholder="Leave a comment" name="comment" columns="3" rows="3" required></textarea>
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
            <button type="submit" class="btn btn-primary btn-sm mb-5" name="submit">Post Comment</button>
        </form>

        <a href="index.php" class="btn btn-secondary mb-5">Back to Posts</a>
    </div>
</body>
</html>
