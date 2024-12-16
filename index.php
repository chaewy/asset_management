<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="login-container">
  <form id="login-form" action="includes/login.inc.php" method="post">
    <?php
      session_start();

      // Check if login information has been submitted
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['email'])) {
            $users_email = trim($_POST['email']);
            $_SESSION['users_email'] = $users_email; 
            echo "Email stored in session: " . htmlspecialchars($_SESSION['users_email']);
        } else {
            echo "Email not set in POST data.";
        }
    }
      // Display any error messages stored in session
      if (isset($_SESSION['error'])) {
        echo "<p class='error-message'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']); // Clear the error message after displaying
      }

      if (isset($_SESSION['success'])) {
        echo "<p class='success-message'>{$_SESSION['success']}</p>";
        unset($_SESSION['success']); // Clear the success message after displaying
      }
    ?>
    
    <div class="header-logo">
      <h1></h1>
    </div>

    <div class="input-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
    </div>

    <div class="input-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="pwd" required>
    </div>

    <button type="submit" name="submit" class="btn">Login</button>
    <!-- if success go to home.php -->
    
    <!-- Sign Up Button -->
    <div class="sign-up">
      <p>Don't have an account? <a href="page/SignUp.php" class="signup-link">Sign Up</a></p>
    </div>

  </form>
</div>

</body>
</html>
