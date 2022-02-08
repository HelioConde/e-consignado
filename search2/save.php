<?php
require_once('config.php');
include("config.php");

$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$nascimento = $_POST['nascimento'];
$banco = $_POST['banco'];
$telefone = $_POST['telefone'];
$idade = 2021 - substr($nascimento,-4);
echo $cpf;
echo $nome;
echo $banco;
echo $telefone;
echo $idade;