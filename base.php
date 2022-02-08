<?php
require_once('config.php');
include("config.php");

$nome = $_GET['nome'];
$cliente = $_GET['cliente'];
$telefone = $_GET['telefone'];
$dados = $_GET['dados'];

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('d/m/Y H:i:s', time());
    
mysqli_query($conn, "INSERT INTO `dados` (`nome`,`cliente`,`telefone`,`dados`,`data`) VALUES ('$nome','$cliente','$telefone','$dados','$dataLocal')");

echo "<script>window.close();</script>";
?>