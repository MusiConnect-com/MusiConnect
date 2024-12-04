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
        if (!isset($_GET['id'])) {
            echo '<script>alert("Perdemos o músico escolhido, escolha-o novamente");</script>';
            header('Location: ../../FrontEnd/html/buscar-anuncios.php');
            exit();
        }
        $usuarioId = $_GET['id'];
        $stmt = $conexao->prepare("SELECT * FROM VwVisualizarPerfis WHERE UsuarioId = :UsuarioId;");
        $stmt->bindParam(':UsuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();

        // Consulta das fotos de galeria
        $midiaDestino = 'galeria';
        $stmtFotos = $conexao->prepare("SELECT * FROM VwVisualizarFotosGaleria WHERE UsuarioId = :UsuarioId AND MidiaDestino = :MidiaDestino;");
        $stmtFotos->bindParam(':UsuarioId', $usuarioId, PDO::PARAM_INT);
        $stmtFotos->bindParam(':MidiaDestino', $midiaDestino, PDO::PARAM_STR);
        $stmtFotos->execute();

    } catch (Exception $e) {
        error_log("Erro ao executar Views: " . $e->getMessage());
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
    <link rel="stylesheet" href="../css/ver-musico.css">
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
    <!-- CABEÇALHO-->
    <!-- <header>
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
    </header> -->
    <!--FIM CABEÇALHO-->
    <!--PERQUISAR NO CABEÇALHO-->
    <!-- <div class="search-header">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Ex : Bar da esquina" autofocus>
        <i id="icon-close" class="bi bi-x"></i>
    </div> -->
    <!--FIM PERQUISAR NO CABEÇALHO-->
    <!--PERFIL CABEÇALHO-->
    <!-- <div class="profile-list" id="profile-list">
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
    </div> -->
    <!--FIM PERFIL CABEÇALHO -->
    <!--MAIN-->
    <main>

        <div class="músico">
            <?php
                try {
                    
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    // Cabeçalho do musico
                    echo '<div class="header-musico">';
                    // Esquerda do cabeçalho musico
                    echo '<div class="header-left-musico">';
                    // Imagem do musico
                    $img = $result['MidiaCaminho'] ? $result['MidiaCaminho'] : '../img/sem-imagem.jpg';
                    echo '<div class="content-img"><img src="'.$img.'" alt="' . htmlspecialchars($result['MidiaNome']) . '"></div>';
                    echo "</div>";
                    // Direita do cabeçalho musico
                    echo '<div class="header-right-musico">';
                    // Nome Artístico
                    echo '<h1>'.$result['UsuarioNomeArt'].'</h1>';
                    // Preço por serviço
                    $preco = $result['UsuarioPreco'] ? $result['UsuarioPreco'] : 'À combinar';
                    echo '<h2 class="value">R$'.$preco.'</h2>';
                    // Descrição
                    echo '<h6 class="descr">Descrição</h6>';
                    echo '<p class="descr-p">'.$result['UsuarioDesc'].'</p>';
                    // Local
                    echo '<h6 class="local">Mora em</h6>';
                    echo '<p>'.$result['CidadeNome']." - ".$result['EstadoUf'].'</p>';
                    // Contato
                    echo '<h6 class="telefone">Contato</h6>';
                    echo '<p id="telefone">'.$result['TelefoneNum'].'</p>';
                    echo '<button type="button" id="botao-zap">Entrar em Contato <i class="bi bi-whatsapp"></i></button>';
                    echo "</div>";
                    echo "</div>";
                    // Corpo do musico
                    echo '<div class="body-musico">';
                    // Características Musicais
                    echo '<div class="body-carac-musico">';
                    // Habilidades
                    echo '<div class="carac-musico">';
                    echo '<img src="../img/icon-violao.png" alt="">';
                    echo '<div class="layout-h3-h6">';
                    echo "<h3>Habilidades</h3>";
                    echo '<p>' . htmlspecialchars($result['HabilidadeNome']) . "</p>";
                    echo "</div>";
                    echo "</div>";
                    // Gênero Musical
                    echo '<div class="carac-musico">';
                    echo '<i class="bi bi-music-note-beamed"></i>';
                    echo '<div class="layout-h3-h6">';
                    echo "<h3>Gênero Musical</h3>";
                    echo '<p>' . htmlspecialchars($result['GeneroMuNome']) . "</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    // Galeria de fotos
                    echo '<div class="gallery-photo">';
                    echo '<h3>Galeria de Fotos</h3>';
                    if ($stmtFotos->rowCount() == 0) {
                        echo '<h6>Galeria de fotos vázia</h6>'; 
                    }else {
                        echo '<div class="photos">';
                        while ($resultFotos = $stmtFotos->fetch(PDO::FETCH_ASSOC)){
                            $photo = $resultFotos['MidiaCaminho'];
                            echo '<div class="content-photo"><img src="'.$photo.'" alt="' . htmlspecialchars($resultFotos['MidiaNome']) . '"></div>';
                        }
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "</div>";
                    
                    // Fechar a consulta
                    $stmt->closeCursor();
                    $stmtFotos->closeCursor();
                } catch(Exception $e) {
                    error_log("Erro ao exibir músico: " . $e->getMessage());
                    echo '<script>
                            alert("Ocorreu um erro inesperado. Tente novamente.");
                            window.location.href = "../../FrontEnd/html/home-contratante.php";
                        </script>';
                }
            ?>
        </div>
    </main>
    <!--FIM MAIN-->
</body>
</html>