<?php
// adding products to wishlist
if (isset($_POST['add_to_wishlist'])) {
    if (!empty($user_id)) {

        // Ensure that $product_id is set
        if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
            $product_id = $_POST['product_id']; // assuming the product_id is sent via POST
        } else {
            $warning_msg[] = 'Product ID is missing';
            return; // exit the script if product_id is not set
        }

        // Check if the product already exists in wishlist
        $verify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
        $verify_wishlist->execute([$user_id, $product_id]);

        // Check if the product is in the cart
        $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $cart_num->execute([$user_id, $product_id]);

        if ($verify_wishlist->rowCount() > 0) {
            $warning_msg[] = 'Product already exists in your wishlist';
        } elseif ($cart_num->rowCount() > 0) {
            $warning_msg[] = 'Product already exists in your cart';
        } else {
            // Fetch the product price
            $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            // Insert into wishlist without specifying `id` (assuming it auto-increments)
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (user_id, product_id, price) VALUES(?,?,?)");
            $insert_wishlist->execute([$user_id, $product_id, $fetch_price['price']]);

            $success_msg[] = 'Product added to your wishlist successfully';
        }
    } else {
        $warning_msg[] = 'Please login to add product to wishlist';
    }
}
?>
