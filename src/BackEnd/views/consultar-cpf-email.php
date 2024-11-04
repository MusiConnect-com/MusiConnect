<?php
include './conexao.php';

ini_set('log_errors', 1); // Ativa o registro de erros no arquivo de log.
ini_set('error_log', 'C:\Tools\php-8.3.12\error\php_errors.log'); //Define o caminho onde os erros serão salvos.

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
    $sqlSelectCpfEmail = "SELECT UsuarioCpf, UsuarioEmail FROM TbUsuario WHERE UsuarioCpf = ? OR UsuarioEmail = ?";
    $parametros = array($_SESSION['UsuarioCpf'], $_SESSION['UsuarioEmail']);
    $resultCpfEmail = sqlsrv_query($conexao, $sqlSelectCpfEmail, $parametros);

    if ($resultCpfEmail === false) {
        throw new Exception("Erro ao executar a consulta de verificação de CPF/E-mail: " . print_r(sqlsrv_errors(), true));
    } else {
        $cpfCadastrado = false;
        $emailCadastrado = false;
        while ($linhaAtual = sqlsrv_fetch_array($resultCpfEmail, SQLSRV_FETCH_ASSOC)) {
            if ($linhaAtual['UsuarioCpf'] === $_SESSION['UsuarioCpf']) {
                $_SESSION['cpf-error'] = 'CPF já cadastrado.';
                $cpfCadastrado = true;
                break;
            }
            if ($linhaAtual['UsuarioEmail'] === $_SESSION['UsuarioEmail']) {
                $_SESSION['email-error'] = 'Email já cadastrado';
                $emailCadastrado = true;
                break;
            }
        }
    }

    if ($cpfCadastrado || $emailCadastrado) {
        header('Location: ../../frontend/html/cadastro-inicial.php');
        exit();
    } else if (!$cpfCadastrado && !$emailCadastrado) {
        header('Location: ../../frontend/html/tipo-usuario.php');
        exit();
    }

} catch (Exception $e) {
    error_log("Erro no cadastro: " . $e->getMessage());
    echo '<script>alert("Ocorreu um erro no sistema. Por favor, tente novamente mais tarde.");</script>';
    echo '<script>window.location.href = "../../frontend/html/cadastro-inicial.php";</script>';
    exit();
}
?>
