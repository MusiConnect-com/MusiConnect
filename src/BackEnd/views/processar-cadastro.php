<?php

include './conexao.php';

session_start();

// Captura os dados salvos na sessão
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['UsuarioNome'], $_SESSION['UsuarioSobrenome'],$_SESSION['UsuarioCpf'], $_SESSION['UsuarioEmail'], $_SESSION['UsuarioSenha'])) {
        $nome = $_SESSION['UsuarioNome'];
        $sobrenome = $_SESSION['UsuarioSobrenome'];
        $cpf = $_SESSION['UsuarioCpf'];
        $email = $_SESSION['UsuarioEmail'];
        $senha = $_SESSION['UsuarioSenha'];
        $hash = password_hash($senha, PASSWORD_BCRYPT);
        $usuarioTipo = $_POST['tipo-usuario'];

        // Cria a inserção de novo registro na tabela usuário
        $sqlUsuario = "INSERT INTO TbUsuario (UsuarioCpf, UsuarioEmail, UsuarioTipo, UsuarioNome, UsuarioSobrenome, UsuarioDataCad) VALUES (?, ?, ?, ?, ?, GETDATE())";
        $parametroUsuario = array($cpf, $email, $usuarioTipo, $nome, $sobrenome);
        $resultSetUsuario = sqlsrv_query($conexao, $sqlUsuario, $parametroUsuario);

        // Verifica se a inserção do usuário foi bem-sucedida
        if ($resultSetUsuario === false) {
            $errorMessage = print_r(sqlsrv_errors(), true);
            echo "<script>
                    alert('Erro na inserção do usuário: $errorMessage');
                    window.location.href = '../../frontend/html/cadastro-inicial.php';
                </script>";
            exit();
        }

        // Capturando o UsuarioId gerado
        $sqlGetUsuarioId = "SELECT UsuarioId FROM TbUsuario WHERE UsuarioCpf = ? AND UsuarioEmail = ?";
        $parametroGetUsuarioId = array($cpf, $email);
        $resultGetUsuarioId = sqlsrv_query($conexao, $sqlGetUsuarioId, $parametroGetUsuarioId);

        if ($resultGetUsuarioId === false) {
            $errorMessage = print_r(sqlsrv_errors(), true);
            echo "<script>
                    alert('Erro ao recuperar o ID do usuario: $errorMessage');
                    window.location.href = '../../frontend/html/cadastro-inicial.php';
                </script>";
            exit();
        } 

        // Tente obter a linha e o valor da SenhaId
        if (sqlsrv_fetch($resultGetUsuarioId)) {
            $usuarioId = sqlsrv_get_field($resultGetUsuarioId, 0);
        } else {
            $errorMessage = print_r(sqlsrv_errors(), true);
            echo "<script>
                    alert('Erro ao recuperar o ID do usuario. Nenhum resultado foi retornado : $errorMessage');
                    window.location.href = '../../frontend/html/cadastro-inicial.php';
                </script>";
            exit();
        }

        // Verifica se o ID da senha foi recuperado corretamente
        if ($usuarioId === null) {
            $errorMessage = print_r(sqlsrv_errors(), true);
            echo "<script>
                    alert('UsuarioId é null: $errorMessage');
                    window.location.href = '../../frontend/html/cadastro-inicial.php';
                </script>";
            exit();
        }

        // Cria a inserção de novo registro na tabela senha
        $sqlSenha = "INSERT INTO TbSenha (UsuarioId, SenhaHash, SenhaDataAlt, SenhaStatus) VALUES (?, ?, GETDATE(), ?)";
        $parametroSenha = array($usuarioId, $hash, 1);
        $resultadoSetSenha = sqlsrv_query($conexao, $sqlSenha, $parametroSenha);

        // Verifica se a inserção da senha foi bem-sucedida
        if ($resultadoSetSenha === false) {
            $errorMessage = print_r(sqlsrv_errors(), true);
            echo "<script>
                    alert('Erro na inserção da senha: $errorMessage');
                    window.location.href = '../../frontend/html/cadastro-inicial.php';
                </script>";
            exit();
        }

        // Redireciona baseado no tipo de usuário
        if ($usuarioTipo === "M") {
            header("Location: ../../frontend/html/home-musico.php");
            exit();
        } 
        elseif ($usuarioTipo === "C") {
            header("Location: ../../frontend/html/home-contratante.php");
            exit();
        }

        $_SESSION['UsuarioId'] = $usuarioId;
        $_SESSION['UsuarioTipo'] = $usuarioTipo;
        unset($_SESSION['UsuarioSenha']);
        unset($_SESSION['UsuarioEmail']);
        unset($_SESSION['UsuarioCpf']);


        // Libera os resultados
        sqlsrv_free_stmt($resultadoSetSenha);
        sqlsrv_free_stmt($resultadoSetUsuario);
        sqlsrv_free_stmt($resultGetSenhaId);
    } else {
        echo "<script>
                alert('Algo deu errado, preencha o formulário novamente');
                window.location.href = '../../frontend/html/cadastro-inicial.php';
            </script>";
        exit();
    }
}

// Fecha a conexão
sqlsrv_close($conexao);
?>
