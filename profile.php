<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = 'location:web_login.php';
    }

    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id =?");
    $select_orders->execute([$user_id]);
    $total_orders = $select_orders->rowCount();

    $select_message = $conn->prepare("SELECT * FROM `message` WHERE user_id =?");
    $select_message->execute([$user_id]);
    $total_message = $select_message->rowCount();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Figuras D' Arte - User Profile Page</title>
        <link rel="stylesheet" type="text/css" href="css/user_style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel='stylesheet'>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php include 'components/user_header.php'; ?>
        <section class="profile">
            <div class="heading">
                <h1>Profile Detail</h1>
                <img src="image/separator-img.png">
            </div>
            <div class="details">
                <div class="user">
                    <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
                    <h3><?= $fetch_profile['name']; ?></h3>
                    <p>User</p>
                    <a href="update.php" class="btn">Update Profile</a>
                </div>
                <div class="box-container">
                    <div class="box">
                        <div class="flex">
                            <i class="bx bxs-folder-minus"></i>
                            <h3><?= $total_orders; ?></h3>
                        </div>
                        <a href="order.php" class="btn">View Orders</a>
                    </div>
                    <div class="box">
                        <div class="flex">
                            <i class="bx bxs-chat"></i>
                            <h3><?= $total_message; ?></h3>
                        </div>
                        <a href="message.php" class="btn">View Message</a>
                    </div>
                </div>
            </div>
        </section>
        


        <?php include 'components/footer.php'; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script src="js/user_script.js"></script>
        <?php include 'components/alert.php'; ?>
    </body>
</html>