<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location:login.php");
}

$host="localhost";
$user="root";
$password="";
$db="shout_db";

$connect = mysqli_connect($host, $user, $password);
mysqli_select_db($connect, $db);

if(isset($_POST['fName']) && isset($_POST['lName']) && isset($_POST['DOB']) && isset($_POST['CCN']) && isset($_POST['phonenum'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $fName = validate($_POST['fName']);
    $lName = validate($_POST['lName']);
    $DOB = validate($_POST['DOB']);
    $CCN = validate($_POST['CCN']);
    $phonenum = validate($_POST['phonenum']);
    $badge = validate($_POST['badge']);
    $membershipID = 1;

    if(strlen($CCN)!=16){
        header("Location:subscribtion.php?error=Credit Card Number must be 16 Characters and Numeric");
        exit();
    }
    else if(is_numeric($CCN)==false){
        header("Location:subscribtion.php?error=Credit Card Number must be 16 Characters and Numeric");
        exit();
    }
    else if(strlen($phonenum) < 10 || is_numeric($phonenum)==false){
        header("Location:subscribtion.php?error=Phone Number must be atleast 10 Characters and Numeric");
        exit();
    }
    else{
        $sql="UPDATE user SET fName='".$fName."', lName='".$lName."', DOB='".$DOB."', CCN='".$CCN."', phoneNum='".$phonenum."', badge='".$badge."', MembershipID='".$membershipID."' WHERE userID='".$_SESSION['user']['userID']."'";
        $result=mysqli_query($connect, $sql);
    
        if($result){
            $_SESSION['user']['MembershipID'] = 1;
            $_SESSION['user']['badge'] = $badge;

            header("Location:homepage.php");
            exit();
        }else{
            header("Location:subscribtion.php?error=Unknown error occurred");
            exit();
        }
    }
}else{
    header("Location:subscribtion.php");
    exit();
}