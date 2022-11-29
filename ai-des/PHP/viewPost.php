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

$postID = $_GET['postID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link rel="icon" href="../asset/Logo-Dark.png">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/viewPostStyle.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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

    <!-- GET MAX POST ID -->
    <?php
    $maxPostID = mysqli_query($connect, ("SELECT COUNT(postID) AS maxID FROM post"));
    $maxID = mysqli_fetch_assoc($maxPostID);
    ?>

    <div class="content">
        <div id="slider-container">
            <div id="slider-content" class="slider">
                <a href="viewPost.php?postID=<?php
                                                if ($postID == 1) {
                                                    echo $maxID['maxID'];
                                                } else {
                                                    echo $postID - 1;
                                                }
                                                ?>" id="prev"> <button id="prev"> <span>
                            < </span> </button> </a>
                <div class="slider">
                    <!--  ---------------------------------- SLIDER CONTENT ---------------------------------------- -->

                    <?php
                    $data = mysqli_query($connect, ("SELECT u.userID, postID, u.username, u.email, postContent, date, anonymous, u.profilePict, u.MembershipID, u.badge FROM post p, user u WHERE u.userID = p.userID AND postID = " . $postID . " LIMIT 1"));
                    ?>

                    <?php while ($d = mysqli_fetch_array($data)) { ?>
                        <?php if($d['MembershipID'] == 1 && $d['anonymous'] == 0){ ?>
                            <div class="post" style="background-color: #C8C1E8; border:solid 2px #fff;;">             
                        <?php }else{ ?>
                            <div class="post">
                        <?php } ?>
                            <?php if($d['anonymous']==0){ ?>
                                <a href="myPost.php?username=<?php echo $d['username'] ?>">
                            <?php }else{ ?>
                                <a href="viewPost.php?postID=<?php echo $d['postID']?>">
                            <?php } ?>
                                <div class="profile">
                                    <?php
                                    if ($d['anonymous'] == 0) {
                                        if($d['profilePict'] != NULL){
                                    ?>
                                        <img class="centered-and-cropped" width="50" height="50" 
                                        style="border-radius:50%" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($d['profilePict']); ?>" /> 
                                    <?php }else{ ?>
                                        <img src="../asset/empty.png" width="50" height="50" 
                                        style="border-radius:50%" alt="profile_picture">
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
                                        <img src="../asset/anonymous.png" width="50" height="50" 
                                        style="border-radius:50%" alt="profile_picture">
                                        <div>
                                            <p class="headername"> Anonymous </p>
                                            <p class="headeremail"> <?php echo $d['date']; ?> </p>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </a>
                            <div class="message">
                                <p> <?php echo $d['postContent']; ?> </p>
                            </div>
                            <div class="status">
                                <img src="../asset/like.png" alt="">
                                <p class="like">100</p>
                            </div>
                            <!-- </a> -->
                        </div>
                    <?php } ?>

                    <!--  ---------------------------------- SLIDER CONTENT ---------------------------------------- -->
                </div>
                <a href="viewPost.php?postID=<?php
                                                if ($postID == $maxID['maxID']) {
                                                    echo 1;
                                                } else {
                                                    echo $postID + 1;
                                                }
                                                ?>" id="next"> <button id="next"> <span>></span> </button> </a>
            </div>
        </div>
    </div>
    </div>
    </div>

    <h1 class="separator-text">MORE POST</h1>

    <div class="recommend-content">
        <?php
        $data1 = mysqli_query($connect, ("SELECT postID, u.username, u.email, postContent, date, anonymous, profilePict, MembershipID, badge FROM post p, user u WHERE u.userID = p.userID AND postID NOT LIKE '" . $_GET['postID'] . "' ORDER BY date DESC LIMIT 6"));
        ?>
        <?php while ($d1 = mysqli_fetch_array($data1)) { ?>
            <?php if($d1['MembershipID'] == 1 && $d1['anonymous'] == 0){ ?>
                <div class="recommend" style="background-color: #C8C1E8; border:solid 2px #fff;">             
            <?php }else{ ?>
                <div class="recommend">
            <?php } ?>
                <a href="viewPost.php?postID=<?php echo $d1['postID']; ?>">
                        <div class="profile">
                            <?php
                            if ($d1['anonymous'] == 0) {
                                if ($d1['profilePict'] != NULL) {
                            ?>
                                    <img class="centered-and-cropped" width="50" height="50" style="border-radius:50%" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($d1['profilePict']); ?>" />
                                <?php } else { ?>
                                    <img src="../asset/empty.png" width="50" height="50" style="border-radius:50%" alt="profile_picture">
                                <?php } ?>
                                <div>
                                    <p class="headername"> <?php echo $d1['username']; ?> </p>
                                    <p class="headeremail"> <?php echo $d1['date']; ?> </p>
                                </div>
                                <?php if($d1['badge']!=NULL && $d1['MembershipID']==1){?>
                                <div>
                                    <img src="../asset/badge/<?php echo ($d1['badge']) ?>.png" alt="" class="centered-and-cropped" width="50" height="50" style="margin-left: 10px;">
                                </div>
                                <?php } ?>
                            <?php } else {
                            ?>
                                <img src="../asset/anonymous.png" width="50" height="50" style="border-radius:50%" alt="profile_picture">
                                <div>
                                    <p class="headername"> Anonymous </p>
                                    <p class="headeremail"> <?php echo $d1['date']; ?> </p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="message">
                            <p> <?php echo $d1['postContent']; ?> </p>
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
<script src="../JS/viewPost.js"></script>

</html>