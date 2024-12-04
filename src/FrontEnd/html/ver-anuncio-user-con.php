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
            echo '<script>alert("Perdemos o anúncio escolhido, escolha-o novamente");</script>';
            header('Location: ../../FrontEnd/html/buscar-anuncios.php');
            exit();
        }
        $anuncioId = $_GET['id'];
        $stmt = $conexao->prepare("SELECT * FROM VwVisualizarAnuncios WHERE AnuncioId = :AnuncioId;");
        $stmt->bindParam(':AnuncioId', $anuncioId, PDO::PARAM_INT);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicConnect</title>
    <link rel="stylesheet" href="../css/ver-anuncio-user-con.css">
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
    <!--CABEÇALHO-->
    <!-- <header>
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
    </header> -->
    <!--FIM CABEÇALHO-->
    <!--PESQUISAR NO CABEÇALHO-->
    <!-- <div class="search-header">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Ex : Bar da esquina" autofocus>
        <i id="icon-close" class="bi bi-x"></i>
    </div> -->
    <!--FIM PESQUISAR NO CABEÇALHO-->
    <!--PERFIL CABEÇALHO-->
    <!-- <div class="profile-list" id="profile-list">
        <div class="content-top">
            <img src="/img/victor-vidal.png" alt="">
            <p>Victor Vidal</p>
            <div>
                <i id="close-profile-list" class="bi bi-x"></i>
            </div>
        </div>
        <hr>
        <div class="content-bottom">
            <a class="profile-list-items" href="/html/perfil-musico.html">Meu Perfil</a></li>
            <a class="profile-list-items" href="">Configurações</a></li>
            <a class="profile-list-items" href="../../BackEnd/views/logout.php">Sair</a></li>
        </div>
    </div> -->
    <!--FIM PERFIL CABEÇALHO-->
    <!--MAIN-->
    <main>

        <div class="anuncio">
            <?php
                try {
                    
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    $dataInicio = new DateTime($result['AnuncioDataHrInicio']);
                    $dataFim = new DateTime($result['AnuncioDataHrFim']);
                
                    // Esquerda do anúncio
                    echo '<div class="left-anuncio">';
                    
                    // Imagem do anúncio
                    echo '<div class="img-anuncio"><img src="' . htmlspecialchars($result['MidiaCaminho']) . '" alt="' . htmlspecialchars($result['MidiaNome']) . '"></div>';
                    
                    // Informações do anúncio
                    echo '<div class="info-anuncio">';
                    
                    // Descrição
                    echo "<h3>Descrição</h3>";
                    echo '<p class="descr-anuncio">' . htmlspecialchars($result['AnuncioDesc']) . "</p>";
                    // Benefícios oferecidos
                    if (!empty($result['AnuncioBeneficios'])) {
                        echo "<h3>Benefícios</h3>";
                        echo '<p>' . htmlspecialchars($result['AnuncioBeneficios']) . "</p>";
                    }
                    // Habilidades Necessárias
                    if (!empty($result['HabilidadeNome'])) {
                        echo "<h3>Habilidades Necessárias</h3>";
                        echo '<p>' . htmlspecialchars($result['HabilidadeNome']) . "</p>";
                    }
                    // Gênero Musical
                    echo "<h3>Gênero Musical</h3>";
                    echo '<p>' . htmlspecialchars($result['GeneroMuNome']) . "</p>";
                    // Localização
                    echo "<h3>Localização</h3>";
                    echo '<p>' . htmlspecialchars($result['AnuncioEnderecoLogra']) . ', ' . htmlspecialchars($result['AnuncioEnderecoNum']) . ' - ' . htmlspecialchars($result['AnuncioEnderecoBai']) . '</p>';
                    echo '<p class="local-anuncio"> CEP: ' . htmlspecialchars($result['AnuncioEnderecoCep']) ." - ". htmlspecialchars($result['CidadeNome']) . ", " . htmlspecialchars($result['EstadoUf']) . "</p>";
                    echo "</div>";
                    echo "</div>";

                    // Direita do anúncio
                    echo '<div class="right-anuncio">';
                    // Título
                    echo "<h1>" . htmlspecialchars($result['AnuncioTitulo']) . "</h1>";
                    // Valor
                    echo '<h2 class="valor-anuncio">R$ ' . htmlspecialchars($result['AnuncioValor']) . "</h2>";
                    // Tipo do Evento
                    echo "<h3>Tipo de Evento</h3>";
                    echo "<p>" . htmlspecialchars($result['TipoEventoNome']) . "</p>";
                    // Data e hora
                    echo "<h3>Data e Hora</h3>";
                    if ($dataInicio->format('d/m/Y') === $dataFim->format('d/m/Y')) {
                        echo "<p>" . $dataInicio->format('d/m/Y') . " - " . $dataInicio->format('H:i') . "hrs até " . $dataFim->format('H:i') . "hrs</p>";
                    } else {
                        echo "<p>" . $dataInicio->format('d/m/Y') . " - " . $dataInicio->format('H:i') . "hrs até " . $dataFim->format('H:i') . "hrs de " . $dataFim->format('d/m/Y') . "</p>";
                    }
                    // Nome de Contato e Contato
                    echo "<h3>Contato</h3>";
                    echo '<p>' . htmlspecialchars($result['AnuncioNomeContato']) . " - " . '<span id="telefone">'. htmlspecialchars($result['AnuncioContato']) . "</span>" . "</p>";
                    $botao = $result['AnuncioStatus'] == 'ATIVO' ? 'Desativar' : 'Ativar';
                    $link = $result['AnuncioStatus'] == 'ATIVO' ? '../../BackEnd/views/desativar-anuncio.php?id='.$anuncioId : '../../BackEnd/views/ativar-anuncio.php?id='.$anuncioId;
                    echo '<a href="'.$link.'" id="botao-func">'.$botao.'</a>';
                    echo "</div>";   
                    
                    // Fechar a consulta
                    $stmt->closeCursor();
                } catch(Exception $e) {
                    error_log("Erro ao exibir anúncio: " . $e->getMessage());
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