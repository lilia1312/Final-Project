<?php
include 'header.php';
require('connect.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check the database for the user 
    $query = "SELECT * FROM Users WHERE email = :email";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    //verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Store user info in session
        $_SESSION['logged_in'] = true;
        $_SESSION["email"] = $user['email'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $success = "Logged in successfully";
         
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>

<?php
// Check if there is a logout message and display it
if (isset($_SESSION['logout_message'])) {
    echo "<p>" . $_SESSION['logout_message'] . "</p>";

    // Unset the session variable after displaying the message
    unset($_SESSION['logout_message']);
}?>
    <div class="container mt-5" style="max-width:600px">
        <div class="login-form">
            <h2>Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo ($error); ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
            <div class="alert alert-success" ><?php echo($success); ?></p></div>
        <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-field mb-4">
                    <input class="form-control" type="text" name="email" placeholder="Email" required>
                </div>

                <div class="form-field mb-4">
                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                </div>

                <div class="">
                    <button class="btn btn-primary" type="submit" value="Login" name="submit">Login</button>
                </div>

                    <div >
                        <p>Don't have an account ?<a href= "register.php"> Register</a></p> 
                    </div>
            </form>
        </div>
    </div>
</body>
</html>
