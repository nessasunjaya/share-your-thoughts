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
    <title>Create Post</title>
    <link rel="icon" href="../asset/Logo-Dark.png">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/createPostStyle.css">
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
            <a href="myPost.php"><button class="myPost">My Posts</button></a>
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
    <div class="content">
        <div class="post">
            <div class="profile">
                <?php 
                $result = mysqli_query($connect, ("SELECT profilePict FROM user WHERE userID = '".$_SESSION['user']['userID']."'"));
                $row = $result->fetch_assoc();
                ?>
                <?php if($row['profilePict'] != NULL){ ?> 
                <div class="gallery"> 
                        <img class="centered-and-cropped" width="50" height="50" 
                        style="border-radius:50%" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['profilePict']); ?>" /> 
                </div> 
                <?php }else{ ?> 
                    <img class="centered-and-cropped" width="50" height="50" 
                    style="border-radius:50%" src="../asset/empty.png" alt="profile_picture">
                <?php } ?>
                <div>
                    <p class="headername"> <?php echo ($_SESSION['user']['username']) ?> </p>
                    <p class="headeremail"> <?php echo ($_SESSION['user']['email']) ?> </p>
                </div>
                <?php if($_SESSION['user']['badge']!=NULL && $_SESSION['user']['MembershipID']==1){?>
                <div>
                    <img src="../asset/badge/<?php echo ($_SESSION['user']['badge']) ?>.png" alt="" class="centered-and-cropped" width="50" height="50" style="margin-left: 10px;">
                </div>
                <?php } ?>
            </div>
            <form method="POST" action="createPostValidation.php">
                <textarea name="message" id="" placeholder="Type your thoughts here..."></textarea>
                <label class="container">Post as Anonymous
                    <input type="checkbox" name="anonym" value="anonym">
                    <span class="checkmark"></span>
                </label>
                <?php
                if(isset($_GET['error'])){
                ?>
                    <div class="error-message">
                    <?php echo $_GET['error']; ?>
                    </div>
                <?php 
                }
                ?>  
                <button type="submit">POST</button>
            </form>
        </div>
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