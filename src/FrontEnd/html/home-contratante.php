<?php
session_start();

    if (!isset($_SESSION['UsuarioId'], $_SESSION['UsuarioTipo'], $_SESSION['UsuarioNome'], $_SESSION['UsuarioSobrenome'])) {
        header('Location: ../../BackEnd/views/logout.php');
        exit();
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
                    <li><a href="">Meus Contratos</a></li>
                    <li><a href="">Meus Anúncios</a></li>
                    <li><a href="../html/anunciar.php">Anunciar</a></li>
                    <li class="nav-active"><a href="/html/home-contratante.html">Home</a></li>
                </ul>
            </nav>
    
            <div class="profile">
                <div class="profile-button" id="profile-button">
                    <img src="../img/perfil-contratante.jpg" alt="">
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
            <img src="../img/perfil-contratante.jpg" alt="">

            <?php
                echo "<p>" . $_SESSION['UsuarioNome'] . " " . $_SESSION['UsuarioSobrenome'] . "</p>";
            ?>
            
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
            <div class="contracts-active">
                <div class="title">Contratos ativos</div>

                <div class="modal-confirm">
                    <p>Deseja confirmar o contrato?</p>

                    <div class="btns">
                        <button class="not-confirm">Não</button>
                        <button class="yes-confirm">Sim</button>
                    </div>
                </div>

                <div class="modal-confirmed">
                    <p>Contrato confirmada com sucesso!</p>
                    <button class="btn-ok">Ok</button>
                </div>
                
                <div class="contracts">

                    <div class="contracts-item">
                        <div class="alert">
                            <p><span>NÃO CONFIRMADO!</span>Prazo de 24 horas</p>
                        </div>

                        <div class="content">
                            <div class="content-img">
                                <img src="/img/victor-vidal.png" alt="">
                            </div>

                            <div class="content-text">
                                <div class="info-music">
                                    <p>Victor Vidal</p>

                                    <div class="icons-chat">
                                        <i class="bi bi-chat"></i>
                                        <i class="bi bi-chat-fill"></i>
                                    </div>
                                </div>

                                <div class="info">
                                    <p>Evento no dia 01/10/2077 às 09:00 horas.</p>
                                    <p class="value">R$2.800,00</p>
                                </div>

                                <div class="btns">
                                    <button class="cancel">Cancelar</button>
                                    <button class="confirm">Confirmar</button>
                                    <button class="confirmed">Confirmado</button>
                                </div>
                            </div>
                        </div>    
                    </div>

                    <div class="contracts-item">
                        <div class="alert">
                            <p><span>NÃO CONFIRMADO!</span>Prazo de 24 horas</p>
                        </div>

                        <div class="content">
                            <div class="content-img">
                                <img src="/img/juliano-silva.jpg" alt="">
                            </div>

                            <div class="content-text">
                                <div class="info-music">
                                    <p>Juliano Silva</p>

                                    <div class="icons-chat">
                                        <i class="bi bi-chat"></i>
                                        <i class="bi bi-chat-fill"></i>
                                    </div>
                                </div>

                                <div class="info">
                                    <p>Evento no dia 27/06/2077 às 18:00 horas.</p>
                                    <p class="value">R$700,00</p>
                                </div>

                                <div class="btns">
                                    <button class="cancel">Cancelar</button>
                                    <button class="confirm">Confirmar</button>
                                    <button class="confirmed">Confirmado</button>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </section>
        <!--FIM SEÇÃO 2-->
        <!--SEÇÃO 3-->
        <section class="section-3">
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
                        <div class="top">
                            <h1>Aline Martins</h1>

                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                        </div>

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
                        <div class="top">
                            <h1>Jorge Lucas</h1>

                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                            </div>
                        </div>

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
                        <div class="top">
                            <h1>Pedro Pedrinho</h1>

                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>

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