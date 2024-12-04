<?php

    include '../../BackEnd/views/conexao.php';
    session_start();

    try {
        if (!$conexao) {
            throw new Exception("Erro ao conectar ao banco de dados.");
        }

        // Verificando se há múltiplos arquivos
        if (isset($_FILES['fotos']) && is_array($_FILES['fotos']['name'])) {
            if (!isset($_POST['id'])) {
                throw new Exception("id do usuário não enviado");
            }
            $usuarioId = $_POST['id'];
            $fotos = $_FILES['fotos']; // Será um array de arquivos
            foreach ($fotos['tmp_name'] as $index => $tmpName) {
                // Processar cada foto individualmente
                $fotoNome = $fotos['name'][$index];
                $fotoTamanho = $fotos['size'][$index];
                $pastaUpload = "../../FrontEnd/upload/";
                $nomeUniqFoto = uniqid();
                $extensaoFoto = strtolower(pathinfo($fotoNome, PATHINFO_EXTENSION));
                $fotoCaminho = $pastaUpload . $nomeUniqFoto . "." . $extensaoFoto;
                
                $uploadConcluido = move_uploaded_file($tmpName, $fotoCaminho);
                if (!$uploadConcluido) {
                    throw new Exception('Foto não movida com sucesso');
                }

                $stmt = $conexao->prepare("
                    EXEC SpInserirFotoGaleria
                    @UsuarioId = :usuarioId,
                    @FotoNome = :fotoNome,
                    @FotoCaminho = :fotoCaminho,
                    @FotoTamanho = :fotoTamanho"
                );

                $stmt->bindParam(':usuarioId', $usuarioId);
                $stmt->bindParam(':fotoNome', $fotoNome);
                $stmt->bindParam(':fotoCaminho', $fotoCaminho);
                $stmt->bindParam(':fotoTamanho', $fotoTamanho);

                if (!$stmt->execute()) {
                    throw new Exception('Erro ao inserir no banco');
                }
            }
        }

        header("Location: ../../FrontEnd/html/upload-foto.php?status=sucesso");

    } catch (Exception $e) {
        error_log("Erro ao inserir cadastro: " . $e->getMessage());
        echo '<script>
            alert("Ocorreu um erro inesperado. Tente novamente.");
            window.location.href = "../../FrontEnd/html/upload-foto.php?status=erro";
            </script>';
        exit();
    }
?>
