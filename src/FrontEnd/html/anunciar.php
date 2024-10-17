<?php
    session_start();

    if (!isset($_SESSION['UsuarioId'], $_SESSION['UsuarioTipo'], $_SESSION['UsuarioNome'], $_SESSION['UsuarioSobrenome'])) {
        header('Location: ../../BackEnd/views/logout.php');
        exit();
    }
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
        <a href="./home-contratante.php"><- Voltar</a>
        <h1>Novo Anúncio</h1>
    </header>

    <section>
        <form action="../../BackEnd/views/novo-anuncio.php" method="POST">
            <h2>Sobre o Evento</h2>
            
            <div class="form-group">
                <label for="foto">Fotos</label>
                <input type="file" id="foto" name="foto" accept="image/*">
            </div>

            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>

            <div class="form-group">
                <label for="tipo-evento">Tipo do Evento</label>
                <select id="tipo-evento" name="tipo-evento" required>
                    <option value="">Selecione o tipo de evento</option>
                    <?php
                        include '../../BackEnd/views/conexao.php';

                        $sql = "SELECT TipoEventoId as id, TipoEventoNome as nome FROM TbTipoEvento";
                        $resultado = sqlsrv_query($conexao, $sql);


                        if ($resultado) {
                            while ($linha = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $linha['id'] . '">' . $linha['nome'] . '</option>';
                            }
                            sqlsrv_free_stmt($resultado);
                        } else {
                            echo '<option value="" disabled>Nenhum tipo de evento encontrado</option>';
                        }

                        sqlsrv_close($conexao);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="genero-musical">Gênero Musical</label>
                <select id="genero-musical" name="genero-musical">
                    <option value="">Selecione o gênero musical</option>
                    <?php
                        include '../../BackEnd/views/conexao.php';

                        $sql = "SELECT GeneroMuId as id, GeneroMuNome as nome FROM TbGeneroMusical";
                        $resultado = sqlsrv_query($conexao, $sql);


                        if ($resultado) {
                            while ($linha = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $linha['id'] . '">' . $linha['nome'] . '</option>';
                            }
                            sqlsrv_free_stmt($resultado);
                        } else {
                            echo '<option value="" disabled>Nenhum gênero musical encontrado</option>';
                        }

                        sqlsrv_close($conexao);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" placeholder="Detalhes sobre o evento" required></textarea>
            </div>

            <div class="form-group">
                <label for="beneficios">Benefícios</label>
                <textarea id="beneficios" name="beneficios" placeholder="Se houver, descreva os benefícios"></textarea>
            </div>

            <h2>Sobre o Contrato</h2>

            <div class="form-group">
                <label for="habilidades">Habilidades Necessárias</label>
                <select id="habilidades" name="habilidades">
                    <option value="">Selecione uma habilidade necessária para se candidatar</option>
                    <?php
                        include '../../BackEnd/views/conexao.php';

                        $sql = "SELECT HabilidadeId as id, HabilidadeNome as nome FROM TbHabilidade";
                        $resultado = sqlsrv_query($conexao, $sql);


                        if ($resultado) {
                            while ($linha = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $linha['id'] . '">' . $linha['nome'] . '</option>';
                            }
                            sqlsrv_free_stmt($resultado);
                        } else {
                            echo '<option value="" disabled>Nenhuma habilidade encontrado</option>';
                        }

                        sqlsrv_close($conexao);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="data-hr-inicio">Data/Hora de Início</label>
                <input type="datetime-local" id="data-hr-inicio" name="data-hr-inicio" required>
            </div>

            <div class="form-group">
                <label for="data-hr-fim">Data/Hora de Fim</label>
                <input type="datetime-local" id="data-hr-fim" name="data-hr-fim" required>
            </div>

            <div class="form-group">
                <label for="valor-hora">Valor/Hora (R$)</label>
                <input type="number" id="valor-hora" name="valor-hora" required>
            </div>

            <h2>Local</h2>
            <div class="form-group">
                <label for="logradouro">Logradouro</label>
                <input type="text" id="logradouro" name="logradouro" required>
            </div>

            <div class="form-group">
                <label for="numero">Número</label>
                <input type="text" id="numero" name="numero" required>
            </div>

            <div class="form-group">
                <label for="complemento">Complemento</label>
                <input type="text" id="complemento" name="complemento">
            </div>

            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" name="bairro" required>
            </div>

            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" required>
            </div>

            
            <div class="form-group" id="form-group-cidade">
                <label for="cidade">Cidade</label>
                <select id="cidade" name="cidade" required>
                    <option value="">Selecione a cidade</option>
                    <?php
                        include '../../BackEnd/views/conexao.php';


                        $sql = "SELECT CidadeId as id, CidadeNome as nome FROM TbCidade";
                        $resultado = sqlsrv_query($conexao, $sql);


                        if ($resultado) {
                            while ($linha = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                echo '<option value="' . $linha['id'] . '">' . $linha['nome'] . '</option>';
                            }
                            sqlsrv_free_stmt($resultado);
                        } else {
                            echo '<option value="" disabled>Nenhuma habilidade encontrado</option>';
                        }

                        sqlsrv_close($conexao);
                    ?>
                </select>
            </div>

            <h2>Contato</h2>
            <div class="form-group">
                <label for="contato">Telefone</label>
                <input type="tel" id="telefone" name="telefone" required>
            </div>

            <button type="submit">Criar Anúncio</button>
        </form>
    </section>

    <footer>
        <h3>@ MusicConnect</h3>
    </footer>

</body>
</html>
