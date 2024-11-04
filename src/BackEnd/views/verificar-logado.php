<?php
    session_start();

    try {
        if (isset($_SESSION['UsuarioId'], $_SESSION['UsuarioTipo'], $_SESSION['UsuarioNome'], $_SESSION['UsuarioSobrenome'])) {

            include '../../BackEnd/views/conexao.php';

            // Consulta SQL
            $sqlGetUsuario = "SELECT UsuarioId FROM TbUsuario WHERE UsuarioId = ?";
            $parametro = array($_SESSION['UsuarioId']);
            $resultadoGetUsuario = sqlsrv_query($conexao, $sqlGetUsuario, $parametro);

            if ($resultadoGetUsuario === false) {
                throw new Exception("Erro na consulta SQL: " . print_r(sqlsrv_errors(), true));
            }

            // Fechar conexão (opcional)
            sqlsrv_close($conexao);
        } else {
            header('Location: ../../BackEnd/views/logout.php');
            exit();
        }
    } catch (Exception $e) {
        // Exibe a mensagem de erro e redireciona para logout
        error_log("Erro encontrado: " . $e->getMessage());
        header('Location: ../../BackEnd/views/logout.php');
        exit();
    }

?>
