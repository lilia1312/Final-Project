<?php 

require('../connect.php');
include '../header.php';
 
$post = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

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
    <link rel="stylesheet" href="main.css">
    <script src="https://cdn.tiny.cloud/1/ulxoac0nqp2aqf7hhoobm76pt3pszj4a7v1lfyni0osp55me/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <title></title>
</head>
<body>
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

                <div>
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Enter Content:"><?php echo ($post['content']);?></textarea>
                </div>
                
                <div class="form-field">
                    <input type="submit" value="Update" name="update">
                </div>
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