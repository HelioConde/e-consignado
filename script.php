<?php
session_start();
    require_once('config.php');
    include("config.php");

if (!empty($_SESSION['token']) AND (empty($_SESSION['id']))) {
  echo "<script>window.location = 'acesso.php'</script>";
  exit;
}
if (isset($_SESSION['id'])) {
    $result = mysqli_query($conn, "SELECT * FROM `users` WHERE id='".$_SESSION['id']."' LIMIT 1");
    $resultado = mysqli_fetch_assoc($result);

    if(isset($resultado)){
        if ($_SESSION['token'] == $resultado['token']){
        } else {
            echo "<script>window.location = 'exit.php'</script>";
            exit;
        }
    }else{ 
        echo "<script>window.location = 'exit.php'</script>";
        exit;
    }
} else {
    echo "<script>window.location = '../exit.php'</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L4</title>
    <script src="/js/jquery.js"></script>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <!--==================== BACKGROUND ====================-->
    <div id="background">
        <div id='stars'></div>
        <div id='stars2'></div>
        <div id='stars3'></div>
    </div>
    <!--==================== HEADER ========================-->
    <header class="header scroll-header" id="header">
        <nav class="nav container">
            <a href="../" class="nav__logo">
                L4
            </a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                <?php
                if (isset($_SESSION['id'])) {
                    $result = mysqli_query($conn, "SELECT * FROM `users` WHERE id='".$_SESSION['id']."' LIMIT 1");
                    $resultado = mysqli_fetch_assoc($result);

                    if(isset($resultado)){
                        if ($_SESSION['token'] == $resultado['token']){
                        echo '
                            <li class="nav__item">
                                <a href="devedor.php" class="nav__link">Saldo devedor</a>
                            </li>

                            <li class="nav__item dropdown">
                                <a  class="nav__link">Valor liberado <i class="fas fa-caret-down"></i></a>
                                <div class="dropdown-content">
                                    <a href="brb.php">BRB</a>
                                    <a href="inbursa.php">INBURSA</a>
                                    <a href="sabemi.php">SABEMI</a>
                                    <a href="inter.php">INTER</a>
                                </div>
                            </li>
                            <li class="nav__item dropdown">
                                <a  class="nav__link active-link">Suporte <i class="fas fa-caret-down"></i></a>
                                <div class="dropdown-content">
                                    <a href="taxa.php">TAXA</a>
                                    <a href="roteiro.php">ROTEIRO</a>
                                    <a href="mega.php" class="active-l">MEGA CLIENTES</a>
                                </div>
                            </li>';
                            echo '<a href="acesso.php" class="button" id="button--ghost">'.$_SESSION['nome'].'</a>';
                        } else {
                            echo '<a href="acesso.php" class="button" id="button--ghost">ACESSO</a>';
                        }
                    } else {
                        echo '<a href="acesso.php" class="button" id="button--ghost">ACESSO</a>';
                    }
                } else {
                    echo '<a href="acesso.php" class="button" id="button--ghost">ACESSO</a>';
                }
                ?>
                    
                </ul>

                <div class="nav__close" id="nav-close">
                    <i class="bx bx-x"></i>
                </div>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <i class="bx bx-grid-alt"></i>
            </div>

        </nav>
    </header>
    <!--==================== MAIN ====================-->
  <main>
        <div class="devedor">
            <div class="box1">
                <form action="script2.php" id="form">
                    <textarea id="textarea" class="input--black" name="script" rows="10" cols="60" placeholder="Escreva seu Script"></textarea>
                </form>
                <br>
                <button class="button--blue" style="width: 150px;text-align: center;margin: auto;" onmouseup="enviar()">Enviar</button>
                <br>
                *n* = Nome
                <br>
                *d* = Saudação
            </div>
        </div>
    </main>
</body>
<script>
    document.getElementById("textarea").value = localStorage.getItem('textView');
    function enviar(){
        localStorage.setItem('textView',document.getElementById("textarea").value);
        form.submit();
    }
</script>
</html>