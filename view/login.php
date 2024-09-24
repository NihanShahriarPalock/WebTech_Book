<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    
<style>
  <?php include "login.css" ?>
</style>
<script>
     <?php include "script.js" ?>
</script>

</head>
<body>
  <div class="container">
     <h2> Admin Login</h2>
    <form method="post" action="" onsubmit="return validateLoginForm()">
        <ul>
            <li>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <span id="username_error" class="error-message"></span> 
            <li>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span id="password_error" class="error-message"></span> 
            </li>
        

            <li>
                <button type="submit">Login</button>
            </li>
        </ul>
        <div class="login-links">
            <h3>Don't have an account? <a href="index.php?action=register">Register</a></h3> 
         
        </div>
    </form>
        <?php if (isset($error)) { ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php } ?>
  </div>
</body>
</html>
