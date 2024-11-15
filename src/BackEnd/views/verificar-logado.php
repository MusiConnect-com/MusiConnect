<?php
    session_start();

    try {
        if (isset($_SESSION['UsuarioId'], $_SESSION['UsuarioTipo'], $_SESSION['UsuarioNome'], $_SESSION['UsuarioSobrenome'])) {

            include '../../BackEnd/views/conexao.php';

            $UsuarioId = $_SESSION['UsuarioId'];
            // Consulta SQL
            $stmt = $conexao->prepare("SELECT UsuarioId FROM TbUsuario WHERE UsuarioId = :UsuarioId");

            $stmt->bindParam(':UsuarioId', $UsuarioId, PDO::PARAM_INT);
            $stmt->execute();

            if (!$stmt->fetch(PDO::FETCH_NUM)) {
                header('Location: ../../BackEnd/views/logout.php');
                exit();
            } 

            $stmt->closeCursor();
        } else {
            header('Location: ../../BackEnd/views/logout.php');
            exit();
        }
    } catch (Exception $e) {
        // Exibe a mensagem de erro e redireciona para logout
        error_log("Erro ao verificar usuário logado : " . $e->getMessage());
        echo '<script>alert("Ocorreu um erro no sistema e perdemos sua conexão, faça login novamente por favor.");</script>';
        header('Location: ../../BackEnd/views/logout.php');
        exit();
    }
?>
