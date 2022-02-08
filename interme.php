<?php
require_once('config.php');
include("config.php");

$cpf = $_GET['cpf'];
$nome = $_GET['nome'];
$nascimento = $_GET['nascimento'];
$empresa = $_GET['empresa'];
$prazo = $_GET['prazo'];
$valor = $_GET['valor'];
$telefone = $_GET['telefone'];

                $result2 = mysqli_query($conn, "SELECT * FROM `interme` WHERE cpf='".$cpf."' ORDER BY id DESC");

                if(mysqli_num_rows($result2) == 0) {
                     mysqli_query($conn, "INSERT INTO `interme`(`cpf`,`nome`, `telefone`, `dataNascimento`, `empresa`, `prazo`, `valor`) VALUES
('$cpf','$nome','$telefone','$nascimento','$empresa','$prazo','$valor')");

//echo "<script>window.close();</script>";
                } else {
                echo "<script>window.close();</script>";
                }
?>