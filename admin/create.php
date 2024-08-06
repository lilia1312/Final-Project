<?php
require('../connect.php');
include '../header.php';

$error = '';
$success = '';


    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    //$img = $_FILES['img'] ['name'];

    //$dir ='images/' . basename($img);

    // Server-side validation
    if (empty(trim($title)) || empty(trim($content))) {
        $error = "Title and Content cannot be empty.";
    } else{
        // Prepare and execute the insert statement
        $query = "INSERT INTO Posts (title, content, created_at, updated_at) VALUES (:title, :content, NOW(), NOW())";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);

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
    <script src="https://cdn.tiny.cloud/1/ulxoac0nqp2aqf7hhoobm76pt3pszj4a7v1lfyni0osp55me/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
   
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
            <form method="post" action="create.php">

                <div class="form-field">
                    <input type="text" name="title" id="" placeholder="Enter Title:">
                </div>
                    
                <div>
                    <input type ='file' name="img">
                </div>

                <div class="form-field">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Enter Content:"></textarea>
                </div>
                
                
                <!---Submit button--->
                <button type="submit" value="Add Post" name="create">Create Post</button>

            </form>
        </div>
        <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
        });
        </script>

    </body>
<?php 
//include("admin/footer.php");
?>


