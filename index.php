<?php
include 'components/connect.php';
require_once 'controllers/user-controller.php';

$user_id = '';
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Figuras D' Arte - Home Page</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'components/user_header.php'; ?>

    <!--- Slider section start--->

    <div class="slider-container">
        <div class="slider">
            <div class="slideBox active">
                <div class="textBox">
                    <!--<h1>U-Week</h1>
                    <a href="menu.php" class="btn">Join Now!</a>-->
                </div>
                <div class="imgBox">
                    <img src="image/event1.png">
                </div>
            </div>
            <!-- More slides here -->
        </div>
        <ul class="controls">
            <li onclick="nextSlide();" class="next"><i class="bx bx-right-arrow-alt"></i></li>
            <li onclick="prevSlide();" class="prev"><i class="bx bx-left-arrow-alt"></i></li>
        </ul>
    </div>
    <!--- Slider section end --->

    <!--- Categories section start--->

    <div class="categories">
        <div class="heading">
            <h1>Categories Features</h1>
            <img src="image/separator-img.png">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/accessories.webp">
                <a href="menu.php" class="btn">Merchandise</a>
            </div>
            <div class="box">
                <img src="image/paintings.jpg">
                <a href="menu.php" class="btn">Traditional Art</a>
            </div>
            <div class="box">
                <img src="image/prints.webp">
                <a href="menu.php" class="btn">Digital Art</a>
            </div>
        </div>
    </div>
    <!--- Categories section end --->

    <!--- Popular Topics section start --->

    <div class="fandoms">
        <div class="f-banner">
            <h1>Popular Topics</h1>
        </div>
        <div class="box-container">
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/genshin.png">
                <div class="box-details fadeIn-bottom">
                    <h1>Genshin</h1>
                    <p>Hoyoverse</p>
                    <a href="menu.php" class="btn">Explore More</a>
                </div>
            </div>

            <!-- View Posts link -->
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/viewposts.jpg"> <!-- Image for view posts -->
                <div class="box-details fadeIn-bottom">
                    <h1>View Posts</h1>
                    <p>Check out the latest posts from users</p>
                    <a href="allpost.php" class="btn">View Posts</a> <!-- Updated link -->
                </div>
            </div>
        </div>
    </div>
    <!--- Popular Topics section end --->

    <!--- Support section starts --->

    <div class="support">
        <div class="box-container">
            <img src="image/glyf2.jpg">
            <div class="detail">
                <h1>Who are we?</h1>
                <br>
                <a href="about-us.php" class="btn">Learn our story</a>
            </div>
        </div>
    </div>
    <!--- Support section end --->

    <?php include 'components/footer.php'; ?>
    <script src="js/user_script.js"></script>
</body>
</html>
