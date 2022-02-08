<?php
    $servidor = "localhost";
    $usuario = "id17623303_bancl4";
    $senha = "182182654y!Y";
    $dbname = "id17623303_l4banc";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
    mysqli_set_charset($conn,"utf8");
    
    if(!$conn){
        die("Falha na conexao: " . mysqli_connect_error());
    }else{
    } 
?> 