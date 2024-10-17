<?php

include './conexao.php';

session_start();

// Captura os dados do formulário
$email = $_POST['email'];
$senha = $_POST['password'];

// Cria a consulta SQL
$sqlGetUsuario = "SELECT u.UsuarioId, u.UsuarioNome, u.UsuarioSobrenome, u.UsuarioTipo, s.SenhaHash, SenhaStatus FROM TbUsuario u INNER JOIN TbSenha s ON u.UsuarioId = s.UsuarioId WHERE u.UsuarioEmail = ?";
$parametro = array($email);
$resultadoGetUsuario = sqlsrv_query($conexao, $sqlGetUsuario, $parametro);

// Verifica se o usuário existe
if ($resultadoGetUsuario && sqlsrv_has_rows($resultadoGetUsuario)) {
    // Obtém os dados do usuário
    $listaResultado = sqlsrv_fetch_array($resultadoGetUsuario, SQLSRV_FETCH_ASSOC);

    if ($listaResultado['SenhaStatus'] === 0) {
        $_SESSION['login-error'] = 'Senha inativa, tente outra';
    } 
    elseif ($listaResultado['SenhaStatus'] === 1) {
        // verifica a senha hash
        if (password_verify($senha, $listaResultado['SenhaHash'])) {

            //salva os dados em sessões
            $_SESSION['UsuarioId'] = $listaResultado['UsuarioId'];
            $_SESSION['UsuarioTipo'] = $listaResultado['UsuarioTipo'];
            $_SESSION['UsuarioNome'] = $listaResultado['UsuarioNome'];
            $_SESSION['UsuarioSobrenome'] = $listaResultado['UsuarioSobrenome'];

            // validando o tipo de usuário
            if ($listaResultado['UsuarioTipo'] === 'M') {
                header("Location: ../../frontend/html/home-musico.php");
                exit();
            }
            elseif ($listaResultado['UsuarioTipo'] === 'C') {
                header("Location: ../../frontend/html/home-contratante.php");
                exit();
            }
        }
        else {
            $_SESSION['login-error'] = 'Senha incorreta';
        }
    }
} 
else {
    $_SESSION['login-error'] = 'Email não cadastrado';
}

if (!empty($_SESSION['login-error'])){
    header("Location: ../../frontend/html/login.php");
    exit();
}

// Fecha a conexão
sqlsrv_free_stmt($resultadoGetUsuario);
sqlsrv_close($conexao);
?>