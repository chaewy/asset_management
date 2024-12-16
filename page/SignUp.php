
<?php
if (isset($_GET['error'])) {
    echo '<div class="error">' . htmlspecialchars($_GET['error']) . '</div>';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="../css/signUp.css">
</head>
<body>

<form id="signup-form" action="../includes/signup.inc.php" method="post">
    <div class="col-4 text-center">
        <a class="blog-header-logo text-body-emphasis text-decoration-none"><h1></h1></a>
    </div>

    <!-- <label for="username">Username:</label>
    <input type="text" id="username" name="uid" required> -->

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="pwd" required>

    <label for="password">Repeat Password:</label>
    <input type="password" id="password" name="pwdrepeat" required>

    <button type="submit" name="submit">Sign Up</button>
    <div id="login">
        <p>Already have an account?</p>
        <p><a href="../index.php">Login here</a></p>
    </div>
</form>




  <!-- <script>
    function validateForm() {
      var username = document.getElementById('username').value;
      var email = document.getElementById('email').value;
      var password = document.getElementById('password').value;

      // Simple validation, you can add more checks as needed
      if (!username || !email || !password) {
        document.getElementById('error-message').innerText = 'All fields are required.';
      } else {
        document.getElementById('error-message').innerText = '';

        // If all fields are filled, you can proceed with further actions, e.g., sending data to the server.
        // For a real-world scenario, you would perform server-side validation and store user data securely.
        // Example: sendUserDataToServer(username, email, password);
      }
    }
  </script> -->

</body>
</html>