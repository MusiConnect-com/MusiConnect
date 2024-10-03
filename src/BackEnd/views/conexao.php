<?php
// Dados para conexão no banco
$serverNome = 'DESKTOP-N30O7C6\SQLEXPRESS';
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
    die("Erro na conexão com o banco: " . print_r(sqlsrv_errors(), true));
}