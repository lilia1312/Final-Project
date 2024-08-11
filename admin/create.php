<?php
require('../connect.php');
include '../header.php';

$error = '';
$success = '';

// Save uploaded file
function file_upload_path($original_filename, $upload_subfolder_name = 'images') {
    $current_folder = dirname(__FILE__);
    $path_segments = [$current_folder, '..', $upload_subfolder_name, basename($original_filename)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
}

// Testing for 'image-ness'
function file_is_an_image($temporary_path, $new_path) {
    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type        = getimagesize($temporary_path)['mime'];

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Server-side validation
    if (empty(trim($title)) || empty(trim($content))) {
        $error = "Title and Content cannot be empty.";
    } else { 
        // Handling the image upload
        $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
        $image_filename = null;

        if ($image_upload_detected) {
            $temporary_image_path = $_FILES['image']['tmp_name'];
            $image_filename = basename($_FILES['image']['name']);
            $new_image_path = file_upload_path($image_filename);

            if (file_is_an_image($temporary_image_path, $new_image_path)) {
                if (move_uploaded_file($temporary_image_path, $new_image_path)) {
                    // Insert the image into the media_content table
                    $media_query = "INSERT INTO MediaContent (filename) VALUES (:filename)";
                    $media_statement = $db->prepare($media_query);
                    $media_statement->bindValue(':filename', $image_filename);
                    $media_statement->execute();

                    $media_id = $db->lastInsertId(); // Get the inserted media ID
                } else {
                    $error = "Failed to move the uploaded file.";
                }
            } else {
                $error = "The uploaded file is not a valid image.";
            }
        }

        // Prepare and execute the insert statement
        $query = "INSERT INTO Posts (title, content, created_at, updated_at, media_id) VALUES (:title, :content, NOW(), NOW(), :media_id)";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':media_id', isset($media_id) ? $media_id : null, PDO::PARAM_INT);

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
                    
                <div class="mb-3" >
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                    <br>
                <div class="form-field">
                    <textarea name="content" id="summernote" cols="30" rows="10" placeholder="Enter Content:"></textarea>
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
<?php 
//include("admin/footer.php");
?>


