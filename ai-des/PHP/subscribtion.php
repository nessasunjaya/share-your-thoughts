<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location:login.php");
}

$host = "localhost";
$user = "root";
$password = "";
$db = "shout_db";

$connect = mysqli_connect($host, $user, $password);
mysqli_select_db($connect, $db);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link rel="stylesheet" href="../CSS/subscribe.css">
  <link rel="icon" href="../asset/Logo-Dark.png">
</head>

<body>

    <div class="banner">
        <div class="navbar">
            <a href="homepage.php"><img class="logo" src="../asset/Logo-White.png" alt="Logo"></a>
            <ul>
                <!-- a href download -> bisa buat download -->
                <li><a href="homepage.php">Homepage</a></li>
                <li><a href="#benefit">Benefits</a></li>
                <li><a href="#our-team">Our Team</a></li>
                <li><a href="#subscribe">Subscribe</a></li>
            </ul>
        </div>
        <div class="content">
            <h1>ABOUT US</h1>
            <p>SHOUT started as a project created by a group of students to fulfill their final exam.</p>
            <p>The development of SHOUT then increased and now is planning on making it available
                to be used by everyone to share positivity.
                <br>
                We believe that one thing that should be promoted in our daily lives is positivity,
                hence the creation of SHOUT.
            </p>
            <div>
                <a href="#subscribe"><button type="button"><span></span> SUBSCRIBE </button></a>
                <a href="#our-team"><button type="button"><span></span> OUR TEAM</button></a>
            </div>
        </div>
    </div>

    <h1 id="our-team">OUR TEAM</h1>
    <h4>We are from GROUP 8 Class LA02! Our members consists of V, F, A, and M.</h4>
    <div class="our-team">
        <div class="members">
            <img src="../asset/team/V.png" alt="">
            <p class="title">V</p>
            <p class="sub-title">Web Developer, Web Designer</p>
        </div>
        <div class="members">
            <img src="../asset/team/F.png" alt="">
            <p class="title">F</p>
            <p class="sub-title">Web Designer</p>
        </div>
        <div class="members">
            <img src="../asset/team/A.png" alt="">
            <p class="title">A</p>
            <p class="sub-title">Marketing</p>
        </div>
        <div class="members">
            <img src="../asset/team/M.png" alt="">
            <p class="title">M</p>
            <p class="sub-title">Marketing</p>
        </div>    
    </div>


    <h1 class="benefit" id="benefit">WHY SUBSCRIBE TO SHOUT?</h1>
    <h4 class="benefit">Subscribe to SHOUT to get these benefits</h4>
    <div class="subscribe">
        <div class="subscribe-card">
            <p class="title">ADS FREE</p>
            <p class="sub-title">No more ads to stop you from sharing your thoughts</p>
            <img src="../asset/benefit/no-ads.png" alt="">
        </div>
        <div class="subscribe-card">
            <p class="title">GET SPECIAL BADGE</p>
            <p class="sub-title">Show off your loyalty with a special badge</p>
            <img src="../asset/benefit/special badge.png" alt="">
        </div>
        <div class="subscribe-card">
            <p class="title">Special Background</p>
            <p class="sub-title">Your posts will have different colored background to stand out from the rest</p>
            <img src="../asset/benefit/special-bg.png" alt="">
        </div>
    </div>

    <div class="form-container" id="subscribe">
        <?php if($_SESSION['user']['MembershipID']==1){ ?>
            <div>
                <h1 style="color: #ffdce9; padding-top:40vh; padding-bottom: 0;">YOU ARE SUBSCRIBED! ☺</h1>
                <p style="padding-bottom:45vh; color:white;">
                    Thankyou for your subscription, we hope you enjoy the perks we have given for you :) <br>
                    Share as much positivity as possible to other people :)
                </p>                
            </div>
        <?php }else{ ?>
        <div>        
            <form action="subscribeValidation.php" method="POST" class="">
                <h1>Subscribe Now</h1>
                <input type="text" name="fName" placeholder="First Name" required>
                <input type="text" name="lName" placeholder="Last Name" required>
                <input type="date" name="DOB" id="" placeholder="Birthdate" required>
                <input type="text" name="CCN" id="" placeholder="Credit Card Number" required>
                <input type="text" name="phonenum" id="" placeholder="Phone Number" required>

                <p>Choose preferred Badge:</p>
                <div class="badge">
                
                <label>
                <input type="radio" name="badge" value="1" checked>
                <img src="../asset/badge/1.png" class="badge1">
                </label>

                <label>
                <input type="radio" name="badge" value="2">
                <img src="../asset/badge/2.png" class="badge2">
                </label>
 
                <label>
                <input type="radio" name="badge" value="3">
                <img src="../asset/badge/3.png" class="badge3">
                </label>

                </div>
                
                <?php 
                if(isset($_GET['error'])){
                ?>
                    <div class="error-message">
                    <?php echo $_GET['error']; ?>
                    </div>
                <?php 
                }
                ?>      
                <p class="error-message"></p>
                <input type="submit" class="submit">
            </form>
        </div>
        <?php } ?>
    </div>

    <footer>
        <div class="branding">
            <img style="height: 150px;" src="../asset/Logo-Dark.png" alt="">
            <!-- <h1 class="brand">SHOUT</h1> -->
            <h1 class="brandtext">Share Your Thoughts</h1>
        </div>
        <!-- <hr class="footer-line"> -->
        <div class="footmenu">
            <a href="homepage.php" style="text-decoration: none;"><p class="footermenu">HOME</p></a>
            <a href="subscribtion.php" style="text-decoration: none;"><p class="footermenu">ABOUT</p></a>
            <p class="footermenu">CONTACT US</p>
        </div>
        <p class="copyright">Copyright © 2021 All Rights Reserved | By SHOUT Team</p>
    </footer>
</body>