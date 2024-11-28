<?php

    include '../../BackEnd/views/verificar-logado.php';
    include '../../BackEnd/views/conexao.php';
    include '../../FrontEnd/html/acessibilidade.html';

    function getSelectOptions($sql) {
        try {
            include '../../BackEnd/views/conexao.php';
            $options = '';

            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();   

            if (empty($resultados)) {
                $options .= '<option value="" disabled>Nenhum item encontrado</option>';
            } else {
                foreach ($resultados as $resultado) {
                    $options .= '<option value="' . $resultado['id'] . '">' . $resultado['nome'] . '</option>';
                }
            }
            
            return $options;
        } catch (Exception $e) {
            error_log("Erro na função getSelectOptions: " . $e->getMessage());
            echo '<script>
                    alert("Ocorreu um erro inesperado. Tente novamente.");
                    window.location.href = "../../frontend/html/home-contratante.php";
                </script>';
        }
        
    }

    // Consultas para preencher os selects
    $cidadeOptions = getSelectOptions("SELECT CidadeId as id, CidadeNome as nome FROM TbCidade");
    $habilidadeOptions = getSelectOptions("SELECT HabilidadeId as id, HabilidadeNome as nome FROM TbHabilidade");
    $generoMusicalOptions = getSelectOptions("SELECT GeneroMuId as id, GeneroMuNome as nome FROM TbGeneroMusical");
    $tipoEventoOptions = getSelectOptions("SELECT TipoEventoId as id, TipoEventoNome as nome FROM TbTipoEvento");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Novo Anúncio</title>
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="../css/anunciar.css">
    <script src="../js/anunciar.js" defer></script>
    <!-- Inclua o jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Inclua o jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#cep').mask('00000-000'); // Máscara para o CEP
            $('#telefone').mask('(00) 00000-0000');
        });
    </script>
</head>
<body>
    <header>
        <div class="progress-novo-anuncio">
            <h1>Anunciando</h1>
            <div class="progress">
                <div class="progress-bar" id="progress-bar"></div>
            </div>

            <div class="steps">
                <p class="step" id="step-event">Evento</p>
                <p class="step" id="step-address">Endereço</p>
                <p class="step" id="step-vacancy">Vaga</p>
                <p class="step" id="step-music">Contato</p>
            </div>
        </div>
    </header>

    <main>
        <form enctype="multipart/form-data" action="../../BackEnd/views/novo-anuncio.php" method="post" id="form-novo-anuncio">
      
        <fieldset class="form-step" id="form-step-event">
            <div id="grupo-inputs-sobre-evento">
                <h3>Sobre o Evento</h3>
                <span id="erro-evento"></span>
                <div class="form-input">
                    <label for="titulo">Título<span class="obrigatorio">*</span></label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>

                <div class="form-input">
                    <label for="tipo-evento">Tipo do Evento<span class="obrigatorio">*</span></label>
                    <select id="tipo-evento" name="tipo-evento" required>
                        <option value="" disabled selected>Selecione o tipo de evento</option>
                        <?php echo $tipoEventoOptions ?>
                    </select>
                </div>

                <div class="form-input">
                    <label for="genero-musical">Gênero Musical<span class="obrigatorio">*</span></label>
                    <select id="genero-musical" name="genero-musical">
                        <option value="" disabled selected>Selecione o gênero musical</option>
                        <?php echo $generoMusicalOptions ?>
                    </select>
                </div>

                <div class="form-input">
                    <label for="descricao">Descrição<span class="obrigatorio">*</span><small id="char-count-desc" class="char-count"></small></label>
                    <textarea id="descricao" name="descricao" placeholder="Detalhes sobre o evento" required></textarea>
                </div>
            </div>
            <div class="form-input" id="form-input-picture">
                    <div id="layout-preview-picture">
                        <div id="preview-picture" onclick="document.getElementById('foto').click()">
                            <img id="image-preview" src="" alt="Pré-visualização da foto" style="display: none;">
                            <span id="botao-foto">Adicionar Foto</span>
                        </div>
                        <input type="file" id="foto" name="foto" accept="image/png, image/jpeg, image/jpg">
                    </div>
                </div>
        </fieldset>
        <fieldset class="form-step hidden" id="form-step-address">
            <h3>Endereço do Evento</h3>
            <span id="erroEndereco"></span>
            <div id="grupo-inputs-endereco">
                <div class="form-input">
                    <label for="logradouro">Logradouro<span class="obrigatorio">*</span></label>
                    <input type="text" id="logradouro" name="logradouro" required>
                </div>
                <div class="form-input">
                    <label for="numero">Número<span class="obrigatorio">*</span></label>
                    <input type="number" id="numero" name="numero" required>
                </div>
                <div class="form-input">
                    <label for="complemento">Complemento<small id="char-count-comp" class="char-count"></small></label>
                    <input type="text" id="complemento" name="complemento">
                </div>
                <div class="form-input">
                    <label for="bairro">Bairro<span class="obrigatorio">*</span></label>
                    <input type="text" id="bairro" name="bairro" required>
                </div>
                <div class="form-input">
                    <label for="cep">CEP<span class="obrigatorio">*</span></label>
                    <input type="text" id="cep" name="cep" required>
                </div>
                
                <div class="form-input" id="form-input-cidade">
                    <label for="cidade">Cidade<span class="obrigatorio">*</span></label>
                    <select id="cidade" name="cidade" required>
                        <option value="" disabled selected>Selecione a cidade</option>
                        <?php echo $cidadeOptions ?>
                    </select>
                </div>
            </div>

        </fieldset>
        <fieldset class="form-step hidden" id="form-step-vacancy">
            <h3>Sobre a vaga</h3>
            <span id="erroVaga"></span>
            <div id="gruupo-inputs-vaga">
                <div id="form-inputs-data">
                    <div class="form-input">
                        <label for="data-hr-inicio">Data/Hora de Início<span class="obrigatorio">*</span></label>
                        <input type="datetime-local" id="data-hr-inicio" name="data-hr-inicio" required>
                    </div>
                    <div class="form-input">
                        <label for="data-hr-fim">Data/Hora de Fim<span class="obrigatorio">*</span></label>
                        <input type="datetime-local" id="data-hr-fim" name="data-hr-fim" required>
                    </div>
                </div>
                <div class="form-input">
                    <label for="beneficios">Benefícios<small id="char-count-bene" class="char-count"></small></label>
                    <textarea id="beneficios" name="beneficios" placeholder="Se houver, descreva os benefícios"></textarea>
                </div>
                <div class="form-input">
                    <label for="valor-hora">Valor/Hora (R$)<span class="obrigatorio">*</span></label>
                    <input type="number" id="valor-hora" name="valor-hora" required>
                </div>
                <div class="form-input">
                    <label for="habilidades">Habilidades Necessárias</label>
                    <select id="habilidades" name="habilidades">
                        <option value="">Selecione uma habilidade</option>
                        <?php echo $habilidadeOptions ?>
                    </select>
                </div>
            </div>
        </fieldset>
        <fieldset class="form-step hidden" id="form-step-contact">
            <h3>Contato</h3>
            <span id="erroContato"></span>
            <div class="form-input">
                <label for="nome-contato">Nome Contato<span class="obrigatorio">*</span></label>
                <input type="text" id="nome-contato" name="nome-contato" required>
            </div>
            <div class="form-input">
                <label for="telefone">Telefone<span class="obrigatorio">*</span></label>
                <input type="text" id="telefone" name="telefone" required>
            </div>
            <p><strong>Importante:</strong> O contato que você inserir neste campo será disponibilizado para o músico, caso ele deseje entrar em contato com você para maiores informações sobre o anúncio. Certifique-se de incluir um contato válido e atualizado para facilitar a comunicação!</p>
        </fieldset>
        <div class="botoes">
            <button type="button" id="botao-voltar">Voltar</button>
            <button type="submit" id="botao-avancar">Avançar</button>
        </div>
        </form>
    </main>
</body>
</html>
