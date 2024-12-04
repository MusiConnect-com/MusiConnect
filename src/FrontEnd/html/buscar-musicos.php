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
        
        if (isset($_GET['nome-art'], $_GET['cidade'])) {
            $NomeArt = $_GET['nome-art'];
            $CidadeNome = $_GET['cidade'];
        }
        
        if ((!isset($_GET['nome-art'], $_GET['cidade'])) || ($_GET['nome-art'] == '' AND $_GET['cidade'] == '')) {
            $stmt = $conexao->prepare("SELECT * FROM VwVisualizarPerfis WHERE MidiaDestino = 'perfil' OR MidiaDestino IS NULL;");
            $stmt->execute();
        } 
        else if ($NomeArt !== '' && $CidadeNome == '') {
            $stmt = $conexao->prepare("SELECT * FROM VwVisualizarPerfis WHERE UsuarioNomeArt = :NomeArt AND (MidiaDestino = 'perfil' OR MidiaDestino IS NULL);");
            $stmt->bindParam(':NomeArt', $NomeArt, PDO::PARAM_STR);
            $stmt->execute();
        }
        else if ($NomeArt == '' && $CidadeNome !== '') {
            $stmt = $conexao->prepare("SELECT * FROM VwVisualizarPerfis WHERE CidadeNome = :CidadeNome AND (MidiaDestino = 'perfil' OR MidiaDestino IS NULL);");
            $stmt->bindParam(':CidadeNome', $CidadeNome, PDO::PARAM_STR);
            $stmt->execute();
        }
        else {
            $stmt = $conexao->prepare("SELECT * FROM VwVisualizarPerfis WHERE UsuarioNomeArt = :NomeArt AND CidadeNome = :CidadeNome AND (MidiaDestino = 'perfil' OR MidiaDestino IS NULL);");
            $stmt->bindParam(':NomeArt', $NomeArt, PDO::PARAM_STR);
            $stmt->bindParam(':CidadeNome', $CidadeNome, PDO::PARAM_STR);
            $stmt->execute();
        }

        
    } catch (Exception $e) {
        error_log("Erro ao executar View VwVisualizarAnuncios: " . $e->getMessage());
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
    <link rel="stylesheet" href="../css/buscar-musicos.css">
    <link rel="stylesheet" href="../global.css">
    <script src="../js/perfil.js" defer></script>
    <script src="../js/pesquisar-cabecalho-musico.js" defer></script>
    <script src="../js/filtros.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
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
                    <li class="nav-active" id="profiles-search"><a href="../../FrontEnd/html/buscar-perfis.php">Buscar Músicos</a></li>
                    <li><a href="./meus-anuncios.php">Meus Anúncios</a></li>
                    <li><a href="./anunciar.php">Anunciar</a></li>
                    <li><a href="home-contratante.php">Home</a></li>
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
            <div class="search">
                <form action="./buscar-musicos.php" method="get" class="search-input">
                    <input type="text" placeholder="Nome Artístico" name="nome-art">
                    <input type="text" placeholder="Cidade" name="cidade">
                    <button class="button-search" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>

            <div class="order">
                <div class="select">
                    <span class="selected">Mais recente</span>
                    <i id="i-order" class="bi bi-caret-down-fill"></i>
                </div>

                <ul class="order-list">
                    <li class="active">Mais recente</li>
                    <li>Menor valor</li>
                    <li>Maior valor</li>
                </ul>
            </div>
            </div>
        </section>
        <!--FIM SEÇÃO 1-->
        <!--SEÇÃO 2-->
        <section class="section-2">
        <div class="musicos">
            <?php
                try {
                    if ($stmt->rowCount() == 0) {
                        echo "<p> Nenhum músico encontrado </p>";
                    } 
                    else {
                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
                    }
        
                    // Fechar a consulta
                    $stmt->closeCursor();
                } catch(Exception $e) {
                    error_log("Erro ao exibir anúncios: " . $e->getMessage());
                    echo '<script>
                            alert("Ocorreu um erro inesperado. Tente novamente.");
                            window.location.href = "../../FrontEnd/html/home-contratante.php";
                        </script>';
                }
        
            ?>
        </div>

        <div class="filters">
            <div class="filters-list" id="filters-list">   
                <div class="list">          
                    <div class="filter-genero-musical">
                        <p>Gênero Musical</p>

                        <div class="options-label">
                            <label for="sertanejo">
                                <input type="checkbox" name="options-category" class="filter-box" id="sertanejo">
                                <span>Sertanejo</span>
                            </label>
                            
                            <label for="pagode">
                                <input type="checkbox" name="options-category" class="filter-box" id="pagode">
                                <span>Pagode</span>
                            </label>
                            
                            <label for="dj">
                                <input type="checkbox" name="options-category" class="filter-box" id="dj">
                                <span>Dj</span>
                            </label>

                            <label for="rock">
                                <input type="checkbox" name="options-category" class="filter-box" id="rock">
                                <span>Rock</span>
                            </label>

                            <label for="banda">
                                <input type="checkbox" name="options-category" class="filter-box" id="banda">
                                <span>Banda</span>
                            </label>
                        </div>
                    </div>

                    <div class="filter-Habilidades">
                        <p>Habilidades</p>

                        <div class="options-label">
                            <label for="voz">
                                <input type="checkbox" name="habilidades" class="filter-box" id="voz">
                                <span>Voz</span>
                            </label>

                            <label for="guitarra">
                                <input type="checkbox" name="habilidades" class="filter-box" id="guitarra">
                                <span>Guitarra</span>
                            </label>

                            <label for="bateria">
                                <input type="checkbox" name="habilidades" class="filter-box" id="bateria">
                                <span>Bateria</span>
                            </label>

                            <label for="baixo">
                                <input type="checkbox" name="habilidades" class="filter-box" id="baixo">
                                <span>Baixo</span>
                            </label>

                            <label for="piano">
                                <input type="checkbox" name="habilidades" class="filter-box" id="piano">
                                <span>Piano</span>
                            </label>
                        </div>                            
                    </div>


                    <div class="filter-value">
                        <p>Valor</p>

                        <div class="input">
                            <input type="value" id="minimum-value" placeholder="de">
                            <input type="value" id="maximum-value" placeholder="até">
                        </div>
                    </div>
                </div>

                <div class="filter-buttons">
                    <button type="button" class="button-clean">Limpar</button>
                    <button type="button" class="button-filter">Filtrar</button>
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

    <script>
        // mask input
        $('#minimum-value').mask("#.##0,00", {reverse: true});
        $('#maximum-value').mask("#.##0,00", {reverse: true});

        //iniciando a pagina com pesquisa
        document.addEventListener("DOMContentLoaded", function(){
            const query = localStorage.getItem("searchQuery");
            if (query){
                const queryInput = document.getElementById("keyword");
                queryInput.value = query;
                queryInput.focus();
            }
        });

    </script>
</body>
</html>