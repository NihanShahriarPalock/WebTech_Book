<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
     
<style>
  <?php include "style.css" ?>
</style>
<script>
     <?php include "script.js" ?>
</script>

</head>
<body>
   <div class="container">
     <h1>Reports by <?php echo $_GET['id']; ?></h1>
    
    <?php if (!empty($reports)): ?>
        <table border="1">
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?php echo $report['title']; ?></td>
                    <td><?php echo $report['content']; ?></td>
                    <td><?php echo $report['status']; ?></td>
                    <td>
                        <?php if ($report['status'] == 'Pending'): ?>
                            <a href="index.php?action=approve_report&report_id=<?php echo $report['id']; ?>">Approve</a> | 
                            <a href="index.php?action=dismiss_report&report_id=<?php echo $report['id']; ?>">Dismiss</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No reports found for this content writer.</p>
    <?php endif; ?>

    <a href="index.php?action=manage_content_writers">Back to Manage Content Writers</a>
   </div>
</body>
</html>