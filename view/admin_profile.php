<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     
<style>
  <?php include "style.css" ?>
</style>
<script>
     <?php include "script.js" ?>
</script>

</head>
<body>
    <div class="container">
          <h3>Profile Information</h3>
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            
            <th>Action</th>
            
        </tr>
        <?php if ($isAdmin): ?>
            <?php foreach ($allUsers as $user): ?>
            <tr>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <a href="index.php?action=editUser&username=<?php echo $user['username']; ?>">Edit</a>
                    <a href="index.php?action=deleteUser&username=<?php echo $user['username']; ?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <?php if ($user['role'] !== 'admin'): ?>
            <tr>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <a href="index.php?action=editUser&username=<?php echo $user['username']; ?>">Edit</a>
                    <a href="index.php?action=changepassword">Change Password</a>
                </td>
            </tr>
            <?php endif; ?>
        <?php endif; ?>
    </table>
    </div>

</body>
</html>