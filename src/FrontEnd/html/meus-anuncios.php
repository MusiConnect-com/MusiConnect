<?php
session_start();

if (!isset($_SESSION['UsuarioId'], $_SESSION['UsuarioTipo'], $_SESSION['UsuarioNome'], $_SESSION['UsuarioSobrenome'])) {
    header('Location: ../../BackEnd/views/logout.php');
    exit();
}

include '../../BackEnd/views/conexao.php'; // Conexão com o banco de dados

// Consulta SQL para selecionar os anúncios do usuário logado, incluindo habilidades, gêneros musicais e tipo de evento
$sql = "
    SELECT 
        A.AnuncioId,
        A.AnuncioTitulo,
        A.AnuncioDesc,
        A.AnuncioDataHrInicio,
        A.AnuncioDataHrFim,
        A.AnuncioValor,
        A.AnuncioStatus,
        U.UsuarioNome,
        U.UsuarioSobrenome,
        U.UsuarioEmail,
        C.CidadeNome,
        E.EstadoNome,
        H.HabilidadeNome,
        G.GeneroMuNome,
        T.TipoEventoNome AS TipoEvento
    FROM 
        TbAnuncio A
    JOIN 
        TbUsuario U ON A.UsuarioId = U.UsuarioId
    JOIN 
        TbCidade C ON A.CidadeId = C.CidadeId
    JOIN 
        TbEstado E ON C.EstadoUf = E.EstadoUf
    LEFT JOIN 
        TbAnuncioHabilidade AH ON A.AnuncioId = AH.AnuncioId
    LEFT JOIN 
        TbHabilidade H ON AH.HabilidadeId = H.HabilidadeId
    LEFT JOIN 
        TbAnuncioGeneroMusical AGM ON A.AnuncioId = AGM.AnuncioId
    LEFT JOIN 
        TbGeneroMusical G ON AGM.GeneroMuId = G.GeneroMuId
    LEFT JOIN 
        TbTipoEvento T ON A.TipoEventoId = T.TipoEventoId
    WHERE 
        A.UsuarioId = ?
"; // Filtro para mostrar apenas os anúncios do usuário logado

// Executar a consulta
$params = array($_SESSION['UsuarioId']);
$stmt = sqlsrv_query($conexao, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
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
    <script src="../js/contratos-ativos.js" defer></script>
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
        <a class="logo" href=""><img src="../img/img-logo.png" alt=""></a>
        <nav class="nav-links">
            <ul>
                <li><i id="search-icon" class="bi bi-search"></i></li>
                <li id="profiles-search"><a href="">Buscar Músicos</a></li>
                <li><a href="">Meus Contratos</a></li>
                <li><a href="./meus-anuncios.php">Meus Anúncios</a></li>
                <li><a href="./anunciar.php">Anunciar</a></li>
                <li class="nav-active"><a href="home-contratante.php">Home</a></li>
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

<!-- Exibir os anúncios -->
<div class="meus-anuncios">
    <h2>Meus Anúncios</h2>
    <?php
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo "<div class='anuncio'>";
            echo "<h3>" . htmlspecialchars($row['AnuncioTitulo']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['AnuncioDesc']) . "</p>";
            echo "<p>Data Início: " . $row['AnuncioDataHrInicio']->format('d/m/Y H:i') . "</p>";
            echo "<p>Data Fim: " . $row['AnuncioDataHrFim']->format('d/m/Y H:i') . "</p>";
            echo "<p>Valor: R$ " . htmlspecialchars($row['AnuncioValor']) . "</p>";
            echo "<p>Status: " . htmlspecialchars($row['AnuncioStatus']) . "</p>";
            echo "<p>Local: " . htmlspecialchars($row['CidadeNome']) . ", " . htmlspecialchars($row['EstadoNome']) . "</p>";

            // Exibir habilidades
            if ($row['HabilidadeNome']) {
                echo "<p>Habilidade: " . htmlspecialchars($row['HabilidadeNome']) . "</p>";
            }

            // Exibir gêneros musicais
            if ($row['GeneroMuNome']) {
                echo "<p>Gênero Musical: " . htmlspecialchars($row['GeneroMuNome']) . "</p>";
            }

            // Exibir tipo de evento
            if ($row['TipoEvento']) {
                echo "<p>Tipo de Evento: " . htmlspecialchars($row['TipoEvento']) . "</p>";
            }

            echo "</div>";
        }

        // Fechar a conexão
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conexao);
    ?>
</div>
</body>
</html>
