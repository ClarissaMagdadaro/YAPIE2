<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
    exit();
}

// Handle product deletion
if (isset($_POST['delete'])) {
    $p_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);
    $delete_product = $conn->prepare("DELETE FROM products WHERE id = ?");
    $delete_product->execute([$p_id]);
    $success_msg[] = 'Product Deleted Successfully';
}

// Handle toggling of bidding status
if (isset($_POST['toggle_bidding'])) {
    $p_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);
    $bidding_status = $_POST['bidding_enabled'] == '1' ? 0 : 1;

    $update_bidding = $conn->prepare("UPDATE products SET bidding_enabled = ? WHERE id = ?");
    $update_bidding->execute([$bidding_status, $p_id]);
    $success_msg[] = 'Bidding status updated successfully!';
}

// Handle updating bidding details
if (isset($_POST['update_bidding'])) {
    $p_id = filter_var($_POST['product_id'], FILTER_SANITIZE_STRING);
    $starting_price = filter_var($_POST['starting_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $bidding_start = $_POST['bidding_start'];
    $bidding_end = $_POST['bidding_end'];

    $update_bidding = $conn->prepare("UPDATE products SET starting_price = ?, bidding_start = ?, bidding_end = ? WHERE id = ?");
    $update_bidding->execute([$starting_price, $bidding_start, $bidding_end, $p_id]);
    $success_msg[] = 'Bidding details updated successfully!';
}

// Automatically disable expired bidding
$current_time = date('Y-m-d H:i:s');
$update_expired_bids = $conn->prepare("UPDATE products SET bidding_enabled = 0 WHERE bidding_enabled = 1 AND bidding_end < ?");
$update_expired_bids->execute([$current_time]);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Figuras D Arte - Admin Products Management</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="show-post">
            <div class="heading">
                <h1>Manage Products</h1>
                <img src="../image/separator-img.png" alt="✦ . ⁺ . ✦ . ⁺ . ✦">
            </div>
            <div class="box-container">
                <?php
                $select_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
                $select_products->execute([$seller_id]);
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        $is_expired = isset($fetch_products['bidding_end']) && $fetch_products['bidding_end'] < $current_time;
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="bidding_enabled" value="<?= $fetch_products['bidding_enabled']; ?>">

                    <?php if (!empty($fetch_products['image'])) { ?>
                        <img src="../uploaded_files/<?= $fetch_products['image']; ?>" class="image">
                    <?php } ?>

                    <div class="status" style="color: <?= $fetch_products['status'] == 'active' ? 'limegreen' : 'coral'; ?>">
                        <?= $fetch_products['status']; ?>
                    </div>
                    <div class="price">
                        ₱<?= $fetch_products['price']; ?>
                    </div>
                    <div class="content">
                        <div class="title"><?= $fetch_products['name']; ?></div>
                        <div class="flex-btn">
                            <a href="edit_product.php?id=<?= $fetch_products['id']; ?>" class="btn">Edit</a>
                            <button type="submit" name="delete" class="btn" onclick="return confirm('Delete this product?');">Delete</button>
                            <a href="read_product.php?post_id=<?= $fetch_products['id']; ?>" class="btn">View</a>
                        </div>

                        <!-- Bidding Details Section -->
                        <div class="bidding-section">
                            <p>Bidding Enabled: <strong><?= $fetch_products['bidding_enabled'] ? 'Yes' : 'No'; ?></strong></p>
                            <p>Starting Price: ₱<?= isset($fetch_products['starting_price']) ? $fetch_products['starting_price'] : 'Not Set'; ?></p>
                            <p>Bidding Start: <?= isset($fetch_products['bidding_start']) ? $fetch_products['bidding_start'] : 'Not Set'; ?></p>
                            <p>Bidding End: <?= isset($fetch_products['bidding_end']) ? $fetch_products['bidding_end'] : 'Not Set'; ?></p>
                            <?php if ($is_expired): ?>
                                <p style="color: red;">Bidding has expired!</p>
                            <?php endif; ?>
                            <button type="submit" name="toggle_bidding" class="btn" <?= $is_expired ? 'disabled' : ''; ?>>
                                <?= $fetch_products['bidding_enabled'] ? 'Disable Bidding' : 'Enable Bidding'; ?>
                            </button>
                        </div>

                        <!-- Update Bidding -->
                    <div class="update-bidding">
                        <h4>Update Bidding Details</h4>
                        <label for="starting_price">Starting Price</label>
                        <input type="number" name="starting_price" step="0.01" value="<?= $fetch_products['starting_price']; ?>" required>
                        <label for="bidding_start">Start Date</label>
                        <input type="date" name="bidding_start" value="<?= date('Y-m-d', strtotime($fetch_products['bidding_start'])); ?>" required>
                        <label for="bidding_end">End Date</label>
                        <input type="date" name="bidding_end" value="<?= date('Y-m-d', strtotime($fetch_products['bidding_end'])); ?>" required>
                        <button type="submit" name="update_bidding" class="btn">Update</button>
                    </div>
                    </div>
                </form>
                <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>No Products Added Yet! <br> <a href="add_products.php" class="btn" style="margin-top: 1.5rem;">Add Products</a></p>
                        </div>
                    ';
                }
                ?>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/admin_script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
