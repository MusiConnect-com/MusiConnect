<?php

    include '../../BackEnd/views/verificar-logado.php';
    include '../../BackEnd/views/conexao.php';
    include '../../FrontEnd/html/acessibilidade.html';

    if ($_SESSION['UsuarioTipo'] !== "M") return header('Location: ../../BackEnd/views/logout.php');

    $usuarioId = $_SESSION['UsuarioId'];
    $nome = $_SESSION['UsuarioNome'];
    $primeiroNome = explode(" ", $nome)[0];
    $sobrenome = $_SESSION['UsuarioSobrenome'];
    $usuarioTipo = $_SESSION['UsuarioTipo'];

    try {
        $stmt = $conexao->prepare("SELECT M.MidiaCaminho FROM TbMidia M INNER JOIN TbPerfilMidia PM ON PM.MidiaId = M.MidiaId WHERE PM.UsuarioId = :UsuarioId AND PM.MidiaDestino = 'perfil';");
        $stmt->bindParam(':UsuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();

        $caminhoFoto = null;
        if ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $caminhoFoto = $linha['MidiaCaminho'];
        }
    } catch (Exception $e) {
        // Exibe a mensagem de erro e redireciona para logout
        error_log("Erro ao consultar foto de perfil : " . $e->getMessage());
        echo '<script>alert("Ocorreu um erro de conexão, faça login novamente por favor.");</script>';
        header('Location: ../../BackEnd/views/logout.php');
        exit();
    }

    try {
        
        $stmt = $conexao->prepare("SELECT * FROM VwVisualizarAnuncios;");
        $stmt->execute();
        
    } catch (Exception $e) {
        error_log("Erro ao executar View VwVisualizarAnuncios: " . $e->getMessage());
        echo '<script>
                alert("Ocorreu um erro inesperado. Tente novamente.");
                window.location.href = "../../BackEnd/views/logout.php";
            </script>';
    }
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
                    <li id="ads-search"><a href="./buscar-anuncios.php">Buscar Anúncios</a></li>
                    <li class="nav-active"><a href="./home-musico.php">Home</a></li>
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
            <?php echo '<img src="'.$caminhoFoto.'" alt="">';?>
            <?php echo "<p>" .$nome. "</p>";?>
            <div>
                <i id="close-profile-list" class="bi bi-x"></i>
            </div>
        </div>
        <hr>
        <div class="content-bottom">
            <a class="profile-list-items" href="perfil-musico.html">Meu Perfil</a>
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

                    <form action="./buscar-anuncios.php" method="get" class="search-input">
                        <input type="text" placeholder="Título" name="titulo">
                        <input type="text" placeholder="Cidade" name="cidade">
                        <button class="button-search" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
        </section>
        <!--FIM SEÇÃO 1-->
        <!--SEÇÃO 2-->
        <section class="section-2">
            <div class="title">
                <h1>Anúncios mais recentes</h1>

                <a href="./buscar-anuncios.php" class="see-all">
                    <p>Ver mais</p>
                    <i id="arrow-see-all" class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="anuncios-recentes">
                <div class="left-arrow">
                    <i class="bi bi-chevron-right"></i>
                </div>

                <div class="anuncios">
                    <?php
                        try {
                            if ($stmt->rowCount() == 0) {
                                echo "<p> Nenhum anúncio encontrado </p>";
                            }
                            else {
                                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $dataInicio = new DateTime($result['AnuncioDataHrInicio']);
                                    $dataFim = new DateTime($result['AnuncioDataHrFim']);
                                
                                    echo '<a target="_blank" href="./ver-anuncio.php?id='.$result["AnuncioId"].'" class="anuncio">';
                                    echo '<div class="img-anuncio"><img src="'. htmlspecialchars($result['MidiaCaminho']) .'" alt=""></div>';
                                    echo '<div class="info-anuncio">';
                                    echo "<h2>" . htmlspecialchars($result['AnuncioTitulo']) . "</h2>";
                                    echo '<p class="local-anuncio">' . htmlspecialchars($result['CidadeNome']) . ' - ' . htmlspecialchars($result['EstadoUf']) . "</p>";
                                    echo '<p class="valor-anuncio">R$ ' . number_format($result['AnuncioValor'], 2, ',', '.') . "</p>";
                                    echo '</div>';
                                    echo '<button class="btn-ver-mais" type="button">Ver mais</button>';
                                    echo '</a>';
                                }
                            }
                            // Fechar a consulta
                            $stmt->closeCursor();
                            
                        } catch (Exception $e) {
                            error_log("Erro ao exibir anúncios recentes: " . $e->getMessage());
                            echo '<script>
                                    alert("Ocorreu um erro inesperado. Tente novamente.");
                                    window.location.href = "../../BackEnd/views/logout.php";
                                </script>';
                        }
                    ?>
                <div class="right-arrow">
                    <i class="bi bi-chevron-right"></i>
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