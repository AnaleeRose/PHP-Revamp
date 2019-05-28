<?php
if (isset($_POST['logoutBtn'])) {
    $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-86400, '/');
        }
    session_destroy();
    header('Location: http://localhost:81/phprevamp/login.php');
    exit;
}



