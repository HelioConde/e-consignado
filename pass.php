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
                    <li class="nav__item">
                        <a href="devedor.php" class="nav__link">Saldo devedor</a>
                    </li>

                    <li class="nav__item dropdown">
                        <a  class="nav__link">Valor liberado <i
                                class="fas fa-caret-down"></i></a>
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
                            <a href="roteiro.php"  class="active-l">ROTEIRO</a>
                            <a href="mega.php">MEGA CLIENTES</a>
                        </div>
                    </li>

                    <a href="acesso.php" class="button" id="button--ghost">ACESSO</a>
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
                <form action="newpass.php" id="submit" method="post">
                    <input class="input--black" type="password" name="password2" id="password2" placeholder="Nova Senha">
                    <br>
                    <br>
                    <input class="input--black" type="password" name="password" id="password" placeholder="Confirma Senha">
                </form>
                    <br>
                    <br>
                    <button class="btn" onmouseup="verifi()">Salvar</button>
                    <br>
                    <br>
            </div>
        </div>
    </main>
</body>
<script>

function verifi(){
    if ($("#password2").val() == $("#password").val()){
        $("#submit").submit();
    } else {
        alert("Senhas diferentes!")
    }
}

</script>
</html>