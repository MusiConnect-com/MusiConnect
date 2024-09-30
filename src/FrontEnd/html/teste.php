<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_nome'])) {
    // Redireciona para a página de login se não estiver logado
    header("Location: ../html/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo</title>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']) . ' ' . htmlspecialchars($_SESSION['usuario_sobrenome']); ?>!</h1>
    <!-- O resto do conteúdo da página -->
</body>
</html>
