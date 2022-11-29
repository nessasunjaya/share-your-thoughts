<?php

$host="localhost";
$user="root";
$password="";
$db="shout_db";

$connect = mysqli_connect($host, $user, $password);
mysqli_select_db($connect, $db);

if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confpassword'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username = validate($_POST['username']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $confpassword = validate($_POST['confpassword']);

    $user_data = 'username='. $username. '&email='. $email;
    // echo $user_data;

    if($password !== $confpassword){
        header("Location:register.php?error=Password and Confirm Password does not match&$user_data");
        exit();
    }else{
        // hashing password
        $password = md5($password);

        $sql="SELECT * FROM user WHERE email='".$email."' ";
        $result=mysqli_query($connect, $sql);

        $sql1="SELECT * FROM user WHERE username='".$username."' ";
        $result1=mysqli_query($connect, $sql1);

        if(mysqli_num_rows($result) > 0){
            header("Location:register.php?error=Email is used or taken by another user&$user_data");
            exit();
        }
        if(mysqli_num_rows($result1) > 0){
            header("Location:register.php?error=Username is used or taken by another user&$user_data");
            exit();
        }
        else{
            $image = 'C:\xampp\tmp\phpB373.tmpFile'; 
            $imgContent = addslashes(file_get_contents($image)); 
         
            // Insert image content into database 
            $sql2 = "INSERT INTO user(username, email, password, profilePict) VALUES('".$username."', '".$email."', '".$password."', '".$imgContent."')";
            $result2=mysqli_query($connect, $sql2);
            if($result2){
                header("Location:register.php");
                exit();
            }else{
                header("Location:register.php?error=Unknown error occurred&$user_data");
                exit();
            }
        }

    }
}else{
    header("Location:register.php");
    exit();
}