<?php
include '../../BackEnd/views/conexao.php'; // Conexão com o banco de dados

session_start();


try {
    // Verifica se o formulário foi enviado
    if (!$_SERVER["REQUEST_METHOD"] == "POST") {
        throw new Exception('Método de envio diferente de POST');
    }
    // Obtendo dados do formulário
    $usuarioId = $_SESSION['UsuarioId'];
    $titulo = $_POST['titulo'];
    $tipoEventoId = $_POST['tipo-evento'];
    $generoMusicalId = $_POST['genero-musical'];
    $descricao = $_POST['descricao'];
    $beneficios = $_POST['beneficios'];
    $habilidadeId = $_POST['habilidades'];
    $dataInicio = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['data-hr-inicio']);
    $dataFim = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['data-hr-fim']);
    $valor = $_POST['valor-hora'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $cep = str_replace('-', '', $_POST['cep']);
    $cidadeId = $_POST['cidade'];
    $nomeContato = $_POST['nome-contato'];
    $contato = preg_replace('/\D/', '', $_POST['telefone']);

    $dataInicioFormatada = $dataInicio ? $dataInicio->format('Y-m-d H:i:s') : null;
    $dataFimFormatada = $dataFim ? $dataFim->format('Y-m-d H:i:s') : null;

    // capturando a foto
    $foto = $_FILES['foto'];
    $fotoNome = $foto['name'];
    $fotoTamanho = $foto['size'];
    $pastaUpload = "../../FrontEnd/upload/";
    $nomeUniqFoto = uniqid();
    $extensaoFoto = strtolower(pathinfo($fotoNome, PATHINFO_EXTENSION));
    $fotoCaminho = $pastaUpload . $nomeUniqFoto . "." . $extensaoFoto;

    $uploadConcluido = move_uploaded_file($foto['tmp_name'], $fotoCaminho);
    if (!$uploadConcluido) {
        throw new Exception('Foto não movida com sucesso');
    }

    // Prepara a chamada da procedure
    $stmt = $conexao->prepare("
    EXEC SpInserirNovoAnuncio 
        @UsuarioId = :UsuarioId,
        @AnuncioTitulo = :AnuncioTitulo,
        @AnuncioDataHrInicio = :AnuncioDataHrInicio,
        @AnuncioDataHrFim = :AnuncioDataHrFim,
        @TipoEventoId = :TipoEventoId,
        @CidadeId = :CidadeId,
        @Logradouro = :Logradouro,
        @Numero = :Numero,
        @Complemento = :Complemento,
        @Bairro = :Bairro,
        @Cep = :Cep,
        @AnuncioDesc = :AnuncioDesc,
        @AnuncioBeneficios = :AnuncioBeneficios,
        @AnuncioContato = :AnuncioContato,
        @AnuncioNomeContato = :AnuncioNomeContato,
        @AnuncioValor = :AnuncioValor,
        @FotoNome = :FotoNome,
        @FotoCaminho = :FotoCaminho,
        @FotoTamanho = :FotoTamanho,
        @HabilidadeId = :HabilidadeId,
        @GeneroMusicalId = :GeneroMusicalId");

    // Definição dos parâmetros
    $stmt->bindParam(':UsuarioId', $usuarioId, PDO::PARAM_INT);
    $stmt->bindParam(':AnuncioTitulo', $titulo, PDO::PARAM_STR);
    $stmt->bindParam(':AnuncioDataHrInicio', $dataInicioFormatada);
    $stmt->bindParam(':AnuncioDataHrFim', $dataFimFormatada);
    $stmt->bindParam(':TipoEventoId', $tipoEventoId, PDO::PARAM_INT);
    $stmt->bindParam(':CidadeId', $cidadeId, PDO::PARAM_INT);
    $stmt->bindParam(':Logradouro', $logradouro, PDO::PARAM_STR);
    $stmt->bindParam(':Numero', $numero, PDO::PARAM_INT);
    $stmt->bindParam(':Complemento', $complemento, PDO::PARAM_STR);
    $stmt->bindParam(':Bairro', $bairro, PDO::PARAM_STR);
    $stmt->bindParam(':Cep', $cep, PDO::PARAM_STR);
    $stmt->bindParam(':AnuncioDesc', $descricao, PDO::PARAM_STR);
    $stmt->bindParam(':AnuncioBeneficios', $beneficios, PDO::PARAM_STR);
    $stmt->bindParam(':AnuncioContato', $contato, PDO::PARAM_STR);
    $stmt->bindParam(':AnuncioNomeContato', $nomeContato, PDO::PARAM_STR);
    $stmt->bindParam(':AnuncioValor', $valor);
    $stmt->bindParam(':FotoNome', $fotoNome, PDO::PARAM_STR);
    $stmt->bindParam(':FotoCaminho', $fotoCaminho, PDO::PARAM_STR);
    $stmt->bindParam(':FotoTamanho', $fotoTamanho, PDO::PARAM_INT);
    $stmt->bindParam(':HabilidadeId', $habilidadeId, PDO::PARAM_INT);
    $stmt->bindParam(':GeneroMusicalId', $generoMusicalId, PDO::PARAM_INT);

    $stmt->execute();

    header("Location: ../../frontend/html/home-contratante.php");
    exit();

} catch (Exception $e){
    error_log("Erro ao inserir anúncio: " . $e->getMessage());
    echo '<script>
            alert("Ocorreu um erro inesperado. Tente novamente.");
            window.location.href = "../../FrontEnd/html/home-contratante.php";
          </script>';
}
?>
