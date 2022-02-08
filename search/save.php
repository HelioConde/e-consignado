<?php
require_once('config.php');
include("config.php");

$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$nascimento = $_POST['nascimento'];
$banco = $_POST['banco'];
$telefone = $_POST['telefone'];
$idade = 2021 - substr($nascimento,-4);

if ($idade <= 61){
    $result2 = mysqli_query($conn, "SELECT * FROM `datab` WHERE cpf='" . $cpf . "' ORDER BY id DESC");
    
    if (mysqli_num_rows($result2) == 0) {
        mysqli_query($conn, "INSERT INTO `datab`(`cpf`,`nome`, `dataNascimento`, `banco`, `telefone`) VALUES
    ('$cpf','$nome','$nascimento','$banco','$telefone')");
        echo "Enviado";
    }
}