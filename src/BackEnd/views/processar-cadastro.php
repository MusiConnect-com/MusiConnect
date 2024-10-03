<?php

include '../../backend/views/conexao.php';

session_start();

// Captura os dados salvos na sessão
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['nome'], $_SESSION['sobrenome'],$_SESSION['cpf'], $_SESSION['email'], $_SESSION['senha'])) {
        $nome = $_SESSION['nome'];
        $sobrenome = $_SESSION['sobrenome'];
        $cpf = $_SESSION['cpf'];
        $email = $_SESSION['email'];
        $senha = $_SESSION['senha'];
        $hash = password_hash($senha, PASSWORD_BCRYPT);
        $usuarioTipo = $_POST['tipo-usuario'];

        // Cria a inserção de novo registro na tabela senha
        $sqlSenha = "INSERT INTO TbSenha (SenhaHash, SenhaDataAlt, SenhaStatus) VALUES (?, GETDATE(), ?)";
        $parametroSenha = array($hash, '1');
        $resultadoSetSenha = sqlsrv_query($conexao, $sqlSenha, $parametroSenha);

        // Verifica se a inserção da senha foi bem-sucedida
        if ($resultadoSetSenha === false) {
            die("Erro na inserção da senha: " . print_r(sqlsrv_errors(), true));
        }

        // Capturando a SenhaId gerada 
        $sqlGetSenhaId = "SELECT SenhaId FROM TbSenha WHERE SenhaHash = ?";
        $parametroGetSenhaId = array($hash);
        $resultGetSenhaId = sqlsrv_query($conexao, $sqlGetSenhaId, $parametroGetSenhaId);

        if ($resultGetSenhaId === false) {
            die("Erro ao recuperar o ID da senha: " . print_r(sqlsrv_errors(), true));
        } 

        // Tente obter a linha e o valor da SenhaId
        if (sqlsrv_fetch($resultGetSenhaId)) {
            $senhaId = sqlsrv_get_field($resultGetSenhaId, 0);
        } else {
            die("Erro ao recuperar o ID da senha. Nenhum resultado foi retornado.");
        }

        // Verifica se o ID da senha foi recuperado corretamente
        if ($senhaId === null) {
            die("SenhaId é null.");
        }

        // Cria a inserção de novo registro na tabela usuário
        $sqlUsuario = "INSERT INTO TbUsuario (UsuarioCpf, UsuarioEmail, SenhaId, UsuarioTipo, UsuarioNome, UsuarioSobrenome, UsuarioDataCad) VALUES (?, ?, ?, ?, ?, ?, GETDATE())";
        $parametroUsuario = array($cpf, $email, $senhaId, $usuarioTipo, $nome, $sobrenome);
        $resultadoSetUsuario = sqlsrv_query($conexao, $sqlUsuario, $parametroUsuario);

        // Verifica se a inserção do usuário foi bem-sucedida
        if ($resultadoSetUsuario === false) {
            die("Erro na inserção do usuário: " . print_r(sqlsrv_errors(), true));
        }

        // Redireciona baseado no tipo de usuário
        if ($usuarioTipo === "M") {
            header("Location: ../../frontend/html/home-musico.html");
            exit();
        } elseif ($usuarioTipo === "C") {
            header("Location: ../../frontend/html/home-contratante.html");
            exit();
        }

        // Libera os resultados
        sqlsrv_free_stmt($resultadoSetSenha);
        sqlsrv_free_stmt($resultadoSetUsuario);
        sqlsrv_free_stmt($resultGetSenhaId);
    } else {
        die("Dados da sessão não estão definidos.");
    }
}

// Fecha a conexão
sqlsrv_close($conexao);
?>
