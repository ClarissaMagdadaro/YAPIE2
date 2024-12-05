<?php
// Ensure session or cookie is used to get the user ID
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Retrieve user ID from session
} elseif (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id']; // Retrieve user ID from cookie
} else {
    $user_id = null; // No user logged in
}
?>
<header class="header">
    <section class="flex">
        <a href="index.php" class="logo"><img src="image/logo.png" width="60px"></a>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="artists.php">Artists</a>
            <a href="about-us.php">About Us</a>
            <a href="allpost.php">Post</a>
            <a href="menu.php">Shop</a>
        </nav>
        <form action="search_product.php" method="post" class="search-form">
            <input type="text" name="search_product" placeholder="Search Product..." required maxlength="100">
            <button type="submit" class="bx bx-search-alt-2" id="search_product_btn"></button>
        </form>
        <div class="icons">
            <div class="bx bx-list-plus" id="menu-btn"></div>
            <div class="bx bx-search-alt-2" id="search-btn"></div>

            <?php 
                if ($user_id) {
                    $count_wishlist_item = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                    $count_wishlist_item->execute([$user_id]);
                    $total_wishlist_items = $count_wishlist_item->rowCount();
                } else {
                    $total_wishlist_items = 0; // No user logged in
                }
            ?>

            <a href="wishlist.php"><i class="bx bx-heart"></i><sup><?= $total_wishlist_items; ?></sup></a>
            
            <?php 
                if ($user_id) {
                    $count_cart_item = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $count_cart_item->execute([$user_id]);
                    $total_cart_items = $count_cart_item->rowCount();
                } else {
                    $total_cart_items = 0; // No user logged in
                }
            ?>
            
            <a href="cart.php"><i class="bx bx-cart"></i><sup><?= $total_cart_items; ?></sup></a>
            <div class="bx bxs-user" id="user-btn"></div>
        </div>
        <div class="profile-detail">
            <?php
                if ($user_id) {
                    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                    $select_profile->execute([$user_id]);

                    if ($select_profile->rowCount() > 0) {
                        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?> 
            <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
            <h3 style="margin-bottom: 1rem;"><?= $fetch_profile['name']; ?></h3>
            <div class="flex-btn">
                <a href="profile.php" class="btn">View Profile</a>
                <a href="components/user_logout.php" onclick="return confirm('Logout?');" class="btn">Log Out</a>
            </div>
            <?php
                    } 
                } else { ?>
                    <h3 style="margin-bottom: 1rem;">Please login or register</h3>
                    <div class="flex-btn">
                        <a href="web_login.php" class="btn">Login</a>
                        <a href="web_register.php" class="btn">Register</a>
                    </div>
            <?php } ?>
        </div>
    </section>
</header>
