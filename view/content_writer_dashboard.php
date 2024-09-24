<!DOCTYPE html>
<html>
<head>
    <title>Content Writer Dashboard</title>
       
<style>
  <?php include "style.css" ?>
</style>
<script>
     <?php include "script.js" ?>
</script>

    <meta http-equiv="Cache-control" content="no-cache">
</head>
<body>
  <div class="container">
      <h2>Welcome, Content Writer!</h2>
    <p>This is your dashboard. You can perform various tasks here.</p>
    <ul>
        <li><a href="index.php?action=write_article">Write New Article</a></li>
        <li><a href="index.php?action=view_articles">View Your Articles</a></li>
        <li><a href="index.php?action=logout_content_writer">Logout</a></li>
    </ul>
  </div>
</body>
</html>
