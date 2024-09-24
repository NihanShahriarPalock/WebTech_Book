<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta http-equiv="Cache-control" content="no-cache">
  
<style>
  <?php include "register.css" ?>
</style>
<script>
     <?php include "script.js" ?>
</script>

</head>
<body>
  <div class="form-container">
      <h2>Register</h2>
    <form method="post" action="" onsubmit="return validateForm()">
        <ul>
            <li> 
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <div id="username_error" style="color: red;"></div>
            </li>
            <li>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <div id="password_error" style="color: red;"></div>
            </li>
            <li>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <div id="confirm_password_error" style="color: red;"></div>
            </li>
            <li>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <div id="email_error" style="color: red;"></div>
            </li>
            <li>
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="admin">Admin</option>
                    <!-- <option value="content_writer">Content Writer</option> -->
                    <option value="user">User</option>
                    <option value="delivery_man">Delivery Man</option>
                </select>
            </li>
            <li>
                <button type="submit">Register</button>
            </li>
        </ul>
        <?php if (isset($error)) { ?>
            <div><span><?php echo $error; ?></span></div>
        <?php } ?>
    </form>
    <h2>Already have an account?</h2><a href="index.php?action=login">Login Here</a>
  </div>
</body>
</html>