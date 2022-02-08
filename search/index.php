<?php
session_start();
    require_once('../config.php');
    include("../config.php");

if (!empty($_SESSION['token']) AND (empty($_SESSION['id']))) {
  echo "<script>window.location = 'acesso.php'</script>";
  exit;
}
if (isset($_SESSION['id'])) {
    $result = mysqli_query($conn, "SELECT * FROM `users` WHERE id='".$_SESSION['id']."' LIMIT 1");
    $resultado = mysqli_fetch_assoc($result);
    if ($_SESSION['id'] == '8' || $_SESSION['id'] == '1'){
    } else {
        echo "<script>window.location = '../index.php'</script>";
        exit;
    }
    if(isset($resultado)){
        if ($_SESSION['token'] == $resultado['token']){
        } else {
            echo "<script>window.location = '../exit.php'</script>";
            exit;
        }
    }else{ 
        echo "<script>window.location = '../exit.php'</script>";
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
    <script src="/js/xlsx.full.min.js"></script>
</head>

<style>
    .grid1 {
        display: grid;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .grid2 {
        display: grid;
    }

    .grid3 div {
        width: 100%;
    }

    .grid3 div button {
        display: inline-block;
        width: 100px;
    }

    .stop {
        display: none;
    }

    .start {
        display: none;
    }

    #quantidade {
        display: inline-block;
        width: 40%;
    }

    #valor {
        display: inline-block;
        width: 40%;
    }

    .upload-btn-wrapper {
        display: inline-block;
    }
</style>

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
                        $result = mysqli_query($conn, "SELECT * FROM `users` WHERE id='" . $_SESSION['id'] . "' LIMIT 1");
                        $resultado = mysqli_fetch_assoc($result);

                        if (isset($resultado)) {
                            if ($_SESSION['token'] == $resultado['token']) {
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
                                </div>
                            </li>
                            <li class="nav__item dropdown">
                                <a  class="nav__link">Suporte <i class="fas fa-caret-down"></i></a>
                                <div class="dropdown-content">
                                    <a href="taxa.php">TAXA</a>
                                    <a href="roteiro.php">ROTEIRO</a>
                                    <a href="mega.php">MEGA CLIENTES</a>
                                </div>
                            </li>';
                                echo '<a href="acesso.php" class="button" id="button--ghost">' . $_SESSION['nome'] . '</a>';
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
        <div class="grid1">
            <div class="grid2">
                <div class="home__subtitle">Selecione o filtro</div>
                <br>
                <div class="dropdownOption" style="display: inline-block;width: 350px;text-align: center;margin: auto; ">
                    <div class="dropBox" onmouseup="dropSelect()">
                        <p>EMPREST PREV PRIVADA - SABEMI</p> <i class="fa-active fa-caret-down"></i>
                    </div>
                    <div class="dropdownOption-content">
                        <div onmouseup="dropSelectSend('EMPREST PREV PRIVADA - SABEMI')">
                            EMPREST PREV PRIVADA - SABEMI
                        </div>
                        <div onmouseup="dropSelectSend('EMPREST BCO PRIVADOS - INTERME')">
                            EMPREST BCO PRIVADOS - INTERME
                        </div>
                        <div onmouseup="dropSelectSend('EMPREST BCO PRIVADOS - N/A')">
                            EMPREST BCO PRIVADOS - N/A
                        </div>
                        <div onmouseup="dropSelectSend('EMPREST BCO PRIVADOS - PAN')">
                            EMPREST BCO PRIVADOS - PAN
                        </div>
                        <div onmouseup="dropSelectSend('EMPREST BCO OFICIAL - BANRISUL')">
                            EMPREST BCO OFICIAL - BANRISUL
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="home__subtitle">Selecione o arquivo Excel</div>
            <br>
            <div class="grid2">
                <div class="upload-btn-wrapper">
                    <button class="btn">Selecionar</button>
                    <input class="form-control" type="file" id="input" accept=".xls,.xlsx">
                </div>
            </div>
            <br>
            <div class="grid4">
                <div id="quantidade"></div>
                <div id="valor"></div>
            </div>
            <br>
            <div class="grid3">
                <div class="inicio">
                    <button class="button--blue" id="button">Enviar</button>
                </div>
                <div class="stop">
                    <button class="button--red" id="stop">Parar</button>
                </div>
                <div class="start">
                    <button class="button--green" id="start">Reiniciar</button>
                </div>
            </div>
            <div id="result">
            </div>
        </div>
    </main>
</body>
<script src="/js/search.js"></script>
</html>