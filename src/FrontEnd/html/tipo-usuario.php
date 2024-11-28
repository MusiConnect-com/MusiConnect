<?php

    session_start();
    include '../../FrontEnd/html/acessibilidade.html';

    if (!isset($_SESSION['UsuarioCpf'], $_SESSION['UsuarioEmail'], $_SESSION['UsuarioNome'], $_SESSION['UsuarioSobrenome'], $_SESSION['UsuarioSenha'])) {
        header('Location: ./cadastro-inicial.php');
        exit();
    }

    function getSelectOptions($query) {
        include '../../BackEnd/views/conexao.php';

        try {
            $sql = $query;
            $stmt = $conexao->prepare($sql);
            $stmt->execute();

            $options = '';
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $options .= '<option value="'. $linha['id'] . '">' . $linha['nome'] . '</option>';
            }

            return $options;
        } catch(PDOException $e) {
            // Em caso de erro, exibe mensagem e redireciona
            error_log("Erro na função getSelectOptions: " . $e->getMessage());
            echo '<script>alert("Ocorreu um erro no sistema. Por favor, tente novamente mais tarde.");</script>';
            header('Location: ../../FrontEnd/html/cadastro-inicial.php');
            exit();
        }
    }

    // Consultas para preencher os selects
    $cidadeOptions = getSelectOptions("SELECT CidadeId as id, CidadeNome as nome FROM TbCidade");
    $habilidadeOptions = getSelectOptions("SELECT HabilidadeId as id, HabilidadeNome as nome FROM TbHabilidade");
    $generoMusicalOptions = getSelectOptions("SELECT GeneroMuId as id, GeneroMuNome as nome FROM TbGeneroMusical");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicConnect</title>
    <link rel="stylesheet" href="../css/tipo-usuario.css">
    <link rel="stylesheet" href="../global.css">
    <script src="../js/fluxo-cadastro.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Inclua o jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Inclua o jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#cep').mask('00000-000'); // Máscara para o CEP
            $('#phone').mask('(00) 00000-0000');
        });
    </script>
</head>
<body>
    <header>
        <div class="progress-signup">
            <h1>Finalizando Cadastro</h1>
            <div class="progress">
                <div class="progress-bar" id="progress-bar"></div>
            </div>

            <div class="steps">
                <p class="step default" id="step-goal">Objetivo</p>
                <p class="step default" id="step-personal-data">Dados Pessoais</p>
                <p class="step hidden-step" id="step-music">Sobre o Músico</p>
            </div>
        </div>
    </header>
    <!--MAIN-->
    <main>
        <form enctype="multipart/form-data" method="post" action="../../BackEnd/views/processar-cadastro.php" class="form-signup" id="form-signup">
            
            <!-- etapas -->
            <fieldset class="form-step" id="form-step-goal">
                <div class="form-step-goal-top">
                    <h2>Selecione o seu objetivo</h2>
                    <span>Você deve escolher uma das opções para continuar!</span>
                </div>
                <div class="user-selection">
                    <label class="select-music" for="music">
                        <div>
                            <input type="radio" name="tipo-usuario" id="music" value="M" required>
                            <h3>Sou Músico</h3>
                        </div>

                        <p>Busco oportunidades de contrato</p>
                    </label>

                    <label class="select-contractor" for="contractor">
                        <div>
                            <input type="radio" name="tipo-usuario" id="contractor" value="C" required>
                            <h3>Sou Contratante</h3>
                        </div>

                        <p>Busco músicos para contratar</p>
                    </label>
                </div>
            </fieldset>

            <fieldset class="form-step hidden" id="form-step-personal-data">
                <div id="layout-personal-data">
                    <h3>Perfil</h3>
                    <span id="error-profile"></span>
                    <div class="profile">
                        <div class="info-profile-group">
                            <div class="form-step-group">
                                <label for="date-birth">Data de Nascimento<span class="obrigatorio">*</span></label>
                                <input type="date" id="date-birth" name="date-birth" required>
                            </div>
                            <div class="form-step-group">
                                <label for="sex">Sexo<span class="obrigatorio">*</span></label>
                                <select name="sex" id="sex">
                                    <option value="" disabled selected>Selecione o Sexo</option>
                                    <option value="F">Feminino</option>
                                    <option value="M">Masculino</option>
                                    <option value="N">Não informar</option>
                                </select>
                            </div>
                    
                            <div class="form-step-group">
                                <label for="phone">Telefone<span class="obrigatorio">*</span></label>
                                <input type="text" id="phone" name="phone" required>
                            </div>
                        </div>
                    </div>
                    <h3>Endereço</h3>
                    <span id="error-address"></span>
                    <div class="address">
                        <div class="form-step-group" id="form-step-group-cidade">
                            <label for="cidade">Cidade<span class="obrigatorio">*</span></label>
                            <select id="cidade" name="cidade" required>
                                <option value="0" selected disabled>Selecione a cidade</option>
                                <?php echo $cidadeOptions; ?>
                            </select>
                        </div>
                        <div class="form-step-group">
                            <label for="logradouro">Logradouro<span class="obrigatorio">*</span></label>
                            <input type="text" id="logradouro" name="logradouro" required>
                        </div>
                        <div class="form-step-group">
                            <label for="numero">Número<span class="obrigatorio">*</span></label>
                            <input type="number" id="numero" name="numero" required>
                        </div>
                        <div class="form-step-group">
                            <label for="complemento">Complemento <small id="char-count-comp" class="char-count"></small></label>
                            <input type="text" id="complemento" name="complemento">
                            
                        </div>
                        <div class="form-step-group">
                            <label for="bairro">Bairro<span class="obrigatorio">*</span></label>
                            <input type="text" id="bairro" name="bairro" required>
                        </div>
                        <div class="form-step-group">
                            <label for="cep">CEP<span class="obrigatorio">*</span></label>
                            <input type="text" id="cep" name="cep" required>
                        </div>
                    </div>
                </div>
                <div class="form-step-group" id="profile-picture-group">
                        <div id="layout-preview-picture">
                            <div id="preview-picture" onclick="document.getElementById('foto').click()">
                                <img id="image-preview" src="" alt="Pré-visualização da foto" style="display: none;">
                                <span id="botao-foto">Adicionar Foto</span>
                            </div>
                            <input type="file" id="foto" name="foto" accept="image/png, image/jpeg, image/jpg">
                        </div>
                    </div>
            </fieldset>

            <fieldset class="form-step hidden" id="form-step-about-music">
                <h3>Sobre o Músico</h3>
                <span id="error-about-music"></span>
                <div class="form-step-group">
                    <label for="stage-name">Nome Artístico</label>
                    <input type="text" id="stage-name" name="stage-name" required>
                </div>
                <div class="selects-skill-genre">
                    <div class="form-step-group">
                        <label for="skill">Habilidade<span class="obrigatorio">*</span></label>
                        <select id="skill" name="skill">
                            <option value="">Selecione uma habilidade</option>
                            <?php echo $habilidadeOptions; ?>
                        </select>
                    </div>
                    <div class="form-step-group">
                        <label for="genre-music">Gênero Musical<span class="obrigatorio">*</span></label>
                        <select id="genre-music" name="genre-music">
                            <option value="">Selecione um gênero musical</option>
                            <?php echo $generoMusicalOptions; ?>
                        </select>
                    </div>
                </div>
                <div class="form-step-group">
                    <label for="description">Descrição <small id="char-count-desc" class="char-count"></small></label>
                        <textarea name="description" id="description" placeholder="Fale sobre você e sua carreira..." required></textarea>
                </div>
                <div class="form-step-group">
                    <label for="service-value">Valor Serviço (hr)</label>
                    <input type="number" id="service-value" name="service-value" required>
                </div>
            </fieldset>
            <!-- buttons -->
            <div class="botoes">
                <button type="button" id="botao-voltar">Voltar</button>
                <button type="submit" id="botao-avancar">Avançar</button>
            </div>
            <!--CANCELAR CADASTRO-->
            <div class="modal-cancel">
                <dialog open>
                    <h3>Tem certeza que deseja cancelar?</h3>
                    <p>Você perderá todo seu cadastro feito até aqui</p>

                    <div class="button">
                        <button type="button" class="button-not" id="button-not">NÃO</button>
                        <button type="button" class="button-yes" id="button-yes">SIM</button>
                    </div>
                </dialog>
            </div>
            <!--FIM CANCELAR CADASTRO-->
        </form>
        <!--INFORMAÇÕES AJUDA-->
        <div class="overlay-modal">
            <div class="modal-help">
                <div class="music">
                    <h3>Sou Músico</h3>
                    <p>Leve sua carreira musical ao próximo nível. Crie seu perfil, exiba suas habilidades e conecte-se com oportunidades de contrato emocionantes. Seja você vocalista, guitarrista, baterista ou outro instrumentista, encontre o espaço ideal para crescer e brilhar na música.</p>
                </div>

                <div class="contractor">
                    <h3>Sou Contratante</h3>
                    <p>Transforme seu evento em um sucesso inesquecível com músicos profissionais. Nossa plataforma conecta você a uma ampla gama de talentos musicais para eventos corporativos, casamentos, festas privadas e muito mais. Encontre os artistas perfeitos para realizar sua visão.</p>
                </div>

                <div class="button-close">
                    <button type="button" id="button-close">Fechar</button>
                </div>
            </div>
        </div>
        <!--FIM INFORMAÇÕES AJUDA-->
    </main>
    <!--FIM MAIN-->
</body>
</html>
