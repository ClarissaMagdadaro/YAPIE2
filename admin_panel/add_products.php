<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    header('location:login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Ensure form is submitted using POST
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = isset($_POST['price']) ? filter_var($_POST['price'], FILTER_VALIDATE_FLOAT) : null;
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT);

    $status = isset($_POST['publish']) ? 'active' : 'deactive';

    // Handle Image Upload
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $unique_image_name = time() . '_' . $image;
    $image_folder = '../uploaded_files/' . $unique_image_name;

    // Ensure the directory exists
    if (!is_dir('../uploaded_files/')) {
        mkdir('../uploaded_files/', 0777, true);
    }

    // Bidding logic
    $enable_bidding = isset($_POST['enable_bidding']) ? 1 : 0;
    $starting_price = $enable_bidding ? filter_var($_POST['starting_price'], FILTER_VALIDATE_FLOAT) : null;

    // Validate required fields
    $errors = [];
    if (!$stock || $stock < 0) $errors[] = 'Stock must be a non-negative number.';
    if ($enable_bidding && !$starting_price) {
        $errors[] = 'Starting price must be filled when bidding is enabled.';
    }

    // If price is required and bidding is not enabled
    if (!$enable_bidding && (!$price || $price <= 0)) {
        $errors[] = 'Invalid product price.';
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
    } else {
        // Process the upload
        if (move_uploaded_file($image_tmp_name, $image_folder)) {
            $insert_product = $conn->prepare(
                "INSERT INTO `products` (seller_id, name, price, image, stock, product_detail, status, enable_bidding, starting_price)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $insert_product->execute([$seller_id, $name, $price, $unique_image_name, $stock, $description, $status, $enable_bidding, $starting_price]);
            $success_msg = isset($_POST['publish']) ? 'Product added successfully!' : 'Product saved as draft!';
            echo "<script>alert('$success_msg'); window.location.href='view_product.php';</script>";
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Figuras D Arte - Admin Add Products Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="post-editor">
            <div class="heading">
                <h1>Add Products</h1>
                <img src="../image/separator-img.png">
            </div>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="register">
                    <div class="input-field">
                        <p>Product Name <span>*</span></p>
                        <input type="text" name="name" maxlength="100" placeholder="Add Product Name..." required class="box">
                    </div>
                    <div class="input-field" id="price-field-container">
                        <p>Product Price <span>*</span></p>
                        <input type="number" name="price" id="price-field" maxlength="100" placeholder="Add Product Price..." class="box">
                    </div>
                    <div class="input-field">
                        <input type="checkbox" name="enable_bidding" id="enable_bidding" onchange="toggleBiddingFields()">
                        <label for="enable_bidding">Enable Bidding</label>
                    </div>
                    <div id="bidding-fields" style="display: none;">
                        <div class="input-field">
                            <label for="starting_price">Starting Price</label>
                            <input type="number" name="starting_price" id="starting_price" min="0" step="0.01" class="box">
                        </div>
                    </div>
                    <div class="input-field">
                        <p>Product Detail <span>*</span></p>
                        <textarea name="description" required maxlength="1000" placeholder="Add Product Detail..." class="box"></textarea>
                    </div>
                    <div class="input-field">
                        <p>Product Stock <span>*</span></p>
                        <input type="number" name="stock" maxlength="10" min="0" max="9999" placeholder="Add Product Stock..." required class="box">
                    </div>
                    <div class="input-field">
                        <p>Product Image <span>*</span></p>
                        <input type="file" name="image" accept="image/*" required class="box">
                    </div>
                    <div class="flex-btn">
                        <input type="submit" name="publish" value="Add Product" class="btn">
                        <input type="submit" name="draft" value="Save as Draft" class="btn">
                    </div>
                </form>
            </div>
        </section>
    </div>

    <script>
        function toggleBiddingFields() {
            const enableBidding = document.getElementById('enable_bidding');
            const biddingFields = document.getElementById('bidding-fields');
            const priceFieldContainer = document.getElementById('price-field-container');
            
            if (enableBidding.checked) {
                biddingFields.style.display = 'block';
                priceFieldContainer.style.display = 'none';
            } else {
                biddingFields.style.display = 'none';
                priceFieldContainer.style.display = 'block';
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/admin_script.js"></script>
    <?php include '../components/alert.php'; ?>
</body>
</html>
