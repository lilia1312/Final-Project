<?php
require('connect.php');
include 'header.php';

$category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($category_id === false) {
    die('Invalid category ID.');
}

// Fetch category name
$query = "SELECT name FROM Categories WHERE id = :category_id";
$statement = $db->prepare($query);
$statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$statement->execute();
$category = $statement->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    die('Category not found.');
}

// Fetch posts for this category
$query = "SELECT id, title FROM Posts WHERE category_id = :category_id ORDER BY created_at DESC";
$statement = $db->prepare($query);
$statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts in <?php echo $category['name']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  
</head>
<body>
    <div class="container mt-4">
        <div class="list-group">
            <h1>Posts in <?php echo $category['name']; ?></h1>
            <ul class="list-group">
                <?php foreach ($posts as $post): ?>
                    <li class="list-group-item" >
                        <a href="view.php?id=<?php echo $post['id']; ?>" style="color:#000;  text-decoration: none">
                            <?php echo $post['title']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
