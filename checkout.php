<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:web_login.php');
}

if (isset($_POST['place_order'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $address = filter_var($_POST['flat'], FILTER_SANITIZE_STRING) . ', ' .
               filter_var($_POST['street'], FILTER_SANITIZE_STRING) . ', ' .
               filter_var($_POST['city'], FILTER_SANITIZE_STRING) . ', ' .
               filter_var($_POST['country'], FILTER_SANITIZE_STRING) . ', ' .
               filter_var($_POST['pin'], FILTER_SANITIZE_STRING);

    $address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_STRING);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);

    try {
        $conn->beginTransaction();

        // Handle single product checkout
        if (isset($_GET['get_id'])) {
            $get_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
            $get_product->execute([$_GET['get_id']]);

            if ($get_product->rowCount() > 0) {
                $fetch_p = $get_product->fetch(PDO::FETCH_ASSOC);
                $seller_id = $fetch_p['seller_id'];

                $insert_order = $conn->prepare("
                    INSERT INTO `orders` 
                    (user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $insert_order->execute([
                    $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method,
                    $fetch_p['id'], $fetch_p['price'], 1
                ]);
            } else {
                throw new Exception('Product not found.');
            }
        } else {
            // Handle cart checkout
            $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $verify_cart->execute([$user_id]);

            if ($verify_cart->rowCount() > 0) {
                while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
                    $s_products = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                    $s_products->execute([$f_cart['product_id']]);

                    if ($s_products->rowCount() > 0) {
                        $f_product = $s_products->fetch(PDO::FETCH_ASSOC);
                        $seller_id = $f_product['seller_id'];

                        $insert_order = $conn->prepare("
                            INSERT INTO `orders` 
                            (user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ");
                        $insert_order->execute([
                            $user_id, $seller_id, $name, $number, $email, $address, $address_type, $method,
                            $f_product['id'], $f_cart['price'], $f_cart['qty']
                        ]);
                    } else {
                        throw new Exception('Product in cart not found.');
                    }
                }

                // Clear cart after successful order placement
                $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                $delete_cart->execute([$user_id]);
            } else {
                throw new Exception('Cart is empty.');
            }
        }

        $conn->commit();
        header('location:order.php');
    } catch (Exception $e) {
        $conn->rollBack();
        $warning_msg[] = 'Error placing order: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Figuras D' Arte - Checkout Page</title>
        <link rel="stylesheet" type="text/css" href="css/user_style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel='stylesheet'>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php include 'components/user_header.php'; ?>
        <div class="checkout">
            <div class="heading">
                <h1>Checkout Summary</h1>
                <img src="image/separator-img.png">
            </div>
            <div class="row">
                <form action="" method="post" class="register">
                    <input type="hidden" name="p_id" value="<?= $get_id; ?>">
                    <h3>Billing Details</h3>
                    <div class="flex">
                        <div class="box">
                            <div class="input-field">
                                <p>Your Name <span>*</span></p>
                                <input type="text" name="name" required maxlength="50" placeholder="Enter your name..." class="input">
                            </div>
                            <div class="input-field">
                                <p>Your Number <span>*</span></p>
                                <input type="number" name="number" required maxlength="10" placeholder="Enter your number..." class="input">
                            </div>
                            <div class="input-field">
                                <p>Your Email <span>*</span></p>
                                <input type="email" name="email" required maxlength="50" placeholder="Enter your email..." class="input">
                            </div>
                            <div class="input-field">
                                <p>Payment Method <span>*</span></p>
                                <select name="method" class="input">
                                    <option value="Cash on Delivery">Cash on Delivery</option>
                                    <option value="Credit or Debit Card">Credit or Debit Card</option>
                                    <option value="GCash">GCash</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <p>Address <span>*</span></p>
                                <select name="address_type" class="input">
                                    <option value="Home">Home</option>
                                    <option value="Office">Office</option>
                                </select>
                            </div>
                        </div>
                        <div class="box">
                            <div class="input-field">
                                <p>Address Line 01<span>*</span></p>
                                <input type="text" name="flat" required maxlength="50" placeholder="e.g. flat or building name..." class="input">
                            </div>
                            <div class="input-field">
                                <p>Address Line 02<span>*</span></p>
                                <input type="text" name="street" required maxlength="50" placeholder="e.g. street name..." class="input">
                            </div>
                            <div class="input-field">
                                <p>City Name<span>*</span></p>
                                <input type="text" name="city" required maxlength="50" placeholder="e.g. city name..." class="input">
                            </div>
                            <div class="input-field">
                                <p>Country Name <span>*</span></p>
                                <input type="text" name="country" required maxlength="50" placeholder="e.g. country name..." class="input">
                            </div>
                            <div class="input-field">
                                <p>Pin Code <span>*</span></p>
                                <input type="text" name="pin" required maxlength="50" placeholder="e.g. 6100" class="input">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="place_order" class="btn">Place Order</button>
                </form>
                <div class="summary">
                    <h3>My Bag</h3>
                    <div class="box-container">
                        <?php
                            $grand_total = 0;
                            if (isset($_GET['get_id'])) {
                                $select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                $select_get->execute([$_GET['get_id']]);

                                while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
                                    $sub_total = $fetch_get['price'];
                                    $grand_total+=$sub_total;
                        ?>
                        <div class="flex">
                            <img src="uploaded_files/<?= $fetch_get['image']; ?>" class="image">
                            <div>
                                <h3 class="name"><?= $fetch_get['name']; ?></h3>
                                <p class="price">₱<?= $fetch_get['price']; ?></p>
                            </div>
                        </div>
                        <?php
                                }
                            }else{
                                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                                $select_cart->execute([$user_id]);

                                if ($select_cart->rowCount() > 0) {
                                    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                        $select_products->execute([$fetch_cart['product_id']]);
                                        $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                                        $sub_total = ($fetch_cart['qty'] * $fetch_products['price']) ;
                                        $grand_total += $sub_total;
                        ?>
                        <div class="flex">
                            <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
                            <div>
                                <h3 class="name"><?= $fetch_products['name']; ?></h3>
                                <p class="price">₱<?= $fetch_products['price']; ?> x <?= $fetch_cart['qty']; ?></p>
                            </div>
                        </div>
                        <?php
                                    }
                                }else{
                                    echo '<p class="empty">Your cart is empty</p>';
                                }
                            }
                        ?>
                    </div>
                    <div class="grand-total">
                        <span>Total Amount Payable: </span>
                        <p>₱<?= $grand_total; ?></p>
                    </div>
                </div>
            </div>
        </div>


        <?php include 'components/footer.php'; ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script src="js/user_script.js"></script>
        <?php include 'components/alert.php'; ?>
    </body>
</html>