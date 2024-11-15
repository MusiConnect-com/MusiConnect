<?php

$serverNome = 'JOAO\SQLEXPRESS';
$dbNome = 'TesteFoto';
$usuaNome = 'João';
$senha = 'Jo121218vi!';
$dsn = "sqlsrv:Server=$serverNome;Database=$dbNome"; //Data Source Name, string de conexão
// parametros : nome do driver:Nome do servidor;Nome do banco de dados; Porta (opcional)

// Conexão PDO
try {
    $conexao = new PDO($dsn, $usuaNome, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // definindo o modo de erro como exception
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit();
}

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
        // Inserir e obter o ID no mesmo comando com PDO
        $sqlSetFoto = "
            INSERT INTO TbMidia (MidiaNome, MidiaCaminho, MidiaTamanho) 
            VALUES (:nomeArquivo, :caminhoArquivo, :arquivoSize);";

        // Preparar a consulta PDO
        $stmt = $conexao->prepare($sqlSetFoto);

        // Vincular os parâmetros
        $stmt->bindParam(':nomeArquivo', $nomeArquivo);
        $stmt->bindParam(':caminhoArquivo', $pastaArquivo);
        $stmt->bindParam(':arquivoSize', $arquivoSize);

        // Executar a consulta
        $stmt->execute();

        // Obter o último ID inserido
        $idInserido = $conexao->lastInsertId();

        if ($idInserido) {
            echo '<p>Arquivo enviado com sucesso! <a target="_blank" href="'.$pastaArquivo.'">Acessar Arquivo a MidiaId '.$idInserido.'</a></p>';
            echo '<img src="' .$pastaArquivo. '" alt="">';
        } else {
            echo "Erro ao obter o último ID inserido.";
        }
    } else {
        echo '<p>Falha ao enviar arquivo</p>';
    }
}
