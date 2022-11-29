<?php

session_start();

$host="localhost";
$user="root";
$password="";
$db="shout_db";

$connect = mysqli_connect($host, $user, $password);
mysqli_select_db($connect, $db);

if(isset($_POST['email']) && isset($_POST['password'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    $password = md5($password);
  
        $sql="SELECT * FROM user WHERE email='".$email."' AND password='".$password."' limit 1";
        $result=mysqli_query($connect, $sql);
        
        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_assoc($result);
            if ($row['email'] == $email && $row['password'] == $password) {
                $_SESSION['user'] = array();
                $_SESSION['user']['userID'] = $row['userID'];
                $_SESSION['user']['password'] = $row['password'];
                $_SESSION['user']['email'] = $row['email'];
                $_SESSION['user']['username'] = $row['username'];
                $_SESSION['user']['profilePict'] = $row['profilePict'];
                $_SESSION['user']['MembershipID'] = $row['MembershipID'];
                $_SESSION['user']['badge'] = $row['badge'];
                echo($row['userID'].$row['email'].$row['username']);
                header("Location:homepage.php");
                exit();
            }else{
                header("Location:login.php?error=Email or Password is Wrong");
                echo($row['userID'].$row['email'].$row['username']);
                exit();
            }
        }else{
            header("Location:login.php?error=Email or Password is Wrong");
            exit();
        }
}else{
    header("Location:login.php");
    exit();
}

?>