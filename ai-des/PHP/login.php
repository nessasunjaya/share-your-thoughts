<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../CSS/login.css">
  <link rel="icon" href="../asset/Logo-Dark.png">
</head>

<body>
  <form action="loginValidation.php" method="POST" class="login-page">
    <img id="logo" src="../asset/Logo-White.png" alt="Logo">
    <div class="login-card">
      <input type="text" placeholder="Email" name="email" required>
      <input type="password" placeholder="Password" name="password" required>
      <br>
      <?php 
      if(isset($_GET['error'])){
      ?>
        <div class="error-message">
          <?php echo $_GET['error']; ?>
        </div>
      <?php 
      }
      ?>
      <button type="submit" class="submit-btn">LOG IN</button>
      <a href="register.php">
        <div id="goto-regis">
          <h2 id="txt1">Or</h2>
          <h2 id="txt2">Register</h2>
        </div>
      </a>
    </div>
  </form>

</body>

</html>