<?php

namespace Sentiment;

include('../../Analyzer.php');

Use Sentiment\Analyzer;
$analyzer = new Analyzer();

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

if(!empty($_POST['message'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $message = validate($_POST['message']);
    $userID = $_SESSION['user']['userID'];

    $output_text = $analyzer->getSentiment($message);

    if($output_text['compound'] < 0){
        header("Location:createPost.php?error=Please type a positive message!");
        exit();
    }

    if(empty($_POST['anonym'])){
        $sql2 = "INSERT INTO post(userID, postContent, date, anonymous) VALUES('".$userID."', '".$message."', '".date('Y-m-d.')."', 0)";
        $result2=mysqli_query($connect, $sql2);
        if($result2){
            header("Location:homepage.php");
            exit();
        }else{
            header("Location:createPost.php?error=Unknown error occurred");
            exit();
        }        
    }else{
        $sql3 = "INSERT INTO post(userID, postContent, date, anonymous) VALUES('".$userID."', '".$message."', '".date('Y-m-d.')."', 1)";
        $result3=mysqli_query($connect, $sql3);
        if($result3){
            header("Location:homepage.php");
            exit();
        }else{
            header("Location:createPost.php?error=Unknown error occurred");
            exit();
        }   
    }
}else{
    header("Location:createPost.php?error=Field is empty!");
    exit();
}