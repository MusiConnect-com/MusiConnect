<?php

// Dados para conexão no banco
$servernome = 'João\SQLEXPRESS';
$dbnome = 'DbMusicConnect';
$usuanome = 'joao';
$senha = 'Jo121218vi!';

// cria a conexão com o banco
$conexao = sqlsrv_connect($servernome, array(
    "Database" => $dbnome,
    "UID" => $usuanome,
    "PWD" => $senha
));

// Verifica a conexão
if ($conexao === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Inicia a sessão
session_start();

// Captura os dados do formulário
$email = $_POST['email'];
$password = $_POST['password'];

// Cria a consulta SQL
$sql = "SELECT * FROM TbUsuario WHERE UsuarioEmail = ? AND SenhaId = (SELECT SenhaId FROM TbSenha WHERE SenhaHash = ?)";
$parametro = array($email, $password);
$resultado = sqlsrv_query($conexao, $sql, $parametro);

// Verifica se o usuário existe
if ($resultado && sqlsrv_has_rows($resultado)) {
    // Obtém os dados do usuário
    $row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);

    // Armazena o nome e sobrenome do usuário na sessão
    $_SESSION['UsuarioNome'] = $row['UsuarioNome'];
    $_SESSION['UsuarioSobrenome'] = $row['UsuarioSobrenome'];

    header("Location: ../../frontend/html/teste.php");
    exit();
} else {
    echo "Usuário ou senha inválidos.";
}

// Fecha a conexão
sqlsrv_free_stmt($result);
sqlsrv_close($conn);
?>
