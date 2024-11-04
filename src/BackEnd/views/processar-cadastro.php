<?php

    include './conexao.php';

    ini_set('log_errors', 1);
    ini_set('error_log', 'C:\Tools\php-8.3.12\error\php_errors.log');

    session_start();

try {
    // Captura os dados salvos na sessão
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION['UsuarioNome'], $_SESSION['UsuarioSobrenome'], $_SESSION['UsuarioCpf'], $_SESSION['UsuarioEmail'], $_SESSION['UsuarioSenha'])) {
            $nome = $_SESSION['UsuarioNome'];
            $sobrenome = $_SESSION['UsuarioSobrenome'];
            $cpf = $_SESSION['UsuarioCpf'];
            $email = $_SESSION['UsuarioEmail'];
            $senha = $_SESSION['UsuarioSenha'];
            $hash = password_hash($senha, PASSWORD_BCRYPT);
            $usuarioTipo = strtoupper($_POST['tipo-usuario']);
            $_SESSION['UsuarioTipo'] = $usuarioTipo;
            $foto = $_FILES['profile-picture'];
            $dataNascimento = date('Y-m-d', strtotime($_POST['date-birth']));
            $sexo = $_POST['sex'];
            $telefone = $_POST['phone'];
            $cidade = $_POST['cidade'];
            $logradouro = $_POST['logradouro'];
            $numero = $_POST['numero'];
            $complemento = $_POST['complemento'];
            $bairro = $_POST['bairro'];
            $cep = str_replace('-', '', $_POST['cep']);
            $habilidadeId = $_POST['skill'];
            $generoMusicalId = $_POST['genre-music'];
            $descricao = $_POST['description'] ?? null;
            $valorServico = $_POST['service-value'] ?? null;~

            $sqlGetUltimoEnderecoId = "SELECT TOP 1 MAX(EnderecoId) AS UltimoEnderecoId FROM TbEndereco;";
            $resultGetUltimoEnderecoId = sqlsrv_query($conexao, $sqlGetUltimoEnderecoId);

            if (!$resultGetUltimoEnderecoId) {
                error_log(print_r(sqlsrv_errors(), true));
                throw new Exception("Erro para pegar o último endereço antes de inserir.");

            } else if (sqlsrv_fetch($resultGetUltimoEnderecoId)) {
                $ultimoEnderecoId = sqlsrv_get_field($resultGetUltimoEnderecoId, 0);
            }

            // Código para inserir endereço
            $sqlEndereco = "INSERT INTO TbEndereco (EnderecoLogra, EnderecoNum, EnderecoComp, EnderecoBai, EnderecoCep, CidadeId) VALUES (?, ?, ?, ?, ?, ?);";
            $parametroEndereco = array($logradouro, $numero, $complemento, $bairro, $cep, $cidade);
            $resultSetEndereco = sqlsrv_query($conexao, $sqlEndereco, $parametroEndereco);

            if (!$resultSetEndereco) {
                error_log(print_r(sqlsrv_errors(), true));
                throw new Exception("Erro para inserir o endereço.");
            }

            // Recupera o ID do endereço
            $sqlGetEnderecoId = "SELECT TOP 1 MAX(EnderecoId) AS UltimoEnderecoId FROM TbEndereco;";
            $resultGetEnderecoId = sqlsrv_query($conexao, $sqlGetEnderecoId);

            if (!$resultGetEnderecoId) {
                error_log(print_r(sqlsrv_errors(), true));
                throw new Exception("Erro para pegar o EnderecoId atual.");

            } else if (sqlsrv_fetch($resultGetEnderecoId)) {
                $enderecoId = sqlsrv_get_field($resultGetEnderecoId, 0);
            }

            if ($enderecoId != ($ultimoEnderecoId + 1)) {
                error_log(print_r(sqlsrv_errors(), true));
                throw new Exception("EnderecoId não é o atual.");
            }

            // Código para inserir usuário
            $sqlUsuario = "INSERT INTO TbUsuario (UsuarioCpf, UsuarioEmail, UsuarioTipo, UsuarioNome, UsuarioSobrenome, UsuarioDataNasc, UsuarioSexo, EnderecoId) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
            $parametroUsuario = array($cpf, $email, $usuarioTipo, $nome, $sobrenome, $dataNascimento, $sexo, $enderecoId);
            $resultSetUsuario = sqlsrv_query($conexao, $sqlUsuario, $parametroUsuario);

            if (!$resultSetUsuario) {
                error_log(print_r(sqlsrv_errors(), true));
                throw new Exception("Erro para inserir usuário.");
            }

            // Recupera o ID do usuário
            // Capturando o UsuarioId gerado
            $sqlGetUsuarioId = "SELECT UsuarioId FROM TbUsuario WHERE UsuarioCpf = ? AND UsuarioEmail = ?";
            $parametroGetUsuarioId = array($cpf, $email);
            $resultGetUsuarioId = sqlsrv_query($conexao, $sqlGetUsuarioId, $parametroGetUsuarioId);

            if (!$resultGetUsuarioId) {
                error_log(print_r(sqlsrv_errors(), true));
                throw new Exception("Erro para pegar o UsuarioId.");

            } else if (sqlsrv_fetch($resultGetUsuarioId)) {
                $usuarioId = sqlsrv_get_field($resultGetUsuarioId, 0);
                $_SESSION['UsuarioId'] = $usuarioId;
            }

            if ($usuarioId === null) {
                error_log(print_r(sqlsrv_errors(), true));
                throw new Exception("UsuarioId é null.");
            }

            // Código para inserir senha
            $sqlSenha = "INSERT INTO TbSenha (UsuarioId, SenhaHash) VALUES (?, ?)";
            $parametroSenha = array($usuarioId, $hash);
            $resultSetSenha = sqlsrv_query($conexao, $sqlSenha, $parametroSenha);

            if (!$resultSetSenha) {
                error_log(print_r(sqlsrv_errors(), true));
                throw new Exception("Erro ao inserir Senha.");
            }

            // Adicionando a foto
            if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
                $nomeFoto = $foto['name'];
                $tamanhoFoto = $foto['size'];
                $novoNomeFoto = uniqid();
                $extensaoFoto = strtolower(pathinfo($nomeFoto, PATHINFO_EXTENSION));
                $pastaUpload = "../../FrontEnd/upload/";
                $pastaFoto = $pastaUpload . $novoNomeFoto . "." . $extensaoFoto;

                if (move_uploaded_file($foto['tmp_name'], $pastaFoto)) {
                    chmod($pastaFoto, 0644);
                    $sqlSetFoto = "INSERT INTO TbMidia (MidiaNome, TipoMidiaId, MidiaCaminho, MidiaTamanho) VALUES (?, ?, ?, ?)";
                    $parametroFoto = array($nomeFoto, 1, $pastaFoto, $tamanhoFoto);
                    $resultSetFoto = sqlsrv_query($conexao, $sqlSetFoto, $parametroFoto);

                    if (!$resultSetFoto) {
                        error_log(print_r(sqlsrv_errors(), true));
                        throw new Exception("Erro ao inserir foto.");
                    }

                    // Recupera o ID da mídia
                    $sqlGetMidiaId = "SELECT MidiaId FROM TbMidia WHERE MidiaCaminho = ?";
                    $parametroGetMidiaId = array($pastaFoto);
                    $resultGetMidiaId = sqlsrv_query($conexao, $sqlGetMidiaId, $parametroGetMidiaId);

                    if (!$resultGetMidiaId) {
                        error_log(print_r(sqlsrv_errors(), true));
                        throw new Exception("Erro ao pegar midiaId.");
                    } else if (sqlsrv_fetch($resultGetMidiaId)) {
                        $midiaId = sqlsrv_get_field($resultGetMidiaId, 0);
                    }

                    // Adicionando ao perfil mídia
                    $sqlSetPerfilMidia = "INSERT INTO TbPerfilMidia (UsuarioId, MidiaId) VALUES (?, ?);";
                    $parametroSetPerfilMidia = array($usuarioId, $midiaId);
                    $resultSetPerfilMidia = sqlsrv_query($conexao, $sqlSetPerfilMidia, $parametroSetPerfilMidia);

                    if (!$resultSetPerfilMidia) {
                        error_log(print_r(sqlsrv_errors(), true));
                        throw new Exception("Erro ao adicionar ao perfil mídia.");
                    }
                }
            }

            // Verifica o tipo de usuário e faz a inserção adicional se necessário
            if ($usuarioTipo === "M") {
                $sqlUsuarioMusico = "INSERT INTO TbUsuarioMusico (UsuarioId, UsuarioDesc, UsuarioPreco) VALUES (?, ?, ?);";
                $parametroUsuarioMusico = array($usuarioId, $descricao, $valorServico);
                $resultSetUsuarioMusico = sqlsrv_query($conexao, $sqlUsuarioMusico, $parametroUsuarioMusico);

                if (!$resultSetUsuarioMusico) {
                    error_log(print_r(sqlsrv_errors(), true));
                    throw new Exception("Erro ao inserir Usuario Musico.");
                }

                $sqlUsuarioHabilidade = "INSERT INTO TbUsuarioHabilidade (UsuarioId, HabilidadeId) VALUES (?, ?);";
                $parametroUsuarioHabilidade = array($usuarioId, $habilidadeId);
                $resultUsuarioHabilidade = sqlsrv_query($conexao, $sqlUsuarioHabilidade, $parametroUsuarioHabilidade);

                if (!$resultUsuarioHabilidade) {
                    error_log(print_r(sqlsrv_errors(), true));
                    throw new Exception("Erro ao inserir Habilidade Musico.");
                }

                $sqlUsuarioGeneroMu = "INSERT INTO TbUsuarioGeneroMu (UsuarioId, GeneroMuId) VALUES (?, ?);";
                $parametroUsuarioGeneroMu = array($usuarioId, $generoMusicalId);
                $resultUsuarioGeneroMu = sqlsrv_query($conexao, $sqlUsuarioGeneroMu, $parametroUsuarioGeneroMu);

                if (!$resultUsuarioGeneroMu) {
                    error_log(print_r(sqlsrv_errors(), true));
                    throw new Exception("Erro ao inserir Gênero Musical Musico.");
                }

                header("Location: ../../frontend/html/home-musico.php");
                exit();
            } else if ($usuarioTipo === "C") {
                header("Location: ../../frontend/html/home-contratante.php");
                exit();
            }

            unset($_SESSION['UsuarioSenha']);
            unset($_SESSION['UsuarioEmail']);
            unset($_SESSION['UsuarioCpf']);

            // Libera os resultados
            sqlsrv_free_stmt($resultSetSenha);
            sqlsrv_free_stmt($resultSetUsuario);
            sqlsrv_free_stmt($resultSetEndereco);
            sqlsrv_free_stmt($resultSetUsuarioMusico);
            sqlsrv_free_stmt($resultUsuarioGeneroMu);
            sqlsrv_free_stmt($resultUsuarioHabilidade);
        }
    }
} catch (Exception $e) {
    error_log("Erro geral: " . $e->getMessage());
    echo "<script>
            alert('Ocorreu um erro inesperado. Tente novamente.');
            window.location.href = '../../frontend/html/tipo-usuario.php';
        </script>";
}
?>
