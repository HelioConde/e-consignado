<?php
require_once('config.php');
include("config.php");

$nome = $_GET['nome'];
$cliente = $_GET['cliente'];
$telefone = $_GET['telefone'];
$dados = $_GET['dados'];
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    date_default_timezone_set('America/Sao_Paulo');
// CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
    $dataLocal = date('d/m/Y H:i:s', time());
    
mysqli_query($conn, "INSERT INTO `dados` (`nome`,`cliente`,`telefone`,`dados`,`data`) VALUES ('$nome','$cliente','$telefone','$dados','$dataLocal')");

echo '<script>window.location="https://web.whatsapp.com/send?phone='.$telefone.'&text='.$cliente.'";</script>';

echo "<script>window.close();</script>";

?>