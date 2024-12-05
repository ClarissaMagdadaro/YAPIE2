<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Figuras D' Arte - About Us Page</title>
        <link rel="stylesheet" type="text/css" href="css/user_style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel='stylesheet'>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php include 'components/user_header.php'; ?>
        
        <div class="artist">
            <div class="box-container">
                <div class="box">
                    <div class="heading">
                        <span>Artists' Hub</span>
                        <h1>Grupo Letras Y Figuras</h1>
                    </div>
                    <p>GRUPO LETRAS Y FIGURAS (also known as GLYF) of the University of St. La Salle is a collective of young and self-taught artists in the visual arts field. GLYF is part of the institutional organization of The Artists’ Hub as one of its clubs, specifically the visual arts club.</p>
                    <p>Few members started to explore how to sell art and 'lo and behold, Figuras d' Arte came to be</p>
                    <div class="flex-btn">
                        <a href="artists.php" class="btn">Explore Our Artists</a>
                        <a href="menu.php" class="btn">Visit Our Shop</a>
                    </div>
                </div>
                <div class="box">
                    <img src="image/glyf2.jpg" class="img">
                </div>
            </div>
        </div>
        <!--- Artist story section start--->
        <div class="story">
            <div class="heading">
                <h1>Our Story</h1>
                <img src="image/separator-img.png">
            </div>
            <p>Figuras d' Arte aims to spread out their talents and knowledge on the visual arts field everywhere and in any way possible. This mission is reflected in their logo, which features a pencil growing out leaves that symbolizes life in art, and the essence of art as a living and growing entity. The pencil symbolizes creativity and artistic expression, while the leaves represent growth, vitality, and the continuous evolution of art. </p>
        </div>
        <div class="container">
            <div class="box-container">
                <div class="img-box">
                    <img src="image/love.jpg">
                </div>
                <div class="box">
                    <div class="heading">
                        <h1>Taking Visual Arts To New Heights</h1>
                        <img src="image/separator-img.png">
                    </div>
                    <p>By embracing innovative techniques, modern technologies, and diverse artistic expressions, the visual arts community is evolving into a dynamic force that inspires change, challenges perspectives, and redefines the role of art in today's world. Through this journey, artists are pushing the limits of their craft, elevating the impact and accessibility of visual storytelling to unprecedented levels.</p>
                </div>
            </div>
        </div>
        <!--- Artist story section end--->
        <!--- Team section start--->
        <div class="team">
            <div class="heading">
                <h1>The Team Behind The Website</h1>
                <img src="image/separator-img.png" alt="">
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="image/albedo.jpg" class="img">
                    <div class="content">
                        <h2>Shannon Po</h2>
                        <p>"We will win. I'll guarantee it."</p>
                    </div>
                </div>
                <div class="box">
                    <img src="image/alhaitham.jpg" class="img">
                    <div class="content">
                        <h2>Clarissa Magdadaro</h2>
                        <p>"Tell me what you want and I'll deliver."</p>
                    </div>
                </div>
                <div class="box">
                    <img src="image/amber.jpg" class="img">
                    <div class="content">
                        <h2>Giannah Trafanco</h2>
                        <p>"I've got high hopes in the future of art."</p>
                    </div>
                </div>
            </div>
        </div>
        <!--- Team section end--->
        <!--- Mission section start--->
        <div class="mission">
            <div class="box-container">
                <div class="box">
                    <div class="heading">
                        <h1>Our Mission</h1>
                        <img src="image/separator-img.png">
                    </div>
                    <div class="detail">
                        <div>
                            <h2>sjhbfgfsd</h2>
                            <p>alfsdjfnsjd</p>
                        </div>
                    </div>
            </div>
        </div>
        <!--- Mission section end--->
        





        <?php include 'components/footer.php'; ?>
        <script src="js/user_script.js"></script>
    </body>
</html>