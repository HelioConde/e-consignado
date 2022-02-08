<?php
    $servidor = "localhost";
    $usuario = "";
    $senha = "";
    $dbname = "";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    mysqli_set_charset($conn,"utf8");
    
    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
    } 
?> 
