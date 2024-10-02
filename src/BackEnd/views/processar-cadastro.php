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
    die("Erro na conexão com o banco: " . print_r(sqlsrv_errors(), true));
} else {
    echo "Conexão bem-sucedida!";
}

// Inicia a sessão para captura de dados salvos na sessão
session_start();

// Captura os dados salvos na sessão
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['nome'], $_SESSION['sobrenome'], $_SESSION['email'], $_SESSION['senha'])) {
        $nome = $_SESSION['nome'];
        $sobrenome = $_SESSION['sobrenome'];
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
        } else {
            // Tente obter a linha e o valor da SenhaId
            if (sqlsrv_fetch($resultGetSenhaId)) {
                $senhaId = sqlsrv_get_field($resultGetSenhaId, 0); // Obtém o primeiro campo, que é o SenhaId
            } else {
                die("Erro ao recuperar o ID da senha. Nenhum resultado foi retornado.");
            }
        }

        // Verifica se o ID da senha foi recuperado corretamente
        if ($senhaId === null) {
            die("Erro ao recuperar o ID da senha.");
        }

        // Cria a inserção de novo registro na tabela usuário
        $sqlUsuario = "INSERT INTO TbUsuario (UsuarioEmail, SenhaId, UsuarioTipo, UsuarioNome, UsuarioSobrenome, UsuarioDataCad) VALUES (?, ?, ?, ?, ?, GETDATE())";
        $parametroUsuario = array($email, $senhaId, $usuarioTipo, $nome, $sobrenome);
        $resultadoSetUsuario = sqlsrv_query($conexao, $sqlUsuario, $parametroUsuario);

        // Verifica se a inserção do usuário foi bem-sucedida
        if ($resultadoSetUsuario === false) {
            die("Erro na inserção do usuário: " . print_r(sqlsrv_errors(), true));
        }

        // Redireciona baseado no tipo de usuário
        if ($usuarioTipo === "M") {
            header("Location: ../../frontEnd/html/home-musico.html");
        } elseif ($usuarioTipo === "C") {
            header("Location: ../../frontEnd/html/home-contratante.html");
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
