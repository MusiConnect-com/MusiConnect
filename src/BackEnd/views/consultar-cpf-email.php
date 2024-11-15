<?php

include '../../BackEnd/views/conexao.php';

session_start();

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['UsuarioNome'] = $_POST['nome'];
        $_SESSION['UsuarioSobrenome'] = $_POST['sobrenome'];
        $_SESSION['UsuarioCpf'] = str_replace(['.', '-'], '', $_POST['cpf']);
        $_SESSION['UsuarioEmail'] = $_POST['email'];
        $_SESSION['UsuarioSenha'] = $_POST['senha'];
    }

    // Verifica se o CPF ou e-mail já existe
    $cpf = $_SESSION['UsuarioCpf'];
    $email = $_SESSION['UsuarioEmail'];

    // Prepara a consulta com a stored procedure
    $sql = "EXEC SpConsultarCadastro :UsuarioCpf, :UsuarioEmail";
    
    // Prepara a consulta SQL usando PDO
    $stmt = $conexao->prepare($sql);
    
    // Binding dos parâmetros
    $stmt->bindParam(':UsuarioCpf', $cpf, PDO::PARAM_STR);
    $stmt->bindParam(':UsuarioEmail', $email, PDO::PARAM_STR);
    
    // Executa a stored procedure   
    $stmt->execute();
    
    // Recupera os valores de erro da stored procedure
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verifica se houve erro de CPF ou e-mail duplicado
    if ($result['cpfErrorMessage']) {
        $_SESSION['cpf-error'] = $result['cpfErrorMessage'];
        header('Location: ../../frontend/html/cadastro-inicial.php');
        exit();
    }

    if ($result['emailErrorMessage']) {
        $_SESSION['email-error'] = $result['emailErrorMessage'];
        header('Location: ../../frontend/html/cadastro-inicial.php');
        exit();
    }

    // Se não houver erro, continua para o próximo passo
    header('Location: ../../frontend/html/tipo-usuario.php');
    exit();

} catch (Exception $e) {
    // Em caso de erro, exibe mensagem e redireciona
    error_log("Erro no cadastro: " . $e->getMessage());
    echo '<script>alert("Ocorreu um erro no sistema. Por favor, tente novamente mais tarde.");</script>';
    echo '<script>window.location.href = "../../frontend/html/cadastro-inicial.php";</script>';
    exit();
}

?>
