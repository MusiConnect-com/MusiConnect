<?php

include '../../BackEnd/views/conexao.php';

// var_dump($_FILES);
if (isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo'];
    $nomeArquivo = $arquivo['name'];

    if ($arquivo['error']) {
        echo '<script>alert("Falha ao enviar arquivo.");</script>';
        header("Refresh:0");
        exit();
    }

    if ($arquivo['size'] > 2097152) {
        echo '<script>alert("Arquivo superior a 2MB.");</script>';
        header("Refresh:0");
        exit();
    }

    $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

    if ($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg") {
        echo '<script>alert("Tipo de arquivo diferente de jpg, jpeg e png.");</script>';
        header("Refresh:0");
        exit();
    }

    $pastaUpload = "../../FrontEnd/upload/";
    $novoNomeArquivo = uniqid();
    $arquivoSize = $arquivo['size'];
    $pastaArquivo = $pastaUpload . $novoNomeArquivo . "." . $extensao;

    $deu_certo = move_uploaded_file($arquivo['tmp_name'], $pastaArquivo);

    if ($deu_certo) {
        $sqlSetFoto = "INSERT INTO TbMidia (MidiaNome, TipoMidiaId, MidiaCaminho, MidiaTamanho) VALUES (?, ?, ?, ?)";
        $parametroFoto = array($nomeArquivo, 1, $pastaArquivo, $arquivoSize);
        $resultSetFoto = sqlsrv_query($conexao, $sqlSetFoto, $parametroFoto);

        if ($resultSetFoto) {
            // Recupera o ID da mídia
            $sqlGetMidiaId = "SELECT MidiaId FROM TbMidia WHERE MidiaCaminho = ?";
            $parametroGetMidiaId = array($pastaArquivo);
            $resultGetMidiaId = sqlsrv_query($conexao, $sqlGetMidiaId, $parametroGetMidiaId);

            if (!$resultGetMidiaId) {
                error_log(print_r(sqlsrv_errors(), true));
                throw new Exception("Erro ao pegar midiaId.");
            } else if (sqlsrv_fetch($resultGetMidiaId)) {
                $midiaId = sqlsrv_get_field($resultGetMidiaId, 0);
            }

            // Adicionando ao perfil mídia
            $sqlSetPerfilMidia = "INSERT INTO TbPerfilMidia (UsuarioId, MidiaId) VALUES (?, ?);";
            $parametroSetPerfilMidia = array(1, $midiaId);
            $resultSetPerfilMidia = sqlsrv_query($conexao, $sqlSetPerfilMidia, $parametroSetPerfilMidia);

            if (!$resultSetPerfilMidia) {
                error_log(print_r(sqlsrv_errors(), true));
                throw new Exception("Erro ao adicionar ao perfil mídia.");
            }

            echo '<p>Arquivo enviado com sucesso! <a target="_blank" href="'.$pastaArquivo.'">Acessar Arquivo</a></p>';
            echo '<img src="' .$pastaArquivo. '" alt="">';
        } else {
            echo "Erro : " . print_r(sqlsrv_errors(), true);
        }
    } else {
        echo '<p>Falha ao enviar arquivo</p>';
    }
}
?>