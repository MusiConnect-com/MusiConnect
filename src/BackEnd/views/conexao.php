<?php
// Dados para conexão no banco
$serverNome = 'JOAO\SQLEXPRESS';
$dbNome = 'DbMusicConnect';
$usuaNome = 'João';
$senha = 'Jo121218vi!';

// Cria a conexão com o banco
$conexao = sqlsrv_connect($serverNome, array(
    'Database' => $dbNome,
    'UID' => $usuaNome,
    'PWD' => $senha,
    "CharacterSet" => "UTF-8"
));

// Verifica a conexão
if ($conexao === false) {
    die("Erro na conexão com o banco: " . print_r(sqlsrv_errors(), true));
}