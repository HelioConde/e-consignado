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
                        <a href="devedor.html" class="nav__link">Saldo devedor</a>
                    </li>

                    <li class="nav__item dropdown">
                        <a  class="nav__link">Valor liberado <i
                                class="fas fa-caret-down"></i></a>
                        <div class="dropdown-content">
                           <a href="brb.html">BRB</a>
                            <a href="inbursa.html">INBURSA</a>
                            <a href="sabemi.html">SABEMI</a>
                        </div>
                    </li>
                    <li class="nav__item dropdown">
                        <a  class="nav__link active-link">Suporte <i class="fas fa-caret-down"></i></a>
                        <div class="dropdown-content">
                            <a href="taxa.html">TAXA</a>
                            <a href="roteiro.html" class="active-l">ROTEIRO</a>
                            <a href="mega.html">MEGA CLIENTES</a>
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
                <form enctype="multipart/form-data" action="roteiroview.php" method="post" id="pdfparser-demo-form"
                    accept-charset="UTF-8">
                    <div class="home__subtitle">Selecione o extrato de consignação e o contracheque.</div>
                    <br>
                    <br>
                    <div class="upload-btn-wrapper">
                        <button class="btn">Selecionar</button>
                        <input type="file" name="file[]" multiple="">
                    </div>
                    <br>
                    <br>
                    <div style="text-align: center;">
                        <button class="button--blue" onmouseup="calcular()">Enviar</button>
                    </div>
                    <br>
                    <br>
                </form>
            </div>
        </div>
    </main>
</body>

</html>