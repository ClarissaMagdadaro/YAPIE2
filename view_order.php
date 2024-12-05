<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }
    
    if (isset($_GET['get_id'])) {
        $get_id = $_GET['get_id'];
    }else{
        $get_id = '';
        header('location:order.php');
    }

    if (isset($_POST['cancel'])) {
        $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
        $update_order->execute(['cancelled', $get_id]);

        header('location:order.php');
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Figuras D' Arte - Order Details Page</title>
        <link rel="stylesheet" type="text/css" href="css/user_style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel='stylesheet'>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php include 'components/user_header.php'; ?>
        <div class="order-detail">
            <div class="heading">
                <h1>Order Details</h1>
                <p>asdasda</p>
                <img src="image/separator-img.png">
            </div>
            <div class="box-container">
                <?php
                    $grand_total = 0;
                    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
                    $select_order->execute([$get_id]);

                    if ($select_order->rowCount() > 0) {
                        while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
                            $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                            $select_product->execute([$fetch_order['product_id']]);
                            if ($select_product->rowCount() > 0) {
                                while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
                                    $sub_total = ($fetch_order['price'] * $fetch_order['qty']);
                                    $grand_total += $sub_total;
                ?>
                <div class="box">
                    <div class="col">
                        <p class="title"><i class="bx bxs-calendar-alt"></i><?= $fetch_order['date']; ?></p>
                        <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
                        <p class="price">₱<?= $fetch_product['price']; ?></p>
                        <h3 class="name"><?= $fetch_product['name']; ?></h3>
                        <p class="grand-total">Total Amount Payable = ₱<span><?= $grand_total; ?></span></p>
                    </div>
                    <div class="col">
                        <p class="title">Billing Address</p>
                        <p class="user"><i class="bx bxs-user"></i><?= $fetch_order['name']; ?></p>
                        <p class="user"><i class="bx bxs-phone"></i><?= $fetch_order['number']; ?></p>
                        <p class="user"><i class="bx bxs-envelope"></i><?= $fetch_order['email']; ?></p>
                        <p class="user"><i class="bx bxs-pin-map-fill"></i><?= $fetch_order['address']; ?></p>
                        <p class="status" style="color:<?php if($fetch_order['status'] == 'delivered'){echo "green";}elseif($fetch_order['status'] == 'cancelled'){echo "red";}else{echo "orange";} ?>"><?= $fetch_order['status']; ?></p>
                        <?php if($fetch_order['status']=='cancelled'){ ?>
                            <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn" style="line-height: 2;">Order Again</a>
                        <?php }else{ ?>
                            <form action="" method="post">
                                <button type="submit" name="cancel" class="btn" onclick="return confirm('Do you want to cancel this product?');">Cancel</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
                <?php
                                }
                            }
                        }
                    }else{
                        echo '<p class="empty">No order yet</p>';
                    }
                ?>
            </div>
        </div>

        <?php include 'components/footer.php'; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script src="js/user_script.js"></script>
        <?php include 'components/alert.php'; ?>
    </body>
</html>