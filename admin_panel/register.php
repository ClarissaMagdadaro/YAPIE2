<?php
    include '../components/connect.php';

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $cpass = sha1($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = uniqid().'.'.$ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = '../uploaded_files/'.$rename;

        $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email = ?");
        $select_seller->execute([$email]);

        if ($select_seller->rowCount() > 0){
            $warning_msg[] = 'email already exists!';
        }else{
            if($pass != $cpass){
                $warning_msg[] = 'passwords do not match!';
            }else{
                $insert_seller = $conn->prepare("INSERT INTO `sellers`(name, email, password, image) VALUES(?, ?, ?, ?)");
                $insert_seller->execute([$name, $email, $cpass, $rename]);
                move_uploaded_file($image_tmp, $image_folder);
                $success_msg[] = 'New seller registered! Please log in now.';
            }
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
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>Register Now</h3>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>Your Name <span>*</span></p>
                        <input type="text" name="name" placeholder="Name..." maxlength="50"
                        required class="box">
                    </div>
                    <div class="input-field">
                        <p>Your Email <span>*</span></p>
                        <input type="email" name="email" placeholder="Email..." maxlength="50"
                        required class="box">
                    </div>
                </div>
                <div class="col">
                    <div class="input-field">
                        <p>Your Password <span>*</span></p>
                        <input type="password" name="pass" placeholder="Password..." maxlength="50"
                        required class="box">
                    </div>
                    <div class="input-field">
                        <p>Confirm Password <span>*</span></p>
                        <input type="password" name="cpass" placeholder="Confirm Password..." maxlength="50"
                        required class="box">
                    </div>
                </div>
            </div>
            <div class="input-field">
                <p>Your Profile <span>*</span></p>
                <input type="file" name="image" accept="image/*" required class="box">
            </div>
            <p class="link">Already have an Account? <a href="login.php">Login now</a></p>
            <input type="submit" name="submit" value="register now" class="btn">
        </form>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
