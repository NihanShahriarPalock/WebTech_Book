<!DOCTYPE html>
<html>
<head>
    <title>Manage Books</title>
    <meta http-equiv="Cache-control" content="no-cache">
   
<style>
  <?php include "manage_books.css" ?>
</style>
<script>
     <?php include "script.js" ?>
</script>

    <script>
       function deleteBook(id) {
    if (confirm("Are you sure you want to delete this book?")) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    location.reload(); 
                } else {
                    console.error('Error:', xhr.statusText);
                }
            }
        };
        xhr.open("GET", "index.php?action=deleteBook&id=" + id, true);
        xhr.send();
    }
}

function increasePrice(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                location.reload(); 
            } else {
                console.error('Error:', xhr.statusText);
            }
        }
    };
    xhr.open("GET", "index.php?action=increasePrice&id=" + id, true);
    xhr.send();
}

function decreasePrice(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                location.reload(); 
            } else {
                console.error('Error:', xhr.statusText);
            }
        }
    };
    xhr.open("GET", "index.php?action=decreasePrice&id=" + id, true);
    xhr.send();
}
    </script>
</head>
<body>
   <div class="container">
     <h2>Manage Books</h2>
    
    <?php if (!empty($books)): ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Author</th>
                <th>Price</th>
                <th>Link</th>
                <th>Action</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?php echo $book['name']; ?></td>
                    <td><?php echo $book['author']; ?></td>
                    <td><?php echo $book['price']; ?></td>
                    <td><?php echo $book['link']; ?></td>
                    <td class="action-buttons">
                        <button onclick="deleteBook(<?php echo $book['id']; ?>)">Delete</button>
                        <button onclick="increasePrice(<?php echo $book['id']; ?>)">Increase Price</button>
                        <button onclick="decreasePrice(<?php echo $book['id']; ?>)">Decrease Price</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p class="no-books">No books found</p>
    <?php endif; ?>

    <a href="index.php?action=profile" class="profile-link">Go to Profile</a>
   </div>
</body>
</html>
