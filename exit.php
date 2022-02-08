<?php
// session_start inicia a sessão
session_start();
require_once('config.php');
include("config.php");
unset($_SESSION['id']);
unset($_SESSION['token']);
unset($_SESSION['nome']); 

echo "<script>window.location = 'index.php'</script>";
exit;
?>