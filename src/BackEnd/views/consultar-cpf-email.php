<?php
include '../../backend/views/conexao.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['nome'] = $_POST['nome'];
    $_SESSION['sobrenome'] = $_POST['sobrenome'];
    $_SESSION['cpf'] = $_POST['cpf'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['senha'] = $_POST['senha'];
}

// Verifica se o CPF ou e-mail já existe
$sqlSelectCpfEmail = "SELECT UsuarioCpf, UsuarioEmail FROM TbUsuario WHERE UsuarioCpf = ? OR UsuarioEmail = ?";
$parametros = array($_SESSION['cpf'], $_SESSION['email']);
$resultCpfEmail = sqlsrv_query($conexao, $sqlSelectCpfEmail, $parametros);

if ($resultCpfEmail === false) {
    die(print_r(sqlsrv_errors(), true));
} 
else {
    while ($linhaAtual = sqlsrv_fetch_array($resultCpfEmail, SQLSRV_FETCH_ASSOC)) {
        if ($linhaAtual['UsuarioCpf'] === $_SESSION['cpf']) {
            $_SESSION['cpf-error'] = 'CPF já cadastrado.';
        }
        if ($linhaAtual['UsuarioEmail'] === $_SESSION['email']) {
            $_SESSION['email-error'] = 'Email já cadastrado';
        }
    }
}

if (empty($_SESSION['cpf-error']) || empty($_SESSION['email-error'])) {
    header('Location: ../../frontend/html/tipo-usuario.php');
    exit();
} 
elseif (!empty($_SESSION['cpf-error']) && !empty($_SESSION['email-error'])) {
    header('Location: ../../frontend/html/cadastro-inicial.php');
    exit();
}

?>