<?php
// add product to cart

if (isset($_POST['add_to_cart'])) {
    if (!empty($user_id)) {
        // Ensure that $product_id is set
        if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
            $product_id = $_POST['product_id']; // assuming product_id is sent via POST
        } else {
            $warning_msg[] = 'Product ID is missing';
            return; // exit the script if product_id is not set
        }

        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        // Check if product already exists in the cart
        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $verify_cart->execute([$user_id, $product_id]);

        $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $max_cart_items->execute([$user_id]);

        if ($verify_cart->rowCount() > 0) {
            // If product already exists in cart, update the quantity
            $existing_item = $verify_cart->fetch(PDO::FETCH_ASSOC);
            $new_qty       = $existing_item['qty'] + $qty;
            $update_qty    = $conn->prepare("UPDATE `cart` SET qty = ? WHERE user_id = ? AND product_id = ?");
            $update_qty->execute([$new_qty, $user_id, $product_id]);
            $success_msg[] = 'Product quantity updated in your cart successfully';
        } elseif ($max_cart_items->rowCount() >= 35) {
            $warning_msg[] = 'Your cart is full';
        } else {
            // Fetch the product price
            $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            // Insert into cart without specifying `id` (assuming it auto-increments)
            $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, product_id, price, qty) VALUES(?,?,?,?)");
            $insert_cart->execute([$user_id, $product_id, $fetch_price['price'], $qty]);

            $success_msg[] = 'Product added to your cart successfully';
        }
    } else {
        $warning_msg[] = 'Please login to add product to cart';
    }
}
?>
