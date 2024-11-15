<?php

include '../../BackEnd/views/conexao.php';
session_start();

try {

    if (!$conexao) {
        throw new Exception("Erro ao conectar ao banco de dados.");
    }

    // Variáveis intermediárias para os dados do formulário
    $cpf = $_SESSION['UsuarioCpf'];
    $email = $_SESSION['UsuarioEmail'];
    $usuarioTipo = strtoupper($_POST['tipo-usuario']);
    $nome = $_SESSION['UsuarioNome'];
    $sobrenome = $_SESSION['UsuarioSobrenome'];
    $dataNascimento = date('Y-m-d', strtotime($_POST['date-birth']));
    $sexo = $_POST['sex'];
    $telefone = preg_replace('/\D/', '', $_POST['phone']);
    $cidadeId = $_POST['cidade'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $cep = str_replace('-', '', $_POST['cep']);
    $senhaHash = password_hash($_SESSION['UsuarioSenha'], PASSWORD_BCRYPT);
    $nomeArt = !empty($_POST['stage-name']) ? $_POST['stage-name'] : $nome;
    $descricao = $_POST['description'] ?? null;
    $valorServico = is_numeric($_POST['service-value']) ? (float) $_POST['service-value'] : 0;
    $habilidadeId = $_POST['skill'] ?? null;
    $generoMusicalId = $_POST['genre-music'] ?? null;

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

    // Preparando a declaração
    $stmt = $conexao->prepare("
    EXEC SpInserirUsuarioCompleto 
        @Cpf = :cpf, 
        @Email = :email, 
        @UsuarioTipo = :usuarioTipo, 
        @Nome = :nome, 
        @Sobrenome = :sobrenome, 
        @DataNascimento = :dataNascimento, 
        @Sexo = :sexo,
        @Telefone = :telefone,
        @CidadeId = :cidadeId, 
        @Logradouro = :logradouro, 
        @Numero = :numero, 
        @Complemento = :complemento, 
        @Bairro = :bairro, 
        @Cep = :cep, 
        @SenhaHash = :senhaHash, 
        @FotoNome = :fotoNome, 
        @FotoCaminho = :fotoCaminho, 
        @FotoTamanho = :fotoTamanho,
        @UsuarioNomeArt = :nomeArt,
        @Descricao = :descricao, 
        @ValorServico = :valorServico, 
        @HabilidadeId = :habilidadeId, 
        @GeneroMusicalId = :generoMusicalId
    ");

    // Vinculando os parâmetros com os valores correspondentes
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':usuarioTipo', $usuarioTipo);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':sobrenome', $sobrenome);
    $stmt->bindParam(':dataNascimento', $dataNascimento);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cidadeId', $cidadeId);
    $stmt->bindParam(':logradouro', $logradouro);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':complemento', $complemento);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':senhaHash', $senhaHash);
    $stmt->bindParam(':fotoNome', $fotoNome);
    $stmt->bindParam(':fotoCaminho', $fotoCaminho);
    $stmt->bindParam(':fotoTamanho', $fotoTamanho);
    $stmt->bindParam(':nomeArt', $nomeArt);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':valorServico', $valorServico);
    $stmt->bindParam(':habilidadeId', $habilidadeId);
    $stmt->bindParam(':generoMusicalId', $generoMusicalId);

    // Executa a stored procedure
    $stmt->execute();

    // Fazendo uma consulta para capturar o usuarioId
    $stmtUsuarioId = $conexao->prepare("SELECT UsuarioId FROM TbUsuario WHERE UsuarioCpf = :cpf AND UsuarioEmail = :email");
    $stmtUsuarioId->bindParam(':cpf', $cpf);
    $stmtUsuarioId->bindParam(':email', $email);
    $stmtUsuarioId->execute();

    $resultado = $stmtUsuarioId->fetch(PDO::FETCH_ASSOC);
    if (!$resultado) {
        throw new Exception("Não foi possível inserir o usuário.");
    }
    $_SESSION['UsuarioTipo'] = $usuarioTipo;
    $_SESSION['UsuarioId'] = $resultado['UsuarioId'];
    unset($_SESSION['UsuarioSenha'], $_SESSION['UsuarioEmail'], $_SESSION['UsuarioCpf']);

    // Redireciona o usuário para a página inicial correspondente
    header("Location: " . ($usuarioTipo === 'M' ? '../../frontend/html/home-musico.php' : '../../frontend/html/home-contratante.php'));
    exit();

} catch (Exception $e) {
    error_log("Erro ao inserir cadastro: " . $e->getMessage());
    echo '<script>
            alert("Ocorreu um erro inesperado. Tente novamente.");
            window.location.href = "../../BackEnd/views/logout.php";
          </script>';
}
?>