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
                                </div>
                            </li>
                            <li class="nav__item dropdown">
                                <a  class="nav__link active-link">Suporte <i class="fas fa-caret-down"></i></a>
                                <div class="dropdown-content">
                                    <a href="taxa.php">TAXA</a>
                                    <a href="roteiro.php" class="active-l">ROTEIRO</a>
                                    <a href="mega.php">MEGA CLIENTES</a>
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
            include 'vendor/autoload.php';

            $inbursaStr = file_get_contents('inbursa.json');
            $inbursa = json_decode($inbursaStr, true);
            $brbStr = file_get_contents('brb.json');
            $brb = json_decode($brbStr, true);
            $interStr = file_get_contents('inter.json');
            $inter = json_decode($interStr, true);
            
            // Parse pdf file and build necessary objects.
            $parser = new \Smalot\PdfParser\Parser();

            $total = count($_FILES['file']['name']);
            $inbursaData = "";
            $inbursaCode = 0;
            $brbData = "";
            $brbCode = 0;
            $interData = "";
            $interCode = 0;

            for( $i=0 ; $i < $total ; $i++ ) {
                $pdf = $parser->parseFile($_FILES['file']['tmp_name'][$i]);
                $text = $pdf->getText();
                $text = strtoupper($text);

                if (stripos($text, strtoupper("COMPROVANTE DE RENDIMENTOS")) == true){
                    foreach ($brb as $value) {
                        if (stripos($text,  strtoupper($value)) == false){
                        } else {
                            $brbCode++;
                            $brbData = $brbData.$value."<br>";
                        }
                    }
                
                    foreach ($inbursa as $value) {
                        if (stripos($text, strtoupper($value)) == false){
                        } else {
                            $inbursaCode++;
                            $inbursaData = $inbursaData.$value."<br>";
                        }
                    }
                    
                    foreach ($inter as $value) {
                        if (stripos($text, strtoupper($value)) == false){
                        } else {
                            $interCode++;
                            $interData = $interData.$value."<br>";
                        }
                    }
                    
                }
            }
                                        
                if($brbCode==0){
                    echo '<div style="text-align:center;">';
                    echo '<button class="button--green" style="width: 140px;">BRB</button><br><br>';
                    echo $brbData;
                    echo '</div>';
                } else {
                    echo '<div style="text-align:center;color:orange;width: 100%;display: inline-block;">';
                    echo '<button class="button--red"  style="width: 140px;">BRB</button><br><br>';
                    echo $brbData;
                    echo '</div>';
                }
                if($inbursaCode==0){
                    echo '<br><br><div style="text-align:center;">';
                    echo '<button class="button--green"  style="width: 140px;">INBURSA</button><br><br>';
                    echo $inbursaData;
                    echo '</div>';
                } else {
                    echo '<br><br><div style="text-align:center;color:orange;width: 100%;display: inline-block;">';
                    echo '<button class="button--red"  style="width: 140px;">INBURSA</button><br><br>';
                    echo $inbursaData;
                    echo '</div>';
                }
                if($interCode==0){
                    echo '<br><br><div style="text-align:center;">';
                    echo '<button class="button--green"  style="width: 140px;">INTER</button><br><br>';
                    echo $interData;
                    echo '</div>';
                } else {
                    echo '<br><br><div style="text-align:center;color:orange;width: 100%;display: inline-block;">';
                    echo '<button class="button--red"  style="width: 140px;">INTER</button><br><br>';
                    echo $interData;
                    echo '</div>';
                }
                
            ?>
            </div>
        </div>
    </main>
</body>

</html>