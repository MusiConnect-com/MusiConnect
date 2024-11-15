<?php
// Dados para conexão no banco
$serverNome = 'JOAO\SQLEXPRESS';
$dbNome = 'DbMusicConnect';
$usuaNome = 'João';
$senha = 'Jo121218vi!';
$dsn = "sqlsrv:Server=$serverNome;Database=$dbNome";
//Data Source Name, string de conexão
// parametros : nome do driver:Nome do servidor;Nome do banco de dados; Porta (opcional)

try {
    $conexao = new PDO($dsn, $usuaNome, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // definindo o modo de erro como exception
} catch (PDOException $e) {
    error_log("Erro na conexão: " . $e->getMessage());
    echo '<script>Console.log("Erro na conexão, tente novamente.");</script>';
    header('Location: ../../BackEnd/views/logout.php');
    exit();
}