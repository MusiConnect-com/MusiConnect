<?php

// Dados para conexão no banco
$serverNome = 'João\SQLEXPRESS';
$dbNome = 'DbMusicConnect';
$usuaNome = 'joao';
$senha = 'Jo121218vi!';

// Cria a conexão com o banco
$conexao = sqlsrv_connect($serverNome, array(
    'Database' => $dbNome,
    'UID' => $usuaNome,
    'PWD' => $senha
));

// Verifica a conexão
if ($conexao === false) {
    die(print_r(sqlsrv_errors(), true));
}

//inicia a sessão para captura de dados como nome
session_start();

// Captura os dados do formulário
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$email = $_POST['email'];
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_BCRYPT);

// Cria a inserção de novo registro na tabela senha
$sqlSenha = "INSERT INTO TbSenha (SenhaHash, SenhaDataAlt, SenhaStatus) VALUES ('?', GETDATE(), '?')";
$parametroSenha = array($hash, '1');
sqlsrv_query($conexao, $sqlSenha, $parametroSenha);

// Capturando a SenhaId gerado 
$sqlGetSenhaId = "SELECT SCOPE_IDENTITY() AS NovoSenhaId";
$resultGetSenhaId = sqlsrv_query($conexao, $sqlGetSenhaId);
$ow = sqlsrv_fetch_array($resultGetSenhaId);
$senhaId = $row['NovoSenhaId'];

// Cria a inserção de novo registro na tabela usuário
$sqlUsuario = "INSERT INTO TbUsuario (UsuarioEmail, SenhaId, UsuarioTipo, UsuarioNome
    UsuarioSobrenome, UsuarioDataCad) VALUES (?, ?, ?, ?, ?, GETDATE())";
$parametroUsuario = array($email, $senhaId, $usuarioTipo, $nome, $sobrenome);
$sqlsrv_query($conexao, $sqlUsuario, $parametroUsuario);


//Fehca a conexão
sqlsrv_free_stmt($resultGetSenhaId);
sqlsrv_close($conexao);
?>