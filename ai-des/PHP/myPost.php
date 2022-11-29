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

$username = $_GET['username'];
$data = mysqli_query($connect, ("SELECT postID, u.username, postContent, date, anonymous, profilePict FROM post p, user u WHERE u.userID = p.userID AND username = '".$username."' ORDER BY postID DESC"));

$totalPost = 0;
$nonAnonPost = 0;
$anonPost = 0;
while ($s = mysqli_fetch_array($data)) {
    $totalPost++;
    if($s['anonymous']==0){
        $nonAnonPost++;
    }else{
        $anonPost++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $username ?> </title>
    <link rel="icon" href="../asset/Logo-Dark.png">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/homestyle.css">
    <link rel="stylesheet" href="../CSS/myPostStyle.css">
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


    <div class="content">
        <div class="myProfile">
            <div>
            <?php 
            $result = mysqli_query($connect, ("SELECT profilePict FROM user WHERE username = '".$username."'"));
            $row = $result->fetch_assoc();
            ?>

            <?php if($row['profilePict'] != NULL){ ?> 
            <div class="gallery"> 
                <img class="centered-and-cropped" width="50" height="50" 
                style="border-radius:50%" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['profilePict']); ?>" /> 
            </div> 
            <?php }else{ ?> 
                <img style="border-radius:50%" src="../asset/empty.png" alt="profile_picture">
            <?php } ?>
            </div>
            <div class="post-info">
                <p> <?php echo ($username) ?> </p>
                <?php if($_SESSION['user']['username']==$username){ ?>
                    <p class="info">Total Posts: <?php echo $totalPost; ?> </p>
                    <p class="info">Anonymous Posts: <?php echo $anonPost; ?> </p>
                <?php } ?>
                <p class="info">Non-Anonymous Posts: <?php echo $nonAnonPost; ?> </p>
                
            </div>        
        </div>

        <div class="post-list">
            <?php
            $postData = mysqli_query($connect, ("SELECT postID, u.username, postContent, date, anonymous, profilePict, badge, MembershipID FROM post p, user u WHERE u.userID = p.userID AND username = '".$username."' ORDER BY postID DESC"));
            if(empty($postData)){
            ?>    
                <div class="no-result">
                    <p>No results found...</p>
                </div>
            <?php
            }
            ?>

            <?php while ($d = mysqli_fetch_array($postData)){ ?>
                <?php if($d['anonymous']==0 || $_SESSION['user']['username']==$username){ ?>
                    <div class="post">
                    <a href="viewPost.php?postID=<?php echo $d['postID']; ?>">
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