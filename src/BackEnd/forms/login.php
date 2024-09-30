<?php

$servername = "João\SQLEXPRESS"; // Nome do servidor
$dbname = "DbMusicConnect"; // Nome do banco de dados
$username = "joao"; // Nome de usuário
$password = "Jo121218vi!"; // Senha

// Cria a conexão
$conn = sqlsrv_connect($servername, array(
    "Database" => $dbname,
    "UID" => $username,
    "PWD" => $password,
));

// Verifique a conexão
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Inicia a sessão
session_start();

// Captura os dados do formulário
$email = $_POST['email'];
$password = $_POST['password'];

// Cria a consulta SQL
$sql = "SELECT * FROM TbUsuario WHERE UsuarioEmail = ? AND SenhaId = (SELECT SenhaId FROM TbSenha WHERE SenhaHash = ?)";
$params = array($email, $password);
$result = sqlsrv_query($conn, $sql, $params);

// Verifica se o usuário existe
if ($result && sqlsrv_has_rows($result)) {
    // Obtém os dados do usuário
    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

    // Armazena o nome e sobrenome do usuário na sessão
    $_SESSION['usuario_nome'] = $row['UsuarioNome'];
    $_SESSION['usuario_sobrenome'] = $row['UsuarioSobrenome']; // Supondo que essa coluna exista

    // Redireciona para a página home
    header("Location: ../../frontend/html/teste.php");
    exit();
} else {
    // Usuário não encontrado
    echo "Usuário ou senha inválidos.";
}

// Fecha a conexão
sqlsrv_free_stmt($result);
sqlsrv_close($conn);
?>
