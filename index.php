<?php
require('connect.php');
include 'header.php';

$query = "SELECT * FROM Posts ORDER BY created_at DESC";
$statement = $db->prepare($query); 
$statement->execute(); 
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM Categories ORDER BY created_at DESC";
$statement = $db->prepare($query); 
$statement->execute(); 
$category = $statement->fetchAll(PDO::FETCH_ASSOC);

/*<?php foreach ($category as $categories): ?>
    <div>
    <?php echo ($categories['name']);  ?>
    </div>
<?php endforeach; ?>*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        .post-title {
            font-size: 25px;
            font-weight: bold;
        }
        .post-content {
            font-size: 15px;
            color: #555;
        }
        .container {
            padding-top: 20px;
        }
        .footer {
            padding: 20px;
            background-color: #343a40;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mb-3">Posts</h1>
                <div class="list-group">
                    <?php foreach ($posts as $post): ?>
                        <a href="view.php?id=<?php echo $post['id']; ?>" class="list-group-item list-group-item-action">
                            <h5 class="post-title"><?php echo ($post['title']); ?></h5>
                            <p class="post-content"><?php echo (substr($post['content'], 0, 50)); ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>


            
        </div>
    </div>
    <footer class="footer mt-5">
        <p>&copy; 2024 EP Steps. All rights reserved.</p>
    </footer>

</body>
</html>
