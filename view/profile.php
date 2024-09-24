<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <meta http-equiv="Cache-control" content="no-cache">


<style>
  <?php include "style.css" ?>
</style>
<script>
     <?php include "script.js" ?>
</script>



</head>
<body>
    <div class="menu">
            <?php if ($isAdmin): ?>
            <div class="admin-options">
                <a href="index.php?action=changepassword" class="change-pass-link">Change Password</a>
                <a href="index.php?action=manage_delivery_man" class="manage-delivery-link">Manage Delivery Man</a>
                <a href="index.php?action=manage_books" class="manage-books-link">Manage Books</a>
                <!-- <a href="index.php?action=manage_content_writers" class="manage-content-writers-link">Manage Content Writer</a> -->
                <a href="index.php?action=sales_history" class="sales-history-link">Sales History</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="container">
        <h2 class="welcome">Welcome, <?php echo $user['username']; ?>!</h2>

        <h3 class="section-title">Dashboard</h3>
        <div class="dashboard">
            <table class="dashboard-table">
                <tr>
                    <th>Total Books</th>
                    <th>Total Content Writers</th>
                    <th>Total Delivery Men</th>
                    <th>Sales</th>
                </tr>
                <tr>
                    <td><?php echo getTotalBooks(); ?></td>
                    <td><?php echo getTotalContentWriters(); ?></td>
                    <td><?php echo getTotalDeliveryMen(); ?></td>
                    <td><?php echo getTotalSales(); ?></td>
                </tr>
            </table>
        </div>

        <h3 class="section-title">Profile Information</h3>
        <table class="profile-table">
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
                            <a href="index.php?action=editUser&username=<?php echo $user['username']; ?>" class="edit-link">Edit</a>
                            <a href="index.php?action=deleteUser&username=<?php echo $user['username']; ?>" class="delete-link">Delete</a>
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
                            <a href="index.php?action=editUser&username=<?php echo $user['username']; ?>" class="edit-link">Edit</a>
                            <a href="index.php?action=changepassword" class="change-pass-link">Change Password</a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
        </table>

    

        <a href="index.php?action=logout" class="logout-link">Logout</a>
    </div>
</body>
</html>
