<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Include database connection
include '../components/connect.php'; // Database connection

// Check if form is submitted
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    // Prepare SQL query to check if user exists
    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email = ? AND password = ?");
    $select_seller->execute([$email, $pass]);
    $row = $select_seller->fetch(PDO::FETCH_ASSOC);

    // Check if user exists
    if ($select_seller->rowCount() > 0) {
        // Set a session variable for the user if the login is successful
        $_SESSION['user_id'] = $row['id'];
        
        // Redirect to the dashboard after login
        header('Location: dashboard.php');
        exit();
    } else {
        $warning_msg[] = 'Incorrect Email or Password';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Figuras D Arte - Seller Registration Page</title>
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>Login Now</h3>

            <div class="input-field">
                <p>Your Email <span>*</span></p>
                <input type="email" name="email" placeholder="Email..." maxlength="50" required class="box">
            </div>

            <div class="input-field">
                <p>Your Password <span>*</span></p>
                <input type="password" name="pass" placeholder="Password..." maxlength="50" required class="box">
            </div>            
            <p class="link">Don't have an Account? <a href="register.php">Register Now!</a></p>
            <input type="submit" name="submit" value="Login" class="btn">
        </form>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>