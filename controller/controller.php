<?php

require_once '../webtech_project/model/model.php';

function handleAction($action) {
    switch ($action) {
        case 'register':
            registerUser();
            break;
        case 'profile':
            profile();
            break;
        case 'login':
            loginUser();
            break;
        case 'changepassword':
            changePassword();
            break;
        case 'editUser':
            editUser();
            break;
        case 'updateUser':
            updateUser();
            break;
        case 'deleteUser':
            deleteUser();
            break;
        case 'logout':
            logout();
            break;
        case 'forgot_password':
            forgotPassword();
            break;
            case 'adminProfileInfo':
             require_once '../webtech_project/view/admin_profile.php';
            break;
        case 'reset_password':
            resetPassword();
            break;
        case 'add_content_writer':
            require_once '../webtech_project/view/add_content_writer.php';
            break;
        case 'manage_content_writers':
            manageContentWriters();
            break;
        case 'add_report':
            addReport();
            break;
             case 'sales_history':
            showSalesHistory();
            break;
        case 'add_content_writer_submit':
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
    
        $message = addContentWriter($username, $password, $email);
        echo $message;
           
    }
    break;
     case 'view_report':
            viewReport();
            break;
        case 'approve_report':
            approveReport();
            break;
        case 'dismiss_report':
            dismissReport();
            break;
            case 'view_reports':
            viewReports();
            break;
            case 'add_delivery_man';
            require_once '../webtech_project/view/add_delivery_man.php';
            break;
             case 'add_delivery_man_submit';
             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];
    
            $message = addDeliveryManWriter($username, $password, $email);
            echo $message;
           
    }
            case 'manage_delivery_man':
    manageDeliveryMan();
    break;
    case 'manage_books':
    manageBooks();
    break;
case 'ban_delivery_man':
    if (isset($_GET['username'])) {
        banDeliveryMan($_GET['username']);
    } else {
        echo "Username is required.";
    }
    break;
case 'manage_content_writers':
    
    if (!isAdmin()) {
        echo "Permission denied.";
        return;
    }

    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    } else {
        $message = "";
    }

    $contentWriters = getContentWriters();
    if ($contentWriters) {
        foreach ($contentWriters as &$contentWriter) {
            $reports = getReportsByContentWriterId($contentWriter['id']);
            $contentWriter['reports'] = $reports;
        }
    }

    require_once '../webtech_project/view/manage_content_writers.php';
    break;
        case 'ban_content_writer':
            if (isset($_GET['username'])) {
                banContentWriter($_GET['username']);
            } else {
                echo "Username is required.";
            }
            break;
             case 'login_content_writer':
            loginContentWriter();
            break;
            case 'search_content_writers':
    if (isset($_GET['searchTerm'])) {
        $searchTerm = $_GET['searchTerm'];
        $contentWriters = searchContentWriters($searchTerm);
        echo json_encode($contentWriters);
    }

     case 'deleteBook':
            if (isset($_GET['id'])) {
                deleteBook($_GET['id']);
            } else {
                echo "Book ID is required.";
            }
            break;
        
        case 'increasePrice':
            if (isset($_GET['id'])) {
                increasePrice($_GET['id']);
            } else {
                echo "Book ID is required.";
            }
            break;
        
        case 'decreasePrice':
            if (isset($_GET['id'])) {
                decreasePrice($_GET['id']);
            } else {
                echo "Book ID is required.";
            }
            break;
    break;
        default:
            showHomePage(); 
            break;
    }
}

function showSalesHistory() {
    $salesHistory = getSalesHistory();
    require_once '../webtech_project/view/sales_history.php';
}

function getTotalSales() {
    $conn = connectToDatabase();
    try {
        $stmt = $conn->query("SELECT SUM(sales_price) AS total_sales FROM sales");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_sales'];
    } catch(PDOException $e) {
        echo "Error retrieving total sales: " . $e->getMessage();
        return false;
    }
}

function loginContentWriter() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            if ($user['role'] == 'content_writer') {
                // Set a session variable to identify the user as a content writer
                $_SESSION['content_writer'] = $username;
                // Redirect to the content writer dashboard
                header('Location: index.php?action=content_writer_dashboard');
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    }

    // Load the login page for content writers
    require_once '../webtech_project/view/login_content_writer.php';
}

function contentWriterDashboard() {
    // Check if the user is logged in as content writer
    if (!isset($_SESSION['content_writer'])) {
        header('Location: index.php?action=login_content_writer');
        exit;
    }

    // Load content writer dashboard
    require_once '../webtech_project/view/content_writer_dashboard.php';
}


function manageBooks() {
    // Check if the current user is an admin
    if (!isAdmin()) {
        echo "Permission denied.";
        return;
    }

    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    } else {
        $message = "";
    }

  

    $books = getAllBooks();

    require_once '../webtech_project/view/manage_books.php';
}


function manageContentWriters() {
    // Check if the current user is an admin
    if (!isAdmin()) {
        echo "Permission denied.";
        return;
    }

    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    } else {
        $message = "";
    }

    // Check if a new content writer was added
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $contentWriter = getUserByUsername($username);
        if ($contentWriter) {
            // Generate dummy reports for the new content writer
            generateDummyReportsForContentWriter($contentWriter['id']);
        }
    }

    // Retrieve all content writers
    $contentWriters = getContentWriters();
    $reports = getAllReports();

    require_once '../webtech_project/view/manage_content_writers.php';
}

function viewReport() {
    if (isset($_GET['report_id'])) {
        $reportId = $_GET['report_id'];
        $report = getReportById($reportId);
        // Load view for viewing report
        require_once '../webtech_project/view/view_report.php';
    } else {
        echo "Report ID is required.";
    }
}

function approveReport() {
    if (isset($_GET['report_id'])) {
        $reportId = $_GET['report_id'];
        if (approveReportById($reportId)) {
            echo "Report approved successfully.";
        } else {
            echo "Error approving report.";
        }
    } else {
        echo "Report ID is required.";
    }
}

function dismissReport() {
    if (isset($_GET['report_id'])) {
        $reportId = $_GET['report_id'];
        if (dismissReportById($reportId)) {
            echo "Report dismissed successfully.";
        } else {
            echo "Error dismissing report.";
        }
    } else {
        echo "Report ID is required.";
    }
}

function addReport() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];

        if (createReport($title, $content)) {
            echo "Report created successfully.";
        } else {
            echo "Error creating report.";
        }
    }
}

function isAdmin() {
    // Check if the user is an admin
    if (isset($_COOKIE['username'])) {
        $username = $_COOKIE['username'];
        $user = getUserByUsername($username);
        return ($user && $user['role'] == 'admin');
    }
    return false;
}

function forgotPassword() {
    $email = $_POST['email'];
    $user = getUserByEmail($email);
    
    if ($user) {
        $token = bin2hex(random_bytes(20));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        updateUserResetToken($email, $token, $expires);
        // Send email with reset link
        echo "An email with password reset instructions has been sent to $email.";
    } else {
        echo "No user found with that email address.";
    }
}

function resetPassword() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $token = $_POST['token'];
        $password = $_POST['password'];
        
        // Check if token is valid and not expired
        $user = getUserByToken($token);
        if ($user) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            updateUserPassword($user['email'], $hashed_password);
            // Clear reset token and expiration
            updateUserResetToken($user['email'], null, null);
            echo "Password reset successfully.";
        } else {
            echo "Invalid or expired token.";
        }
    }
}

function showForgotPasswordForm() {
    require_once '../webtech_project/view/forgot_password.php';
}


function showHomePage() {
    if (isset($_COOKIE['username'])) {
        header('Location: index.php?action=profile');
        exit;
    } else {
        require_once '../webtech_project/view/home.php';
    }
}



function registerUser() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $role = $_POST['role'];
        
        if (getUserByUsername($username)) {
            $error = "Username already exists.";
        } else {
            register($username, $password, $email, $role);
            setcookie('username', $username, time() + (86400 * 30), "/");
            header('Location: index.php?action=profile');
            exit;
        }
    }

    require_once '../webtech_project/view/register.php';
}

function profile() {
    if (!isset($_COOKIE['username'])) {
        header('Location: index.php?action=login');
        exit;
    }

    $username = $_COOKIE['username'];
    $user = getUserByUsername($username);
    if (!$user) {
        echo "User not found.";
        return;
    }

    // Check if the 'role' key exists in the $user array
    if (!isset($user['role'])) {
        echo "Role information not available.";
        return;
    }

    $isAdmin = ($user['role'] == 'admin');

    // Get all users if the current user is an admin
    $allUsers = [];
    if ($isAdmin) {
        $allUsers = getAllUsers();
    }

    require_once '../webtech_project/view/profile.php';
}

function editUser() {
    if (!isset($_COOKIE['username'])) {
        header('Location: index.php?action=login');
        exit;
    }

    $loggedInUsername = $_COOKIE['username'];
    $loggedInUser = getUserByUsername($loggedInUsername);
    if (!$loggedInUser) {
        echo "User not found.";
        return;
    }



    $username = $_GET['username'];
    $user = getUserByUsername($username);
    if (!$user) {
        echo "User not found.";
        return;
    }

    // Remove the password from the $user array before passing it to the view
    unset($user['password']);

    require_once '../webtech_project/view/edit_user.php';
}

function updateUser() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        updateUserByUsername($username, ['email' => $email, 'role' => $role]);

        header('Location: index.php?action=profile');
        exit;
    }
}

function deleteUser() {
    if (!isset($_COOKIE['username'])) {
        header('Location: index.php?action=login');
        exit;
    }

    $loggedInUser = getUserByUsername($_COOKIE['username']);
    if (!$loggedInUser) {
        echo "User not found.";
        return;
    }

    if ($loggedInUser['role'] !== 'admin') {
        echo "Permission denied.";
        return;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $username = $_GET['username'];
        deleteUserByUsername($username);
        header('Location: index.php?action=profile');
        exit;
    }
}

function changePassword() {
    if (!isset($_COOKIE['username'])) {
        header('Location: index.php?action=login');
        exit;
    }

    $username = $_COOKIE['username'];
    $user = getUserByUsername($username);
    if (!$user) {
        echo "User not found.";
        return;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword !== $confirmPassword) {
            $error = "Passwords do not match.";
        } elseif (strlen($newPassword) < 6) {
            $error = "Password must be at least 6 characters long.";
        } else {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            updateUser($username, ['password' => $hashedPassword]);
            header('Location: index.php?action=profile');
            exit;
        }
    }

    require_once '../webtech_project/view/change_password.php';
}

function loginUser() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = getUserByUsername($username);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Check if logging in as a content writer
                if (isset($_POST['login_content_writer'])) {
                    if (isContentWriter($username)) {
                        // Set content writer cookie or session
                        setcookie('content_writer', $username, time() + (86400 * 30), "/");
                        header('Location: index.php?action=manage_content_writers');
                        exit;
                    } else {
                        $error = "You are not authorized to login as a content writer.";
                    }
                } else {
                    // Set user cookie or session
                    setcookie('username', $username, time() + (86400 * 30), "/");
                    header('Location: index.php?action=profile');
                    exit;
                }
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
    }

    require_once '../webtech_project/view/login.php';
}

function isContentWriter($username) {
    $user = getUserByUsername($username);
    return ($user && $user['role'] == 'content_writer');
}




function viewReports() {
    if (isset($_GET['id'])) {
        $username = $_GET['id'];
        $contentWriter = getContentWriterById($username);
        if ($contentWriter) {
            $reports = getReportsByContentWriterId($contentWriter['id']);
            require_once '../webtech_project/view/view_reports.php';
        } else {
            echo "Content writer not found.";
        }
    } else {
        echo "Username is required.";
    }
}




function logout() {
    setcookie('username', '', time() - 3600, "/");
    header('Location: index.php?action=login');
    exit;
}



?>