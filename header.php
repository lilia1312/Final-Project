<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    <script src="https://cdn.tiny.cloud/1/ulxoac0nqp2aqf7hhoobm76pt3pszj4a7v1lfyni0osp55me/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    
    <title></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <a class="navbar-brand" href="http://localhost:4000/index.php">EP Steps</a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active"><a class="nav-link" href="http://localhost:4000/index.php">Home</a></li>            
                <li class="nav-item"><a class="nav-link" href="http://localhost:4000/login.php">Login</a></li>      
                <li class="nav-item"><a class="nav-link" href="http://localhost:4000/register.php">Register</a></li> 

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li class="nav-item"><a class="nav-link" href="http://localhost:4000/admin/dashboard.php">Admin Dashboard</a></li>  
                <?php endif; ?>

            <?php if(isset($_SESSION['username'])): ?>    
                <li class="nav-item"><a class="nav-link" href="http://localhost:4000/logout.php">Logout</a></li>
            
            <?php endif; ?>
            </ul>
        </div>

    <form class="form-inline my-2 my-lg-0"  action ="http://localhost:4000/search.php">

        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>

    </form>
        </div>
    </nav>
</body>
</html>