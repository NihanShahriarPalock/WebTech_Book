<?php

function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "htmlval";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function createSalesTable() {
    $conn = connectToDatabase();
    try {
        $sql = "CREATE TABLE IF NOT EXISTS sales (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            book_name VARCHAR(100) NOT NULL,
            sales_price DECIMAL(10, 2) NOT NULL,
            status VARCHAR(50) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
    } catch(PDOException $e) {
        echo "Error creating 'sales' table: " . $e->getMessage();
    }
}

function addDummySales() {
    $conn = connectToDatabase();
    try {
        // Check the current number of rows in the 'sales' table
        $stmt = $conn->query("SELECT COUNT(*) FROM sales");
        $count = $stmt->fetchColumn();
        
        // Insert dummy data only if there are fewer than 10 rows
        if ($count < 10) {
            $stmt = $conn->prepare("INSERT INTO sales (book_name, sales_price, status) VALUES (:book_name, :sales_price, :status)");
            $dummySales = array(
                array("Dummy Book 1", 20.00, "Delivered"),
                array("Dummy Book 2", 25.00, "Pending"),
                array("Dummy Book 3", 18.00, "Processing"),
                array("Dummy Book 4", 30.00, "Delivered"),
                array("Dummy Book 5", 22.00, "Pending"),              
                array("Dummy Book 6", 27.00, "Delivered")
            );

           
            foreach ($dummySales as $sale) {
                if ($count >= 10) {
                    break; 
                }
                $stmt->bindParam(':book_name', $sale[0]);
                $stmt->bindParam(':sales_price', $sale[1]);
                $stmt->bindParam(':status', $sale[2]);
                $stmt->execute();
                $count++; // Increment the count after each insert
            }
        } else {
            echo "";
        }
    } catch(PDOException $e) {
        echo "Error adding dummy sales: " . $e->getMessage();
    }
}

// Create the sales table
createSalesTable();

// Add dummy sales
addDummySales();

function getSalesHistory() {
    $conn = connectToDatabase();
    try {
        $stmt = $conn->query("SELECT * FROM sales ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error retrieving sales history: " . $e->getMessage();
        return false;
    }
}

function getAllBooks() {
    $conn = connectToDatabase();
     try {
        $stmt = $conn->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error retrieving users: " . $e->getMessage();
        return false;
    }
}




function getUserByToken($token) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function createUsersTable() {
    $conn = connectToDatabase();
    try {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(50),
            role VARCHAR(20),
            reset_token VARCHAR(255),  
            reset_token_expires DATETIME,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
    } catch(PDOException $e) {
        echo "Error creating 'users' table: " . $e->getMessage();
    }
}

createUsersTable();

function createBooksTable() {
    $conn = connectToDatabase();
    try {
        $sql = "CREATE TABLE IF NOT EXISTS books (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            author VARCHAR(100) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            link VARCHAR(255) NOT NULL
        )";
        $conn->exec($sql);
    } catch(PDOException $e) {
        echo "Error creating 'books' table: " . $e->getMessage();
    }
}
function addDummyBooks() {
    $conn = connectToDatabase();
    try {
        // Check if there are already books in the table
        $stmt = $conn->query("SELECT COUNT(*) FROM books");
        $rowCount = $stmt->fetchColumn();
        
        // If there are no books, add dummy books
        if ($rowCount == 0) {
            $stmt = $conn->prepare("INSERT INTO books (name, author, price, link) VALUES (:name, :author, :price, :link)");
            $dummyBooks = array(
                array("Book 1", "Author 1", 20.00, "https://example.com/book1"),
                array("Book 2", "Author 2", 25.00, "https://example.com/book2"),
                array("Book 3", "Author 3", 18.00, "https://example.com/book3"),
                array("Book 4", "Author 4", 30.00, "https://example.com/book4"),
                array("Book 5", "Author 5", 22.00, "https://example.com/book5")
            );
            foreach ($dummyBooks as $book) {
                $stmt->bindParam(':name', $book[0]);
                $stmt->bindParam(':author', $book[1]);
                $stmt->bindParam(':price', $book[2]);
                $stmt->bindParam(':link', $book[3]);
                $stmt->execute();
            }
            echo "";
        } else {
            echo "";
        }
    } catch(PDOException $e) {
        echo "Error adding dummy books: " . $e->getMessage();
    }
}
createBooksTable();
addDummyBooks();


function register($username, $password, $email, $role) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
}

function getUserByUsername($username) {
    $conn = connectToDatabase();

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}


function deleteUserByUsername($username) {
    $conn = connectToDatabase();

    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return true;
    } catch(PDOException $e) {
        echo "Error deleting user: " . $e->getMessage();
        return false;
    }
}

function updateUserByUsername($username, $newData) {
    $conn = connectToDatabase();

    try {
        $stmt = $conn->prepare("UPDATE users SET email = :email, role = :role WHERE username = :username");
        $stmt->bindParam(':email', $newData['email']);
        $stmt->bindParam(':role', $newData['role']);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return true;
    } catch(PDOException $e) {
        echo "Error updating user: " . $e->getMessage();
        return false;
    }
}

function getAllUsers() {
    $conn = connectToDatabase();

    try {
        $stmt = $conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "Error retrieving users: " . $e->getMessage();
        return false;
    }
}



function getUserByEmail($email) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function updateUserResetToken($email, $token, $expires) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("UPDATE users SET reset_token = :token, reset_token_expires = :expires WHERE email = :email");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':expires', $expires);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
}

function updateUserPassword($email, $newPassword) {
    $conn = connectToDatabase();
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = :password, reset_token = NULL, reset_token_expires = NULL WHERE email = :email");
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
}



function createDeliveryManTable() {
    $conn = connectToDatabase();
    try {
        $sql = "CREATE TABLE IF NOT EXISTS delivery_mans (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(50),
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
    } catch(PDOException $e) {
        echo "Error creating 'delivery_mans' table: " . $e->getMessage();
    }
}

createDeliveryManTable();

function addDeliveryManWriter($username, $password, $email) {
    $conn = connectToDatabase();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO delivery_mans (username, password, email) VALUES (:username, :password, :email)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        echo "DEBUG: Inserted deliveryMan. Username: $username, Email: $email";

        header("Location: index.php?action=manage_delivery_man&message=Delivery Man added successfully.");
        exit;

    } catch(PDOException $e) {
        return "Error adding delivery Man: " . $e->getMessage();
    }
}



function manageDeliveryMan() {

    if (!isAdmin()) {
        echo "Permission denied.";
        return;
    }

    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    } else {
        $message = "";
    }

    $deliveryMen = getDeliveryMen();

    require_once '../webtech_project/view/manage_delivery_man.php';
}

function getDeliveryMen() {
    $conn = connectToDatabase();
    try {
        $stmt = $conn->prepare("SELECT * FROM delivery_mans");
        $stmt->execute();
        $deliveryMen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $deliveryMen;
    } catch(PDOException $e) {
        echo "Error fetching delivery men: " . $e->getMessage();
        return [];
    }
}

function banDeliveryMan($username) {
    $conn = connectToDatabase();
    try {
        $stmt = $conn->prepare("DELETE FROM delivery_mans WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        header("Location: index.php?action=manage_delivery_man&message=Delivery Man banned successfully.");
        exit;
    } catch(PDOException $e) {
        echo "Error banning delivery man: " . $e->getMessage();
    }
}

function deleteBook($id) {
    $conn = connectToDatabase();
    try {
        $stmt = $conn->prepare("DELETE FROM books WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "Book deleted successfully.";
    } catch(PDOException $e) {
        echo "Error deleting book: " . $e->getMessage();
    }
}

function increasePrice($id) {
    $conn = connectToDatabase();
    try {
        $stmt = $conn->prepare("UPDATE books SET price = price + 1 WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "Price increased successfully.";
    } catch(PDOException $e) {
        echo "Error increasing price: " . $e->getMessage();
    }
}

function decreasePrice($id) {
    $conn = connectToDatabase();
    try {
        $stmt = $conn->prepare("UPDATE books SET price = price - 1 WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "Price decrease successfully.";
    } catch(PDOException $e) {
        echo "Error decrease price: " . $e->getMessage();
    }
}



?>