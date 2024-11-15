<?php

include '../../BackEnd/views/conexao.php';

session_start();

try {
    $email = $_POST['email'];
    $senha = $_POST['password'];
    // Cria a consulta SQL
    $sqlGetUsuario = "SELECT u.UsuarioId, u.UsuarioNome, u.UsuarioSobrenome, u.UsuarioTipo, s.SenhaHash, s.SenhaStatus 
                      FROM TbUsuario u 
                      INNER JOIN TbSenha s ON u.UsuarioId = s.UsuarioId 
                      WHERE u.UsuarioEmail = :email";

    // Preparação e execução da consulta
    $stmt = $conexao->prepare($sqlGetUsuario);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    

    $listaResultado = $stmt->fetch(PDO::FETCH_ASSOC);
    // Verifica se o usuário existe
    if ($listaResultado) {
        // Obtém os dados do usuário
        if ($listaResultado['SenhaStatus'] == 0) {
            $_SESSION['login-error'] = 'Senha inativa, entre em contato com o suporte';
        } else if ($listaResultado['SenhaStatus'] == 1) {
            // Verifica a senha hash
            if (password_verify($senha, $listaResultado['SenhaHash'])) {
                // Salva os dados em sessões
                $_SESSION['UsuarioId'] = $listaResultado['UsuarioId'];
                $_SESSION['UsuarioTipo'] = $listaResultado['UsuarioTipo'];
                $_SESSION['UsuarioNome'] = $listaResultado['UsuarioNome'];
                $_SESSION['UsuarioSobrenome'] = $listaResultado['UsuarioSobrenome'];

                // Valida o tipo de usuário
                if ($listaResultado['UsuarioTipo'] === 'M') {
                    header('Location: ../../FrontEnd/html/home-musico.php');
                    echo '<script>window.location.href = "../../FrontEnd/html/home-musico.php";</script>';
                    exit();
                } else if ($listaResultado['UsuarioTipo'] === 'C') {
                    header('Location: ../../frontend/html/home-contratante.php');
                    exit();
                }
            } else {
                $_SESSION['login-error'] = 'Senha incorreta';
            }
        }
    } else {
        $_SESSION['login-error'] = 'Email não cadastrado';
    }
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}

// Redireciona para a página de login em caso de erro
if (!empty($_SESSION['login-error'])) {
    header('Location: ../../frontend/html/login.php');
    exit();
}
?>