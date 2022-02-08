<?php
// session_start inicia a sessão
session_start();
require_once('config.php');
include("config.php");

$password = $_POST['password'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

mysqli_query($conn, "UPDATE `users` SET `senha`='$hashed_password' WHERE id='".$_SESSION['id']."'");
mysqli_query($conn, "UPDATE `users` SET `new`='0' WHERE id='".$_SESSION['id']."'");

echo "<script>window.location = 'index.php'</script>";
exit;
?>