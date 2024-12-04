<?php

    include '../../BackEnd/views/verificar-logado.php';
    include '../../BackEnd/views/conexao.php';
    include '../../FrontEnd/html/acessibilidade.html';

    if ($_SESSION['UsuarioTipo'] != "M") return header('Location: ../../BackEnd/views/logout.php');

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
        
        if (isset($_GET['titulo'], $_GET['cidade'])) {
            $AnuncioTitulo = $_GET['titulo'];
            $CidadeNome = $_GET['cidade'];
        }
        
        if ((!isset($_GET['titulo'], $_GET['cidade'])) || ($_GET['titulo'] == '' AND $_GET['cidade'] == '')) {
            $stmt = $conexao->prepare("SELECT * FROM VwVisualizarAnuncios;");
            $stmt->execute();
        } 
        else if ($AnuncioTitulo !== '' && $CidadeNome == '') {
            $stmt = $conexao->prepare("SELECT * FROM VwVisualizarAnuncios WHERE AnuncioTitulo = :AnuncioTitulo;");
            $stmt->bindParam(':AnuncioTitulo', $AnuncioTitulo, PDO::PARAM_STR);
            $stmt->execute();
        }
        else if ($AnuncioTitulo == '' && $CidadeNome !== '') {
            $stmt = $conexao->prepare("SELECT * FROM VwVisualizarAnuncios WHERE CidadeNome = :CidadeNome;");
            $stmt->bindParam(':CidadeNome', $CidadeNome, PDO::PARAM_STR);
            $stmt->execute();
        }
        else {
            $stmt = $conexao->prepare("SELECT * FROM VwVisualizarAnuncios WHERE AnuncioTitulo = :AnuncioTitulo AND CidadeNome = :CidadeNome;");
            $stmt->bindParam(':AnuncioTitulo', $AnuncioTitulo, PDO::PARAM_STR);
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
    <link rel="stylesheet" href="../css/buscar-anuncios.css">
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
                    <li id="ads-search" class="nav-active"><a href="./buscar-anuncios.html">Buscar Anúncios</a></li>
                    <li><a href="./home-musico.php">Home</a></li>
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
                <form action="./buscar-anuncios.php" method="get" class="search-input">
                    <input type="text" placeholder="Título" name="titulo">
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
                            echo '<div class="img-anuncio"><img src='. $result['MidiaCaminho'].' alt=""></div>';
                            echo '<div class="info-anuncio">';
                            echo '<div class="titulo-preco">';
                            echo "<h2>" . htmlspecialchars($result['AnuncioTitulo']) . "</h2>";
                            echo '<h3 class="valor-anuncio">R$ ' . htmlspecialchars($result['AnuncioValor']) . "</h3>";
                            echo "</div>";
                            echo "<h4>" . htmlspecialchars($result['TipoEventoNome']) . "</h4>";
                            echo '<h6>Data e Hora</h6>';
                            if ($dataInicio->format('d/m/Y') === $dataFim->format('d/m/Y')) {
                                echo "<p>".$dataInicio->format('d/m/Y')." - ".$dataInicio->format('H:i')."hrs até ".$dataFim->format('H:i')."hrs</p>";
                            } else {
                                echo "<p>".$dataInicio->format('d/m/Y')." - ".$dataInicio->format('H:i')."hrs até ".$dataFim->format('H:i')."hrs de ".$dataFim->format('d/m/Y')."</p>";
                            }
                            echo '<h6>Descrição</h6>';
                            echo '<p class="descr-anuncio">' . htmlspecialchars($result['AnuncioDesc']) . "</p>";
                            echo '<p class="local-anuncio">' . htmlspecialchars($result['CidadeNome']) . ", " . htmlspecialchars($result['EstadoUf']) . "</p>";
                            echo "</div>";
                            echo "</a>";
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
                        <div class="category">
                            <p>Categorias</p>

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

                        <div class="event">
                            <p>Evento</p>

                            <div class="options-label">
                                <label for="bar">
                                    <input type="checkbox" name="options-event" class="filter-box" id="bar">
                                    <span>Bar</span>
                                </label>

                                <label for="restaurante">
                                    <input type="checkbox" name="options-event" class="filter-box" id="restaurante">
                                    <span>Restaurante</span>
                                </label>

                                <label for="casamento">
                                    <input type="checkbox" name="options-event" class="filter-box" id="casamento">
                                    <span>Casamento</span>
                                </label>

                                <label for="show">
                                    <input type="checkbox" name="options-event" class="filter-box" id="show">
                                    <span>Show</span>
                                </label>

                                <label for="aniversario">
                                    <input type="checkbox" name="options-event" class="filter-box" id="aniversario">
                                    <span>Aniversário</span>
                                </label>
                            </div>                            
                        </div>

                        <div class="value">
                            <p>Valor</p>

                            <div class="input">
                                <input type="value" id="minimum-value" placeholder="de">
                                <input type="value" id="maximum-value" placeholder="até">
                            </div>
                        </div>
                    </div>

                    <div class="buttons">
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