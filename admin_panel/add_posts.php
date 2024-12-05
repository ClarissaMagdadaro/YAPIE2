<?php
// Include database connection
include '../components/connect.php';

// Check if user is logged in
if (!isset($_COOKIE['user_id']) || empty($_COOKIE['user_id'])) {
    echo "You must be logged in to create a post.";
    exit();
}

$user_id = $_COOKIE['user_id']; // User ID from the cookie

// Handle the post creation when the form is submitted
if (isset($_POST['create_post'])) {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // Define the target directory
    $target_dir = "../uploads/";

    // Create the uploads directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Initialize image_name as null (optional)
    $image_name = ''; // Set to an empty string as the default value

    // Handle image upload (optional)
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = time() . "_" . basename($_FILES['image']['name']); // Unique name
        $target_file = $target_dir . $image_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Image successfully uploaded
        } else {
            echo "Error uploading image.";
            exit();
        }
    }

    // Insert post data into the database
    $query = $conn->prepare("INSERT INTO posts (title, description, category, image, user_id) VALUES (?, ?, ?, ?, ?)");
    $query->execute([$title, $description, $category, $image_name, $user_id]);

    // Redirect to the View Post page
    header("Location: view_posts.php"); // Ensure this is the correct page to view posts
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="../css/view_post.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="../image/logo.png" alt="Logo" width="60">
        </div>
        <div class="right">
            <div class="bx bxs-user" id="user-btn"></div>
            <div class="toggle-btn"><i class="bx bx-menu"></i></div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar-container">
        <div class="sidebar">
            <h5>Menu</h5>
            <div class="navbar">
                <ul>
                    <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i> Dashboard</a></li>
                    <li><a href="add_products.php"><i class="bx bxs-shopping-bags"></i> Add Products</a></li>
                    <li><a href="view_product.php"><i class="bx bxs-food-menu"></i> View Product</a></li>
                    <li><a href="add_posts.php"><i class="bx bxs-shopping-bags"></i> Add Posts</a></li>
                    <li><a href="view_posts.php"><i class="bx bxs-food-menu"></i> View Post</a></li>
                    <li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i> Accounts</a></li>
                    <li><a href="../components/admin_logout.php" onclick="return confirm('Logout?');"><i class="bx bx-log-out"></i> Log Out</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-container">
        <div class="form-container">
            <form action="add_posts.php" method="POST" enctype="multipart/form-data">
                <h3>Create a New Post</h3>
                
                <!-- Title Field -->
                <label for="title">Post Title</label>
                <input type="text" name="title" id="title" required>

                <!-- Description Field -->
                <label for="description">Post Description</label>
                <textarea name="description" id="description" required></textarea>

                <!-- Category Field -->
                <label for="category">Category</label>
                <select name="category" id="category" required>
                    <option value="Art">Art</option>
                    <option value="Announcement">Announcement</option>
                </select>

                <!-- Image Field (Optional) -->
                <label for="image">Post Image</label>
                <input type="file" name="image" id="image" accept="image/*">

                <!-- Submit Button -->
                <button type="submit" name="create_post">Create Post</button>
            </form>
        </div>
    </div>
</body>
</html>
