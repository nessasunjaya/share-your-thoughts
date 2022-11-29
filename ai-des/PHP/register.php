<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="../CSS/register.css">
  <link rel="icon" href="../asset/Logo-Dark.png">
</head>
<body>
  <form action="registerValidation.php" method="POST" class="regis-page">
    <div class="regis-card">
      <input class="top" type="text" placeholder="Username" name="username" required>
      <input type="text" placeholder="Email" name="email" required>
      <input type="password" placeholder="Password" name="password" required>
      <input type="password" placeholder="Confirm Password" name="confpassword" required>
      <?php 
      if(isset($_GET['error'])){
      ?>
        <div class="error-message">
          <?php echo $_GET['error']; ?>
        </div>
      <?php 
      }
      ?>      
      <button type="submit" class="submit-btn">REGISTER</button>
      <a href="login.php">
        <div id="goto-login">
          <h2 id="txt1">Or</h2>
          <h2 id="txt2">Login</h2>
        </div>        
      </a>
    </div>
    <img id="logo" src="../asset/Logo-White.png" alt="">
  </form>
</body>
</html>