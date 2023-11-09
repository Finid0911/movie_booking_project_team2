<?php 
    session_start();
    if (isset($_SESSION['user_email'])) {
        unset($_SESSION['user_email']);

        // Hoặc đặt thời gian sống của cookie là 0
        setcookie('PHPSESSID', '', 0, '/');
        session_destroy();
    }
    header('Location: login.php');
?>