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
    <title>Homepage</title>
    <link rel="icon" href="../asset/Logo-Dark.png">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/homestyle.css">
    <script>
        function TestsFunction() {
            var T = document.getElementById("TestsDiv"),
                displayValue = "block";
            if (T.style.display == "block")
                displayValue = "none";

            T.style.display = displayValue;
        }
    </script>

</head>

<body>

    <?php if ($_SESSION['user']['MembershipID'] == 0) { ?>
        <!-- RANDOM THE ADS -->
        <?php
        $randad = rand(1, 4);
        ?>

        <!-- POP UP ADS -->
        <div id="popbg">
            <div id="popup">
                <!-- Now this is the button which closes the popup-->
                <!-- <button id="close">Close button</button> -->
                <!-- <div class="numbertext">1 / 4</div> -->

                <!-- and here comes the image -->
                <?php if ((int)$randad == 1) { ?>
                    <a href="https://www.tokopedia.com/">
                        <img src="../asset/ads/Tokopedia.jpg" alt="popup">
                    </a>
                <?php } else if ((int)$randad == 2) { ?>
                    <a href="https://www.lazada.co.id/">
                        <img src="../asset/ads/Lazada.jpg" alt="popup">
                    </a>
                <?php } else if ((int)$randad == 3) { ?>
                    <a href="https://shopee.co.id/m/bayar-di-tempat">
                        <img src="../asset/ads/Shopee.jpg" alt="popup">
                    </a>
                <?php } else if ((int)$randad == 4) { ?>
                    <a href="https://www.blibli.com/promosi/mvg-work-hard-play-hard?appsWebview=true">
                        <img src="../asset/ads/Blibli.jpg" alt="popup">
                    </a>
                <?php } ?>
                <!-- and finally we close the POPUP FRAME-->
                <!-- everything on it will show up within the popup so you can add more things not just an image -->
                <div id="close">CLOSE &#10006;</div>
            </div>
        </div>
    <?php } else { ?>
    <?php } ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script>
        //your jquery script here
        //with this first line we're saying: "when the page loads (document is ready) run the following script"
        $(document).ready(function() {

            //select the POPUP FRAME and show it
            $("#popbg").hide().fadeIn(500);
            $("#popup").hide().fadeIn(500);

            //close the POPUP if the button with id="close" is clicked
            $("#close").on("click", function(e) {
                e.preventDefault();
                $("#popbg").fadeOut(300);
                $("#popup").fadeOut(300);
            });

        });
    </script>

    <div class="header">
        <a href="homepage.php"><img class="logo" src="../asset/Logo-Dark.png" alt="Logo"></a>
        <div class="profile" onclick="TestsFunction()">
            <?php
            $result = mysqli_query($connect, ("SELECT profilePict FROM user WHERE userID = '" . $_SESSION['user']['userID'] . "'"));
            $row = $result->fetch_assoc();
            ?>

            <?php if ($row['profilePict'] != NULL) { ?>
                <div class="gallery">
                    <img class="centered-and-cropped" width="50" height="50" style="border-radius:50%" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['profilePict']); ?>" />
                </div>
            <?php } else { ?>
                <img width="50" height="50" style="border-radius:50%" src="../asset/empty.png" alt="profile_picture">
            <?php } ?>
            <div>
                <p class="headername"> <?php echo ($_SESSION['user']['username']) ?> </p>
                <p class="headeremail"> <?php echo ($_SESSION['user']['email']) ?></p>
            </div>
            <?php if($_SESSION['user']['badge']!=NULL && $_SESSION['user']['MembershipID']==1){?>
            <div>
                <img src="../asset/badge/<?php echo ($_SESSION['user']['badge']) ?>.png" alt="" class="centered-and-cropped" width="50" height="50" style="margin-left: 10px;">
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="profile-click" id="TestsDiv">
        <div class="logout">
            <a href="myPost.php?username=<?php echo$_SESSION['user']['username'] ?>"><button class="myPost">My Posts</button></a>
            <a href="customizeProfile.php"><button class="customProfile">Edit Profile</button></a>
            <?php if ($_SESSION['user']['MembershipID'] == 0) { ?>
                <a href="subscribtion.php#benefit"><button class="customProfile">Subscribe</button></a>
            <?php } ?>
            <a href="logoutValidation.php">
                <button class="logoutbtn">LOGOUT</button>
            </a>
        </div>
    </div>
    
    <div class="header-space">
    </div>

    <a href="createPost.php">
        <div class="createPost">
            <p>+</p>
        </div>
    </a>


    <div class="content">
        <div>
            <form action="searchValidation.php" method="POST">
                <input type="text" placeholder="Search" name="search">
            </form>
        </div>
        <div class="post-list">
            <?php
            $data = mysqli_query($connect, ("SELECT postID, u.username, postContent, date, anonymous, profilePict, MembershipID, badge FROM post p, user u WHERE u.userID = p.userID ORDER BY postID DESC"));

            if (empty($data)) {
            ?>
                <div class="no-result">
                    <p>No results found...</p>
                </div>
            <?php
            }
            ?>

            <?php while ($d = mysqli_fetch_array($data)) { ?>
                <?php if($d['MembershipID'] == 1 && $d['anonymous'] == 0){ ?>
                    <div class="post" style="background-color: #C8C1E8; border:solid 2px #fff;">             
                <?php }else{ ?>
                    <div class="post">
                <?php } ?>
                    <a href="viewPost.php?postID=<?php echo $d['postID']; ?>">
                        <div class="profile">
                            <?php
                            if ($d['anonymous'] == 0) {
                                if ($d['profilePict'] != NULL) {
                            ?>
                                    <img class="centered-and-cropped" width="50" height="50" style="border-radius:50%" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($d['profilePict']); ?>" />
                                <?php } else { ?>
                                    <img src="../asset/empty.png" width="50" height="50" style="border-radius:50%" alt="profile_picture">
                                <?php } ?>
                                <div>
                                    <p class="headername"> <?php echo $d['username']; ?> </p>
                                    <p class="headeremail"> <?php echo $d['date']; ?> </p>
                                </div>
                                <?php if($d['badge']!=NULL && $d['MembershipID']==1){?>
                                <div>
                                    <img src="../asset/badge/<?php echo ($d['badge']) ?>.png" alt="" class="centered-and-cropped" width="50" height="50" style="margin-left: 10px;">
                                </div>
                                <?php } ?>
                            <?php } else {
                            ?>
                                <img src="../asset/anonymous.png" width="50" height="50" style="border-radius:50%" alt="profile_picture">
                                <div>
                                    <p class="headername"> Anonymous </p>
                                    <p class="headeremail"> <?php echo $d['date']; ?> </p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="message">
                            <p> <?php echo $d['postContent']; ?> </p>
                        </div>
                        <div class="status">
                            <img src="../asset/like.png" alt="">
                            <p class="like">100</p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <footer>
        <div class="branding">
            <img style="height: 150px;" src="../asset/Logo-Dark.png" alt="">
            <!-- <h1 class="brand">SHOUT</h1> -->
            <h1 class="brandtext">Share Your Thoughts</h1>
        </div>
        <!-- <hr class="footer-line"> -->
        <div class="footmenu">
            <a href="homepage.php"><p class="footermenu">HOME</p></a>
            <a href="subscribtion.php"><p class="footermenu">ABOUT</p></a>
            <p class="footermenu">CONTACT US</p>
        </div>
        <p class="copyright">Copyright © 2021 All Rights Reserved | By SHOUT Team</p>
    </footer>
</body>

</html>