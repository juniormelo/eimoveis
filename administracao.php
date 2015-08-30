<?php    
    if (!isset($_GET)) {
        include_once 'app/view/backend/login.php'; 
    } else {
        if ($_GET['action'] == 'sair') {
            session_start();
            session_destroy();
            header("Location: index.php");
        } else {
            include_once 'app/view/backend/login.php'; 
        }    
    }
    
?>