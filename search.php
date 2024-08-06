<?php
require('connect.php');
include 'header.php';

$posts =[];

if (isset($_GET['search'])){

    if ($_POST['search']){
        echo "hi";
    } else {

        $search = $_POST['search'];
        $query = "SELECT * FROM Posts WHERE title LIKE '%$search%' ";
        $statement = $db->prepare($query);
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($posts->rowCount() == 0) {
            echo 'hi';
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
        <h1>Search Results</h1>
        <div class="row">
            <div class="col-md-8">
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
</body>
</html>
