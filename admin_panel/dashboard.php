<?php
    include '../components/connect.php';

    if (isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    }else{
        $seller_id = '';
        header('location:login.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Figuras D Arte - Admin Dashboard Page</title>
        <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">

</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="dashboard">
            <div class="heading">
                <h1>Dashboard</h1>
                <img src="../image/separator-img.png" alt="✦ . ⁺ . ✦ . ⁺ . ✦">
            </div>
            <div class="box-container">
                <div class="box">
                    <h3>Welcome!</h3>
                    <p><?= $fetch_profile['name']; ?></p>
                    <a href="update.php" class="btn">Update Profile</a>
                </div>
                <div class="box">
                    <?php
                        $select_message = $conn->prepare("SELECT * FROM `message`");
                        $select_message->execute();
                        $number_of_msg = $select_message->rowCount();
                    ?>
                    <h3><?= $number_of_msg; ?></h3>
                    <p>Unread Message</p>
                    <a href="admin_message.php" class="btn">See Message</a>
                </div>
                <div class="box">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ?");
                        $select_products->execute([$seller_id]);
                        $number_of_products = $select_products->rowCount();
                    ?>
                    <h3><?= $number_of_products; ?></h3>
                    <p>Products Added</p>
                    <a href="add_products.php" class="btn">Add Product</a>
                </div>
                <div class="box">
                    <?php
                        $select_active_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ? AND status = ?");
                        $select_active_products->execute([$seller_id, 'active']);
                        $number_of_active_products = $select_active_products->rowCount();
                    ?>
                    <h3><?= $number_of_active_products; ?></h3>
                    <p>Total Active Products</p>
                    <a href="view_product.php" class="btn">View Active Products</a>
                </div>
                <div class="box">
                    <?php
                        $select_deactive_products = $conn->prepare("SELECT * FROM `products` WHERE seller_id = ? AND status = ?");
                        $select_deactive_products->execute([$seller_id, 'deactive']);
                        $number_of_deactive_products = $select_deactive_products->rowCount();
                    ?>
                    <h3><?= $number_of_deactive_products; ?></h3>
                    <p>Total Deactive Products</p>
                    <a href="view_product.php" class="btn">View Deactive Products</a>
                </div>
                <div class="box">
                    <?php
                        $select_users = $conn->prepare("SELECT * FROM `users`");
                        $select_users->execute();
                        $number_of_users = $select_users->rowCount();
                    ?>
                    <h3><?= $number_of_users; ?></h3>
                    <p>Users Account</p>
                    <a href="user_accounts.php" class="btn">See Users</a>
                </div>
                <div class="box">
                    <?php
                        $select_sellers = $conn->prepare("SELECT * FROM `sellers`");
                        $select_sellers->execute();
                        $number_of_sellers = $select_sellers->rowCount();
                    ?>
                    <h3><?= $number_of_sellers; ?></h3>
                    <p>Sellers Account</p>
                    <a href="user_accounts.php" class="btn">See Sellers</a>
                </div>
                <div class="box">
                    <?php
                        $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
                        $select_orders->execute([$seller_id]);
                        $number_of_orders = $select_orders->rowCount();
                    ?>
                    <h3><?= $number_of_orders; ?></h3>
                    <p>Total Orders Placed</p>
                    <a href="admin_order.php" class="btn">Total Orders</a>
                </div>
                <div class="box">
                    <?php
                        $select_confirm_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ? AND status= ?");
                        $select_confirm_orders->execute([$seller_id, 'in progress']);
                        $number_of_confirm_orders = $select_confirm_orders->rowCount();
                    ?>
                    <h3><?= $number_of_confirm_orders; ?></h3>
                    <p>Total Confirmed Orders </p>
                    <a href="admin_order.php" class="btn">Confirm Orders</a>
                </div>
                <div class="box">
                    <?php
                        $select_cancelled_orders = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ? AND status= ?");
                        $select_cancelled_orders->execute([$seller_id, 'cancelled']);
                        $number_of_cancelled_orders = $select_cancelled_orders->rowCount();
                    ?>
                    <h3><?= $number_of_cancelled_orders; ?></h3>
                    <p>Total Cancelled Orders </p>
                    <a href="admin_order.php" class="btn">Cancel Orders</a>
                </div>
            </div>
        </section>
    </div>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
