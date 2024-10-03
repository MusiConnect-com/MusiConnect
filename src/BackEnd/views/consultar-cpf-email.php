<?php
include './conexao.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['UsuarioNome'] = $_POST['nome'];
    $_SESSION['UsuarioSobrenome'] = $_POST['sobrenome'];
    $_SESSION['UsuarioCpf'] = $_POST['cpf'];
    $_SESSION['UsuarioEmail'] = $_POST['email'];
    $_SESSION['UsuarioSenha'] = $_POST['senha'];
}

// Verifica se o CPF ou e-mail já existe
$sqlSelectCpfEmail = "SELECT UsuarioCpf, UsuarioEmail FROM TbUsuario WHERE UsuarioCpf = ? OR UsuarioEmail = ?";
$parametros = array($_SESSION['UsuarioCpf'], $_SESSION['UsuarioEmail']);
$resultCpfEmail = sqlsrv_query($conexao, $sqlSelectCpfEmail, $parametros);

if ($resultCpfEmail === false) {
    die(print_r(sqlsrv_errors(), true));
} 
else {
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
} 
elseif (!$cpfCadastrado && !$emailCadastrado) {
    header('Location: ../../frontend/html/tipo-usuario.php');
    exit();
}

?>