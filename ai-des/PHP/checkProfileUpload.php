<?php 
// Include the database configuration file  
session_start();

$host="localhost";
$user="root";
$password="";
$dbName="shout_db";

$connect = mysqli_connect($host, $user, $password);
mysqli_select_db($connect, $dbName);
 
// If file upload form is submitted 
$status = $statusMsg = '';
if(isset($_POST["submit"])){ 

    $password = md5($_POST['oldPass']);

    if($_SESSION['user']['password']!=$password){
        header("Location:customizeProfile.php?error=Old Password doesn't match!");
        exit();
    }

    if(!empty($_POST['username'])){
        $username = $_POST['username'];
        $sql = "UPDATE user SET username = '".$username."' WHERE userID = '".$_SESSION['user']['userID']."'";
        $result = mysqli_query($connect, $sql);

        if(!$result){
            header("Location:customizeProfile.php?error=Unable to update username");
            exit();
        }
    }

    if(!empty($_POST['newPass'])){
        if(!empty($_POST['confPass'])){
            if($_POST['confPass']==$_POST['newPass']){
                $password = md5($_POST['newPass']);
                $sql1 = "UPDATE user SET password = '".$password."' WHERE userID = '".$_SESSION['user']['userID']."'";
                $result1 = mysqli_query($connect, $sql1);
        
                if(!$result1){
                    header("Location:customizeProfile.php?error=Unable to update password");
                    exit();
                }                
            }else{
                header("Location:customizeProfile.php?error=New Password and Confirmation Password don't match");
                exit();
            }
        }else{
            header("Location:customizeProfile.php?error=Confirmation password is empty");
            exit();
        }
    }

    if(!empty($_POST['fName'])){
        $fName = $_POST['fName'];
        $sql2 = "UPDATE user SET fName = '".$fName."' WHERE userID = '".$_SESSION['user']['userID']."'";
        $result2 = mysqli_query($connect, $sql2);

        if(!$result2){
            header("Location:customizeProfile.php?error=Unable to update first name");
            exit();
        }
    }

    if(!empty($_POST['lName'])){
        $lName = $_POST['lName'];
        $sql3 = "UPDATE user SET lName = '".$lName."' WHERE userID = '".$_SESSION['user']['userID']."'";
        $result3 = mysqli_query($connect, $sql3);

        if(!$result3){
            header("Location:customizeProfile.php?error=Unable to update first name");
            exit();
        }
    }

    if(!empty($_POST['phonenum'])){
        $phoneNum = $_POST['phonenum'];
        if(strlen($phoneNum) < 10 || is_numeric($phoneNum)==false){
            header("Location:customizeProfile.php?error=Phone Number must be atleast 10 Characters and Numeric");
            exit();
        }else{
            $sql4 = "UPDATE user SET phoneNum = '".$phoneNum."' WHERE userID = '".$_SESSION['user']['userID']."'";
            $result4 = mysqli_query($connect, $sql4);
    
            if(!$result4){
                header("Location:customizeProfile.php?error=Unable to update first name");
                exit();
            }
        }
    }
    
    if(!empty($_POST['badge'])){
        $badge = $_POST['badge'];
        $sql5 = "UPDATE user SET badge = '".$badge."' WHERE userID = '".$_SESSION['user']['userID']."'";
        $result5 = mysqli_query($connect, $sql5);

        if(!$result5){
            header("Location:customizeProfile.php?error=Unable to update badge");
            exit();
        }

        $_SESSION['user']['badge'] = $badge;
    }    

    $status = 'error'; 
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
         
            // Insert image content into database 
            $sql2 = "UPDATE user SET profilePict = '".$imgContent."' WHERE userID = '".$_SESSION['user']['userID']."'";
            $result2 = mysqli_query($connect, $sql2);

            if($result2){ 
                $status = 'success'; 
                $statusMsg = "File uploaded successfully.";
                header("Location:customizeProfile.php");
                exit();
            }else{ 
                $statusMsg = "File upload failed, please try again.";
                header("Location:customizeProfile.php?error=File upload failed, please try again");
                exit();
            }  
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
            header("Location:customizeProfile.php?error=Only JPG, JPEG, PNG, & GIF files are allowed to upload");
            exit();
        } 
    }
    header("Location:customizeProfile.php?message=Successfully Updated");
    exit();    
} 
 
// Display status message 
echo $statusMsg; 
?>