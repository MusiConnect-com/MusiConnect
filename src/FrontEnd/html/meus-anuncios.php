<?php

    include '../../BackEnd/views/verificar-logado.php';
    include '../../BackEnd/views/conexao.php';
    include '../../FrontEnd/html/acessibilidade.html';

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
        $stmt = $conexao->prepare("SELECT * FROM VwVisualizarAnuncios WHERE UsuarioId = :UsuarioId");
        $stmt->bindParam(':UsuarioId', $usuarioId);
        $stmt->execute();
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Anúncios</title>
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../css/meus-anuncios.css">
    <script src="../js/perfil.js" defer></script>
    <script src="../js/pesquisar-cabecalho-contratante.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#cep').mask('00000-000'); // Máscara para o CEP
            $('#telefone').mask('(00) 00000-0000');
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
                    <li class="nav-active"><a href="./meus-anuncios.php">Meus Anúncios</a></li>
                    <li><a href="./anunciar.php">Anunciar</a></li>
                    <li><a href="./home-contratante.php">Home</a></li>
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

    <!-- Exibir os anúncios -->
     
    <main>
        <div class="meus-anuncios">
            <?php
                try {
                    if ($stmt->rowCount() == 0) {
                        echo "<p> Nenhum anúncio encontrado </p>";
                        echo "<h1> Anuncie agora mesmo </h1>";
                        echo '<a href="./anunciar.php"> Anunciar </a>';
                    } else {
                        echo "<h1>Meus Anúncios</h1>";
                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $dataInicio = new DateTime($result['AnuncioDataHrInicio']);
                            $dataFim = new DateTime($result['AnuncioDataHrFim']);
        
                            echo '<a href="./ver-anuncio.php?id='.$result["AnuncioId"].'" class="anuncio">';
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
    </main>
</body>
</html>
