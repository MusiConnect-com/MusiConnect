<?php

    include '../../BackEnd/views/verificar-logado.php';
    include '../../BackEnd/views/conexao.php';

    if ($_SESSION['UsuarioTipo'] != "C") return header('Location: ../../BackEnd/views/logout.php');

    $usuarioId = $_SESSION['UsuarioId'];
    $nome = $_SESSION['UsuarioNome'];
    $primeiroNome = explode(" ", $nome)[0];
    $sobrenome = $_SESSION['UsuarioSobrenome'];
    $usuarioTipo = $_SESSION['UsuarioTipo'];

    $sqlGetFoto = "SELECT M.MidiaCaminho FROM TbPerfilMidia PM INNER JOIN TbMidia M ON PM.MidiaId = M.MidiaId WHERE PM.UsuarioId = ? AND PM.MidiaDestino = 'perfil';";
    $parametroGetFoto = array($usuarioId);
    $resultGetFoto = sqlsrv_query($conexao, $sqlGetFoto, $parametroGetFoto);

    $caminhoFoto = null;

    if ($resultGetFoto !== false) {
        if ($linha = sqlsrv_fetch_array($resultGetFoto, SQLSRV_FETCH_ASSOC)) {
            $caminhoFoto = $linha['MidiaCaminho'];
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicConnect</title>
    <link rel="stylesheet" href="../css/home-contratante.css">
    <link rel="stylesheet" href="../global.css">
    <script src="../js/perfil.js" defer></script>
    <script src="../js/pesquisar-cabecalho-contratante.js" defer></script>
    <script src="../js/contratos-ativos.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <!--OVERLAY-->
    <div id="overlay1" class="overlay"></div>
    <div id="overlay2" class="overlay"></div>
    <div id="overlay3" class="overlay"></div>
    <!--FIM OVERLAY-->
    <!--CABEÇALHO-->
    <header>
        <div class="content">
            <a class="logo" href=""><img src="../img/img-logo.png"alt=""></a>
            <nav class="nav-links">
                <ul>
                    <li><i id="search-icon" class="bi bi-search"></i></li>
                    <li id="profiles-search"><a href="">Buscar Músicos</a></li>
                    <li><a href="./meus-anuncios.php">Meus Anúncios</a></li>
                    <li><a href="./anunciar.php">Anunciar</a></li>
                    <li class="nav-active"><a href="home-contratante.php">Home</a></li>
                </ul>
            </nav>
    
            <div class="profile">
                <?php echo '<p id="name-profile"> Olá ' .$primeiroNome. "</p>";?>
                <div class="profile-button" id="profile-button">
                    <?php echo '<img src="'.$caminhoFoto.'" alt="">';?>
                </div>
            </div> 
        </div>
    </header>
    <!--FIM CABEÇALHO-->
    <!--PERQUISAR NO CABEÇALHO-->
    <div class="search-header">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Ex : Bar da esquina" autofocus>
        <i id="icon-close" class="bi bi-x"></i>
    </div>
    <!--FIM PERQUISAR NO CABEÇALHO-->
    <!--PERFIL CABEÇALHO-->
    <div class="profile-list" id="profile-list">
        <div class="content-top">
            <?php echo '<img src="'.$caminhoFoto.'" alt="">';?>
            <?php echo "<p>" . $_SESSION['UsuarioNome'] . "</p>";?>
            
            <div>
                <i id="close-profile-list" class="bi bi-x"></i>
            </div>
        </div>
        <hr>
        <div class="content-bottom">
            <a class="profile-list-items" href="/html/perfil-musico.html">Meu Perfil</a>
            <a class="profile-list-items" href="">Configurações</a>
            <a class="profile-list-items" href="../../BackEnd/views/logout.php">Sair</a>
        </div>
    </div>
    <!--FIM PERFIL CABEÇALHO-->
    <!--MAIN-->
    <main>
        <!--SEÇÃO 1-->
        <section class="section-1">
            <div class="create-ads">
                <div class="content-text">
                    <h1>Encontre o músico perfeito para o seu evento</h1>
                    <p> Precisando de um músico?<br>
                        Crie um anúncio agora e selecione o ideal que o seu evento merece!
                    </p>
                    <a href="" class="btn-create-ads">Criar Agora</a>

                    <div class="content-search">
                        <p>Se preferir, você pode fazer uma busca rápida por perfis de músicos <br>
                            e estilos musicais, <span>EXPERIMENTE!</span></p>

                        <div class="search-input"> <!--Pesquisa-->
                            <input type="text" placeholder="Ex : Jorge Lucas">
                            <input type="text" placeholder="Ex : Sertanejo">
                            <button class="button-search" type="button"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
                
                <div class="content-img">
                    <img src="/img/mulher-cantando.png" alt="">
                </div>
            </div>  
        </section>
        <!--FIM SEÇÃO 1-->
        <!--SEÇÃO 2-->
        <section class="section-2">
            <div class="title">
                <h1>Músicos recomendados</h1>

                <a href="" class="see-all">
                    <p>Ver mais</p>
                    <i id="arrow-see-all" class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="profiles-music">
                <!-- Estrelas para avaliação 
                 Não marcada - <i class="bi bi-star"></i>
                 Meio marcada - <i class="bi bi-star-half"></i>
                 Marcada - <i class="bi bi-star-fill"></i>
                -->
                <div class="profiles-items">
                    <div class="content-img"><img src="/img/aline-martins.jpg" alt=""></div>
                    <div class="content-text">
                        <h1>Aline Martins</h1>
                        <ul>
                            <li class="genres"> Música clássica, Jazz, MPB</li>
                            <li class="descr">
                                Sou apaixonada por música desde os seis anos de idade. 
                                Tenho mais de uma década de experiência tocando violino 
                                e piano, e a música sempre foi a minha maior paixão. 
                            </li>
                            <li class="local">Campo Grande - MS</li>
                            <li class="value">R$500,00</li>
                        </ul>
                        <a href="">Contratar</a>
                    </div>
                </div>

                <div class="profiles-items">
                    <div class="content-img"><img src="/img/jorge-lucas.jpg" alt=""> </div>
                    <div class="content-text">
                        <h1>Jorge Lucas</h1>
                        <ul>
                            <li class="genres"> Rock, Blues, Indie</li>
                            <li class="descr">
                                Sou guitarrista e cantor com mais de 15 anos de estrada. 
                                Comecei a tocar guitarra quando ainda era adolescente e desde então, 
                                a música se tornou uma parte essencial da minha vida. 
                            </li>
                            <li class="local">Campo Grande - MS</li>
                            <li class="value">R$840,00</li>
                        </ul>
                        <a href="">Contratar</a>
                    </div>
                </div>

                <div class="profiles-items">
                    <div class="content-img"><img src="/img/pedro-pedrinho.jpg" alt=""></div>
                    <div class="content-text">
                        <h1>Pedro Pedrinho</h1>
                        <ul>
                            <li class="genres"> Música Latina, Samba, Funk, Pop</li>
                            <li class="descr">
                                Olá, eu sou Pedro Pedrinho, percussionista e baterista com mais
                                de 10 anos de experiência. Desde pequeno, sempre fui fascinado pelos 
                                ritmos e pelos diferentes sons que podemos criar.
                            </li>
                            <li class="local">Campo Grande - MS</li>
                            <li class="value">R$400,00</li>
                        </ul>
                        <a href="">Contratar</a>
                    </div>
                </div>
            </div>
        </section>
        <!--FIM SEÇÃO 2-->
        <!--RODAPÉ-->
        <footer>
            <h3>@ MusicConnect</h3>
        </footer>
        <!--FIM RODAPÉ-->
    </main>
    <!--FIM MAIN-->
</body>
</html>