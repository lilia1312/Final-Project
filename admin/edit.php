<?php 

require('../connect.php');
include '../header.php';
 
$post = null;

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $query = "SELECT * FROM Posts WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $post = $statement->fetch(PDO::FETCH_ASSOC);


    if (isset($_POST['update'])){
        $title = $_POST['title'];
         $content = $_POST['content'];

        // Prepare and execute the update statement
        $query = "UPDATE Posts SET title = :title, content = :content, updated_at = NOW() WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

    if ($statement->execute()) {
        $success = "Page updated successfully.";
        } else {
            $error = "Error: Could not update the page.";
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

<div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
            <h1>Edit Page</h1>
                <div class="create-form w-100 mx-auto p-4" style="max-width:700px;">
                    <form method="post" action="edit.php?id=<?php echo $id; ?>">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo ($error); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success" ><?php echo ($success); ?></div>
                        <?php endif; ?>

                        <div>
                            <input type="text" name="title" id="title" value ="<?php echo ($post['title']);?>" placeholder="Enter Title:"></input>
                        </div>

                        <div class="form-field mb-3">
                            <textarea name="content" id="summernote" cols="30" rows="10" placeholder="Enter Content:"><?php echo ($post['content']);?></textarea>
                        </div>

                        <div class="form-field mb-3">
                            <input type="submit" value="Update" name="update">
                        </div>
                    </form>

                    <a href="dashboard/manage_posts.php" class="btn btn-secondary btn-sm">Back to Posts</a>

                </div>
            </div>
        </div>
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