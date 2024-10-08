<?php
require('../connect.php');
include '../header.php';

$error = '';
$success = '';

if (!isset($_SESSION['user_id'])) {
    die('User is not logged in.');
}

$query = "SELECT * FROM Categories ORDER BY created_at DESC";
$statement = $db->prepare($query); 
$statement->execute(); 
$category = $statement->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
//if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

    // Server-side validation
    if (empty(trim($title)) || empty(trim($content))) {
        $error = "Title and Content cannot be empty.";
    } else{
        // Prepare and execute the insert statement
        $query = "INSERT INTO Posts ( user_id, category_id, title, content, created_at, updated_at) VALUES (:user_id, :category_id, :title, :content,  NOW(), NOW())";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':category_id', $category_id);


        // Execute the statement
        if ($statement->execute()) {
            $success = "New post created successfully.";
        } else {
            $error = "Error: Could not create the page.";
        }
  
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <title></title>
</head>
    <body>

        <div class="create-form w-100 mx-auto p-4" style="max-width:700px;">
            <h2>New Post</h2>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo ($error); ?></div>
            <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success" ><?php echo ($success); ?></p></div>
                <?php endif; ?>

            <form method="post" action="create.php" enctype="multipart/form-data">
                <div class="form-field">
                    <input type="text" name="title" id="title" placeholder="Enter Title:">
                </div>
                    
                
                    <br>
                <div class="form-field mb-3">
                    <textarea name="content" id="summernote" cols="30" rows="10" placeholder="Enter Content:"></textarea>
                </div>

                <div class="form-outline mb-3">
                    <select name="category_id" class="form-select" aria-label="Default select example">
                        <option value="" disabled selected>Categories</option>
                        <?php foreach($category as $categories) : ?>
                        <option value="<?php echo $categories['id']; ?>"><?php echo $categories['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-field mb-3" >
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                
                <!---Submit button--->
                <button type="submit" value="Add Post" name="create">Create Post</button>

            </form>
        </div>
    <script>
        $('#summernote').summernote({
            tabsize: 2,
            height: 120,
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>

    </body>
</html>


