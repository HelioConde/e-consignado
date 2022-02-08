<?php
session_start();
    require_once('config.php');
    include("config.php");

    if (!empty($_POST) AND (empty($_POST['email']) OR empty($_POST['password']))) {
      echo "<script>window.location = 'acesso.php'</script>";
      exit;
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
    $senha = "";
    function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){
      $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
      $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
      $nu = "0123456789"; // $nu contem os números
      $si = "!@#$%¨&*()_+="; // $si contem os símbolos
      $senha = "";
    
      if ($maiusculas){
            // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
            $senha .= str_shuffle($ma);
      }
    
        if ($minusculas){
            // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
            $senha .= str_shuffle($mi);
        }
    
        if ($numeros){
            // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
            $senha .= str_shuffle($nu);
        }
    
        if ($simbolos){
            // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
            $senha .= str_shuffle($si);
        }
    
        // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
        return substr(str_shuffle($senha),0,$tamanho);
    }
    $token = gerar_senha(8, true, true, true, false);
    $result = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email' LIMIT 1");
    $resultado = mysqli_fetch_assoc($result);
    
    if(isset($resultado)){
       if((password_verify($password, $resultado['senha']))){
           mysqli_query($conn, "UPDATE `users` SET `token`='$token' WHERE id='".$resultado['id']."'");
           $_SESSION['id'] = $resultado['id'];
            $_SESSION['nome'] = $resultado['nome'];
           $_SESSION['token'] = $token;
           if ($resultado['new'] == 1){
                echo "<script>window.location = 'pass.php'</script>";
           } else {
                echo "<script>window.location = './'</script>";
           }
        } else {
            $resultado['senha'];
          echo "<script>window.location = 'acesso.php?erro=true'</script>";
          exit;
        }
        
    }else{ 
        echo "<script>window.location = 'acesso.php?erro=true'</script>";
        exit;
    }
?>