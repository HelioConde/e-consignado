<?php
session_start();
    $log = $_GET['script'];
    $_SESSION['script'] = $_GET['script'];
    
    echo "<script>window.location = 'mega.php';</script>";
?>