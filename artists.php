<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Figuras D Arte - Artists</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
<div class="main-container">
    <?php include 'components/user_header.php'; ?> 

    <section class="products">
        <div class="heading">
            <h1>Artists</h1>
            <img src="image/separator-img.png" alt="✦ . ⁺ . ✦ . ⁺ . ✦">
        </div>

        <div class="box-container">
            <?php
                // Fetch the artists from the database
                $select_sellers = $conn->prepare("SELECT * FROM `sellers`");
                $select_sellers->execute();
                if ($select_sellers->rowCount() > 0) {
                    while ($fetch_sellers = $select_sellers->fetch(PDO::FETCH_ASSOC)) {
                        $seller_id = $fetch_sellers['id'];
            ?>
            <form action="" method="post" class="box">
                <img src="uploaded_files/<?= $fetch_sellers['image']; ?>" class="image" alt="Seller Image">
                <div class="content">
                    <h1 class="name"><?= $fetch_sellers['name']; ?></h1>
                    <div class="button">
                        <div><h3 class="name"><?= $fetch_sellers['email']; ?></h3></div>
                        <div>
                            <a href="view_profile.php?seller_id=<?= $fetch_sellers['id'] ?>" class="bx bxs-show">View Profile</a>
                        </div>
                    </div>
                </div>
            </form>
            <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>No Sellers Registered Yet!</p>
                        </div>    
                    ';
                }
            ?> 
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/admin_script.js"></script>

<?php include 'components/alert.php'; ?>
</body>
</html>
