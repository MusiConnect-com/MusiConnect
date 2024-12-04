<?php

    include '../../BackEnd/views/verificar-logado.php';
    include '../../BackEnd/views/conexao.php';
    include '../../FrontEnd/html/acessibilidade.html';

    if ($_SESSION['UsuarioTipo'] !== "C") return header('Location: ../../BackEnd/views/logout.php');

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
        
        $stmt = $conexao->prepare("SELECT * FROM VwVisualizarPerfis WHERE MidiaDestino = 'perfil' OR MidiaDestino IS NULL;");
        $stmt->execute();
        
    } catch (Exception $e) {
        error_log("Erro ao executar View VwVisualizarPerfis: " . $e->getMessage());
        echo '<script>
                alert("Ocorreu um erro inesperado. Tente novamente.");
                window.location.href = "../../FrontEnd/html/home-contratante.php";
            </script>';
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script>
        $(document).ready(function(){
            $('#cep').mask('00000-000'); // Máscara para o CEP
            $('#telefone').mask('(00) 00000-0000');
            $('#value').mask('R$000,00');
        });
    </script>
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
                    <li id="profiles-search"><a href="../../FrontEnd/html/buscar-musicos.php">Buscar Músicos</a></li>
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
                    <a href="./anunciar.php" class="btn-create-ads">Criar Agora</a>

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
                <?php
                    try {
                        if ($stmt->rowCount() == 0) {
                            echo "<p> Nenhum músico encontrado </p>";
                        }
                        else {
                            while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<a target="_blank" href="./ver-musico.php?id='.$result['UsuarioId'].'" class="profiles-items">';
                                echo '<div class="content-img"><img src="'.$result['MidiaCaminho'].'" alt=""></div>';
                                echo '<div class="content-text">';
                                echo '<div class="content-text-top">';
                                echo '<h2>'.$result['UsuarioNomeArt'].'</h2>';
                                echo '<h3 class="value">R$'.$result['UsuarioPreco'].'</h3>';
                                echo '</div>';
                                echo '<ul>';
                                echo '<li class="genres"> <h6>Gênero Musical</h6> <p>'.$result['GeneroMuNome'].'</p></li>';
                                echo '<li class="habilidades"> <h6>Habilidades</h6> <p>'.$result['HabilidadeNome'].'</p></li>';
                                echo '<li class="descr"> <h6>Descrição</h6> <p>'.$result['UsuarioDesc'].'</p></li>';
                                echo '<li class="local">'.$result['CidadeNome']." - ".$result['EstadoUf'].'</li>';
                                echo '</ul>';
                                echo '</div>';
                                echo '</a>';
                            }

                            $stmt->closeCursor();
                        }
                    } catch (Exception $e) {
                        error_log("Erro ao exibir perfis recomendados: " . $e->getMessage());
                        echo '<script>
                                alert("Ocorreu um erro inesperado. Tente novamente.");
                                window.location.href = "../../BackEnd/views/logout.php";
                            </script>';
                    }
                ?>
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