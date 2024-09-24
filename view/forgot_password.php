<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
    
<style>
  <?php include "login.css" ?>
</style>
<script>
     <?php include "script.js" ?>
</script>

    
</head>
<body>
  <div class="container">
      <h2>Forgot Password</h2>
    <form action="index.php?action=forgot_password" method="post" onsubmit="return validateForgotPassword()">
        <label for="email">Enter your email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <span id="email_error" style="color: red;"></span>
        <input type="submit" value="Submit">
    </form>
  </div>
</body>
</html>