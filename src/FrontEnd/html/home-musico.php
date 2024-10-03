<?php
session_start();

    // if (!isset($_SESSION['UsuarioId'], $_SESSION['UsuarioTipo'], $_SESSION['UsuarioNome'], $_SESSION['UsuarioSobrenome'])) {
    //     header('Location: ../../BackEnd/views/logout.php');
    //     exit();
    // }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicConnect</title>
    <link rel="stylesheet" href="../css/home-musico.css">
    <link rel="stylesheet" href="../global.css">
    <script src="../js/perfil.js" defer></script>
    <script src="../js/pesquisar-cabecalho-musico.js" defer></script>
    <script src="..js/contratos-ativos.js" defer></script>
    <script src="../js/rolagem-ads.js" defer></script>
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
                    <li id="ads-search"><a href="/html/anuncios-musico.html">Buscar Anúncios</a></li>
                    <li><a href="#">Meus Contratos</a></li>
                    <li class="nav-active"><a href="/html/home-musico.html">Home</a></li>
                </ul>
            </nav>

            <div class="profile">
                <div class="profile-button" id="profile-button">
                    <img src="../img/victor-vidal.png" alt="">
                </div>
            </div> 
        </div>
    </header>
    <!--FIM CABEÇALHO-->
    <!--PESQUISAR NO CABEÇALHO-->
    <div class="search-header">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Ex : Bar da esquina" autofocus>
        <i id="icon-close" class="bi bi-x"></i>
    </div>
    <!--FIM PESQUISAR NO CABEÇALHO-->
    <!--PERFIL CABEÇALHO-->
    <div class="profile-list" id="profile-list">
        <div class="content-top">
            <img src="../img/victor-vidal.png" alt="">

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
            <div class="search">
                <div class="content-text">
                    <h1>Mostre o seu talento para o mundo!</h1>
                    <p> Está procurando por uma oportunidade no mercado musical?<br>
                        Faça uma busca rápida e encontre <span>ANÚNCIOS</span> ideal para você!</p>

                    <div class="search-input">
                        <input type="text" placeholder="Ex : Bar da esquina">
                        <input type="text" placeholder="Ex : Campo Grande">
                        <button class="button-search" type="button"><i class="bi bi-search"></i></button>
                    </div>
                </div>

                <div class="content-img">
                    <img src="/img/tocar-guitarra.png" alt="">
                </div>
            </div>
        </section>
        <!--FIM SEÇÃO 1-->
        <!--SEÇÃO 2-->
        <section class="section-2">
            <div class="contracts-active">
                <div class="title">Contratos ativos</div>

                <div class="modal-confirm">
                    <p>Deseja confirmar presença no evento?</p>
                    
                    <div class="btns">
                        <button class="not-confirm">Não</button>
                        <button class="yes-confirm">Sim</button>
                    </div>
                </div>

                <div class="modal-confirmed">
                    <p>Presença confirmada com sucesso!</p>
                    <button class="btn-ok">Ok</button>
                </div>


                <div class="contracts">
                    <div class="contracts-item">
                        <div class="alert">
                            <p><span>NÃO CONFIRMADO!</span>Prazo de 24 horas</p>
                        </div>

                        <div class="content">
                            <div class="info-contractor">
                                <img src="/img/casamento-bueno.jpg" alt="bar do zé">
                                <div>
                                    <p>Casamento Buenos</p>

                                    <div class="icons-chat">
                                        <i class="bi bi-chat"></i>
                                        <i class="bi bi-chat-fill"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="info-contract">
                                <p>Evento no dia 01/10/2077 às 09:00 horas.</p>
                                <p class="value-contract">R$2.800,00</p>
                            </div>

                            <div class="btns">
                                <button class="cancel">Cancelar</button>
                                <button class="confirm">Confirmar</button>
                                <button class="confirmed">Confirmado</button>
                            </div>
                        </div>    
                    </div>

                    <div class="contracts-item">
                        <div class="alert">
                            <p><span>NÃO CONFIRMADO!</span>Prazo de 24 horas</p>
                        </div>

                        <div class="content">
                            <div class="info-contractor">
                                <img src="/img/bar-do-ze.jpg" alt="bar do zé">
                                <div>
                                    <p>Bar do Zé</p>

                                    <div class="icons-chat">
                                        <i class="bi bi-chat"></i>
                                        <i class="bi bi-chat-fill"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="info-contract">
                                <p>Evento no dia 18/05/2077 às 18:00 horas.</p>
                                <p class="value-contract">R$400,00</p>
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
        </section>
        <!--FIM SEÇÃO 2-->
        <!--SEÇÃO 3-->
        <section class="section-3">
            <div class="title">
                <h1>Anúncios mais recentes</h1>

                <a href="/html/anuncios-musico.html" class="see-all">
                    <p>Ver mais</p>
                    <i id="arrow-see-all" class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="ads">
                <div class="left-arrow">
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="ad">
                    <a class="ad-item">
                        <div class="img-ad"><img src="/img/estabelecimento.png" alt=""></div>
                        <div class="info-ad">
                            <h2>Restaurante Carioca</h2>
                            <p class="local-ad">Campo Grande - MS</p>
                            <p class="value-ad">R$ 400,00</p>  
                        </div>
                        <button class="btn-see-more" type="button">Ver mais</button>
                    </a>
                    
                    <a class="ad-item">
                        <div class="img-ad"><img src="/img/casamento.png" alt=""></div>
                        <div class="info-ad">
                            <h2>Meu Casamento</h2>
                            <p class="local-ad">Campo Grande - MS</p>
                            <p class="value-ad">R$ 1.000,00</p>
                        </div>
                        <button class="btn-see-more" type="button">Ver mais</button>
                    </a>
                    
                    <a class="ad-item">
                        <div class="img-ad"><img src="/img/cultural.png" alt=""></div>
                        <div class="info-ad">
                            <h2>Cultural</h2>
                            <p class="local-ad">Campo Grande - MS</p>
                            <p class="value-ad">R$ 600,00</p>
                        </div>
                        <button class="btn-see-more" type="button">Ver mais</button>
                    </a>
                
                    <a class="ad-item">
                        <div class="img-ad"><img src="/img/cafe-mostarda.jpg" alt=""></div>
                        <div class="info-ad">
                            <h2>Café Mostarda</h2>
                            <p class="local-ad">Campo Grande - MS</p>
                            <p class="value-ad">R$ 800,00</p>
                        </div>
                        <button class="btn-see-more" type="button">Ver mais</button>
                    </a>
                
                    <a class="ad-item">
                        <div class="img-ad"><img src="/img/festa-15-anos.webp" alt=""></div>
                        <div class="info-ad">
                            <h2>Meus 15 anos</h2>
                            <p class="local-ad">Campo Grande - MS</p>
                            <p class="value-ad">À Combinar</p>
                        </div>
                        <button class="btn-see-more" type="button">Ver mais</button>
                    </a>
                </div>
                
                <div class="right-arrow">
                    <i class="bi bi-chevron-right"></i>
                </div>      
            </div>
        </section>
        <!--FIM SEÇÃO 3-->
        <!--RODAPÉ-->
        <footer>
            <h3>@ MusicConnect</h3>
        </footer>
        <!--FIM RODAPÉ-->
    </main>
    <!--FIM MAIN-->
</body>
</html>