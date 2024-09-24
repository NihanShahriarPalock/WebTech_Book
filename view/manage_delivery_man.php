<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Delivery Men</title>
    
<style>
  <?php include "style.css" ?>
</style>
<script>
     <?php include "script.js" ?>
</script>

</head>
<body>
   <div class="container">
     <div class="container">
        <h1>Manage Delivery Men</h1>
    <a href="index.php?action=add_delivery_man">Add Delivery Man</a>

    
    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?php echo $_GET['message']; ?></p>
    <?php endif; ?>
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($deliveryMen as $deliveryMan): ?>
            <tr>
                <td><?php echo $deliveryMan['username']; ?></td>
                <td><?php echo $deliveryMan['email']; ?></td>
                <td>
                    <a href="index.php?action=ban_delivery_man&username=<?php echo $deliveryMan['username']; ?>">Ban</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="index.php?action=profile">Back to Home</a>
    </div>
   </div>
</body>
</html>