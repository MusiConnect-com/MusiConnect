<?php
include '../../BackEnd/views/conexao.php'; // Conexão com o banco de dados

session_start();

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtendo dados do formulário
    $usuarioId = $_SESSION['UsuarioId'];
    $titulo = $_POST['titulo'];
    $tipoEventoId = $_POST['tipo-evento'];
    $generoMusicalId = $_POST['genero-musical'];
    $descricao = $_POST['descricao'];
    $beneficios = $_POST['beneficios'];
    $habilidadesId = $_POST['habilidades'];
    $dataInicio = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['data-hr-inicio']);
    $dataFim = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['data-hr-fim']);
    $valor = $_POST['valor-hora'];
    $endLogra = $_POST['logradouro'];
    $endNum = $_POST['numero'];
    $endComp = $_POST['complemento'];
    $endBai = $_POST['bairro'];
    $endCep = str_replace('-', '', $_POST['cep']);
    $cidadeId = $_POST['cidade'];
    $telefone = preg_replace('/\D/', '', $_POST['telefone']);

    $dataInicioFormatada = $dataInicio ? $dataInicio->format('Y-m-d H:i:s') : null;
    $dataFimFormatada = $dataFim ? $dataFim->format('Y-m-d H:i:s') : null;

    // Tratamento para o upload da foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $fotoTemp = $_FILES['foto']['tmp_name'];
        $fotoNome = $_FILES['foto']['name'];
        $caminhoFoto = 'http://localhost/musiconnect/src/frontend/uploads/' . basename($fotoNome); // Caminho onde a foto será salva

        $fotoNomeLimpo = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fotoNome);
        // Move o arquivo para o diretório de uploads
        move_uploaded_file($fotoTemp, $caminhoFoto);
    } else {
        $caminhoFoto = null; // Se não houver foto, define como null
    }

    // Preparando a instrução SQL para inserir o anúncio
    $sqlAnuncio = "INSERT INTO TbAnuncio (UsuarioId, AnuncioTitulo, AnuncioDataHrInicio, AnuncioDataHrFim, 
            TipoEventoId, AnuncioEndLogra, AnuncioEndNum, AnuncioEndComp, AnuncioEndBai, AnuncioEndCep, 
            CidadeId, AnuncioDesc, AnuncioBeneficios, AnuncioContato, AnuncioValor, AnuncioStatus, 
            AnuncioDataHr, AnuncioValidade)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'ATIVO', GETDATE(), DATEADD(DAY,30, GETDATE()))";

    // Executando a consulta
    $parametrosAnuncio = array($usuarioId, $titulo, $dataInicioFormatada, $dataFimFormatada, $tipoEventoId, $endLogra, $endNum, $endComp, $endBai, $endCep, $cidadeId, $descricao, $beneficios, $telefone, $valor);
    $resultadoAnuncio = sqlsrv_query($conexao, $sqlAnuncio, $parametrosAnuncio);

    // Verifica se a execução foi bem-sucedida
    if ($resultadoAnuncio) {

        $sqlAnuncioId = "SELECT COUNT(AnuncioId) AS TotalAnuncios FROM TbAnuncio;";
        $resultadoAnuncioId = sqlsrv_query($conexao, $sqlAnuncioId);
        $linha = sqlsrv_fetch_array($resultadoAnuncioId, SQLSRV_FETCH_ASSOC);
        $anuncioId = $linha['TotalAnuncios'];

        if ($anuncioId) {
            // Verifica se o caminho da foto não é null
            if ($caminhoFoto) {
                // Inserindo na tabela TbMidia
                $sqlMidia = "INSERT INTO TbMidia (UsuarioId, MidiaNome, TipoMidiaId, MidiaCaminho, MidiaTitulo, MidiaDesc) VALUES (?, ?, ?, ?, ?, ?)";
                // Ajuste o TipoMidiaId e outros campos conforme necessário
                $tipoMidiaId = 1; // Por exemplo, 1 para foto
                $midiaTitulo = "Título da Mídia"; // Coloque um título relevante
                $midiaDesc = "Descrição da Mídia"; // Coloque uma descrição relevante
                $parametrosMidia = array($usuarioId, $fotoNome, $tipoMidiaId, $caminhoFoto, $midiaTitulo, $midiaDesc);
                $resultadoMidia = sqlsrv_query($conexao, $sqlMidia, $parametrosMidia);
                
                if ($resultadoMidia) {

                    $sqlMidiaId = "SELECT COUNT(MidiaId) AS TotalMidias FROM TbMidia;";
                    $resultadoMidiaId = sqlsrv_query($conexao, $sqlMidiaId);
                    $linhaMidia = sqlsrv_fetch_array($resultadoMidiaId, SQLSRV_FETCH_ASSOC);
                    $midiaId = $linhaMidia['TotalMidias'];

                    // Inserindo na tabela TbAnuncioMidia
                    $sqlAnuncioMidia = "INSERT INTO TbAnuncioMidia (AnuncioId, MidiaId) VALUES (?, ?)";
                    $parametrosAnuncioMidia = array($anuncioId, $midiaId);
                    $resultadoAnuncioMidia = sqlsrv_query($conexao, $sqlAnuncioMidia, $parametrosAnuncioMidia);

                    if ($resultadoAnuncioMidia) {
                        echo "Mídia adicionada com sucesso ao anúncio!";
                    } else {
                        echo "Erro ao adicionar mídia ao anúncio: " . print_r(sqlsrv_errors(), true);
                    }
                } else {
                    echo "Erro ao inserir na tabela TbMidia: " . print_r(sqlsrv_errors(), true);
                }
            } else {
                echo "Caminho de foto null";
            }

            // Resto do seu código para adicionar habilidades e gêneros musicais...
            if ($habilidadesId) {
                $sqlAnuncioHabilidade = "INSERT INTO TbAnuncioHabilidade (AnuncioId, HabilidadeId) VALUES (?, ?)";
                $parametrosAnuncioHabilidade = array($anuncioId, $habilidadesId);
                $resultadoAnuncioHabilidade = sqlsrv_query($conexao, $sqlAnuncioHabilidade, $parametrosAnuncioHabilidade);

                if ($resultadoAnuncioHabilidade) {
                    echo "Habilidade adicionada com sucesso!";
                } else {
                    echo "Erro ao adicionar habilidade: " . print_r(sqlsrv_errors(), true);
                }
            }
            if ($generoMusicalId) {
                $sqlAnuncioGeneroMusical = "INSERT INTO TbAnuncioGeneroMusical (AnuncioId, GeneroMuId) VALUES (?, ?)";
                $parametrosAnuncioGeneroMusical = array($anuncioId, $generoMusicalId);
                $resultadoAnuncioGeneroMusical = sqlsrv_query($conexao, $sqlAnuncioGeneroMusical, $parametrosAnuncioGeneroMusical);

                if ($resultadoAnuncioGeneroMusical) {
                    echo "Gênero Musical adicionado com sucesso!";
                } else {
                    echo "Erro ao adicionar Gênero Musical: " . print_r(sqlsrv_errors(), true);
                }
            }
        } else {
            echo "Erro ao recuperar AnuncioId.";
        }

        echo "Anúncio criado com sucesso!";
    } else {
        echo "Erro ao criar anúncio: " . print_r(sqlsrv_errors(), true);
    }

    // Fecha a conexão
    sqlsrv_close($conexao);
}
?>
