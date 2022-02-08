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
                                    <a href="script.php">SCRIPT</a>
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
                <?php
                    $result = mysqli_query($conn, "SELECT * FROM `datab` ORDER BY banco DESC");

                    date_default_timezone_set('America/Sao_Paulo');
                    // CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
                    $hr = date('H', time());
                    if($hr >= 12 && $hr<18) {
                    $resp = "Boa tarde";}
                    else if ($hr >= 0 && $hr <12 ){
                    $resp = "Bom dia";}
                    else {
                    $resp = "Boa noite";}

                    $script = $_SESSION['script'];

                    $novafrase = str_replace('*d*', $resp, $script);
                    
                    echo '
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Telefone</th>
                                <th>Dados</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>';
                    while($row = mysqli_fetch_array($result))
                    {
                        
                        $str1 = strpos($row['telefone'],'"1":');
                        $str11 = substr($row['telefone'],$str1);
                        $str2 = strpos($str11,'</span>') ;
                        $str3 = substr($row['telefone'],$str1+7,11);

                        $primeiroNome = explode(" ", $row['nome']);
                        $novafrase2 = str_replace('*n*', mb_convert_case(current($primeiroNome), MB_CASE_TITLE, "UTF-8"), $novafrase);
                        echo '<tr><td>'.$row['nome'].'</td>';
                        echo '<td><a href="https://web.whatsapp.com/send?phone=55'.$str3.'&text='.preg_replace( "/\r\n/", "%0D", $novafrase2 ).'" target="_blank" >55'.$str3.'</a></td>';
                        echo '<td>'.$row['banco'].'</td>';
                        echo '<td>'.$row['dataNascimento'].'</td></tr>';
                    }
                ?>
            </div>
        </div>
    </main>
</body>
<script>
document.getElementById("textarea").value = localStorage.getItem('textView');
</script>
</html>