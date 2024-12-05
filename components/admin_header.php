<?php
// Start session and include necessary files
session_start();
include '../components/connect.php'; 

// Initialize $seller_id to prevent "undefined variable" warning
$seller_id = $_COOKIE['seller_id'] ?? ''; // Assuming seller ID is stored in a cookie

if (!empty($seller_id)) {
    // Fetch profile only if seller ID exists
    $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
    $select_profile->execute([$seller_id]);

    if ($select_profile->rowCount() > 0) {
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    } else {
        $fetch_profile = ['image' => 'default.png', 'name' => 'Guest']; // Default fallback
    }
} else {
    $fetch_profile = ['image' => 'default.png', 'name' => 'Guest']; // Fallback for unauthenticated users
}
?>

<header>
    <div class="logo">
        <img src="../image/logo.png" alt="Logo" width="60">
    </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>
    </div>
    <div class="profile-detail">
        <div class="profile">
            <img src="../uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" class="logo-img" width="100">
            <p><?= htmlspecialchars($fetch_profile['name']); ?></p>
            <div class="flex-btn">
                <a href="profile.php" class="btn">Profile</a>
                <a href="../components/admin_logout.php" onclick="return confirm('Logout?');" class="btn">Log Out</a>
            </div>
        </div>
    </div>
</header>
<div class="sidebar-container">
    <div class="sidebar">
        <div class="profile">
            <img src="../uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" class="logo-img">
            <p><?= htmlspecialchars($fetch_profile['name']); ?></p>
        </div>
        <h5>Menu</h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i>Dashboard</a></li>
                <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i>Add Products</a></li>
                <li><a href="view_product.php"><i class="bx bxs-food-menu"></i>View Product</a></li>
                <li><a href="add_posts.php"><i class="bx bxs-shopping-bags"></i>Add Posts</a></li>
                <li><a href="view_posts.php"><i class="bx bxs-food-menu"></i>View Post</a></li>
                <li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i>Accounts</a></li>
                <li><a href="../components/admin_logout.php" onclick="return confirm('Logout');"><i class="bx bx-log-out"></i>Log Out</a></li>
            </ul>
        </div>
        <h5>Find Us</h5>
        <div class="social-links">
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram-alt"></i>
            <i class="bx bxl-linkedin"></i>
            <i class="bx bxl-twitter"></i>
            <i class="bx bxl-pinterest-alt"></i>
        </div>
    </div>
</div>
