<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Content Writers</title>
      
<style>
  <?php include "style.css" ?>
</style>
<script>
     <?php include "script.js" ?>
</script>

         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
   <div class="container">
     <h1>Manage Content Writers</h1>
<a href="index.php?action=add_content_writer">Add Content Writer</a>

    
    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?php echo $_GET['message']; ?></p>
    <?php endif; ?>


    <h2>Current Content Writers</h2>
     
    <form id="searchForm">
        <label for="searchTerm">Search Username:</label>
        <input type="text" id="searchTerm" name="searchTerm">
        <button type="button" onclick="search()">Search</button>
    </form>
    <?php if (!empty($contentWriters)): ?>
    <table border="1" id="contentWritersTable">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($contentWriters as $writer): ?>
            <tr>
            <td><?php echo $writer['username']; ?></td>
            <td><?php echo $writer['email']; ?></td>
            <td><a href="index.php?action=manage_content_writers&action=ban_content_writer&username=<?php echo $writer['username']; ?>">Ban</a></td>
            <td><a href="index.php?action=view_reports&id=<?php echo $writer['id']; ?>">View Reports</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No content writers found.</p>
<?php endif; ?>

<a href="index.php?action=profile">Go to Profile</a>
   </div>

<script>
    function search() {
        var searchTerm = document.getElementById("searchTerm").value.toLowerCase();

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var filteredData = JSON.parse(xhr.responseText);
                    updateTable(filteredData);
                } else {
                    console.error('Error:', xhr.statusText);
                }
            }
        };
        xhr.open("GET", "index.php?action=search_content_writers&searchTerm=" + searchTerm, true);
        xhr.send();
    }

    function updateTable(filteredData) {
        var rows = document.getElementById("contentWritersTable").rows;
        for (var i = 1; i < rows.length; i++) {
            var username = rows[i].cells[0].textContent.toLowerCase();
            var email = rows[i].cells[1].textContent.toLowerCase();
            var isVisible = filteredData.some(function(item) {
                return item.username.toLowerCase().includes(username) || item.email.toLowerCase().includes(email);
            });
            rows[i].style.display = isVisible ? "" : "none";
        }
    }
</script>

</body>
</html> -->
