<?php
require('connect.php');
include 'header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {

        $success = "Account created successfully";
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Default role
        $role = 'user';

        // Insert into database
        $query = "INSERT INTO Users (username, password, email, role) VALUES (:username, :password, :email, :role)";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $hashed_password);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':role', $role);
        $statement->execute();

        // Redirect to login page
        //header('Location: index.php');
        //exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    <title>Register</title>
</head>
<body>

    
    <div class="container mt-5" style="max-width:600px">
        <h1>Register</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo ($error); ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success" ><?php echo ($success); ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
        <div class="mb-4">
                <input type="text" id="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-4">
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-4">
                <input type="password" id="password" name="password" class="form-control"  placeholder="Password" required>
            </div>
            <div class="mb-4">
                <input type="password" id="confirm_password" name="confirm_password" class="form-control"   placeholder="Confirm Password" required>
                <small id="passwordHelpInline" class="text-muted">Must be at least 5 characters long.</small>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Register</button>
        </form>
        <div >
            <p>Have an account ?<a href= "login.php">Login</a></p> 
        </div>
    </div>
</body>
</html>
