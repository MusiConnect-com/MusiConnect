<?php

    include './conexao.php';

    if (isset($_GET['id'])) {
        $anuncioId = $_GET['id'];

        try {

            $stts = 'ATIVO';

            $stmt = $conexao->prepare('UPDATE TbAnuncio SET AnuncioStatus = :stts WHERE AnuncioId = :anuncioId');
            $stmt->bindParam('stts', $stts);
            $stmt->bindParam(':anuncioId', $anuncioId);

            if (!$stmt->execute()) {
                throw new Exception('Não foi possivel ativar o anuncio');
            }

            header('Location: ../../FrontEnd/html/meus-anuncios.php');

        } catch (Exception $e) {
            error_log("Erro ao ativar o anuncio: " . $e->getMessage());
            echo '<script>alert("Ocorreu um erro inesperado. Tente novamente.");</script>';
            header('Location: ../../FrontEnd/html/meus-anuncios.php');
            exit();
        }
    } else {
        echo '<script>alert("Perdemos o anúncio escolhido, escolha-o novamente");</script>';
        header('Location: ../../FrontEnd/html/meus-anuncios.php');
        exit();
    }
?>