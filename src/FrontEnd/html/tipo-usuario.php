<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicConnect</title>
    <link rel="stylesheet" href="../css/tipo-usuario.css">
    <link rel="stylesheet" href="../global.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <!--MAIN-->
    <main>
        <div class="select-options">
            <div class="card">
                <div class="top">
                    <h2>Selecione o seu objetivo</h2>
                    <span>Você deve escolher uma das opções para continuar!</span>
                </div>

                <?php
                    session_start();

                    echo "<p>Nome: " . htmlspecialchars($_SESSION['nome']) . "</p>";
                    echo "<p>Sobrenome: " . htmlspecialchars($_SESSION['sobrenome']) . "</p>";
                    echo "<p>CPF: " . htmlspecialchars($_SESSION['cpf']) . "</p>";
                    echo "<p>Email: " . htmlspecialchars($_SESSION['email']) . "</p>";
                    echo "<p>Senha: " . htmlspecialchars($_SESSION['senha']) . "</p>";
                ?>

                <form action="../../backend/views/processar-cadastro.php" method="post" class="form-box-select" id="form-box-select">
                    <label class="select-music" for="music" onclick="validateSelection()">
                        <div>
                            <input type="radio" name="tipo-usuario" id="music" value="M">
                            <h3>Sou Músico</h3>
                        </div>

                        <p>Busco oportunidades de contrato</p>
                    </label>

                    <label class="select-contractor" for="contractor" onclick="validateSelection()">
                        <div>
                            <input type="radio" name="tipo-usuario" id="contractor" value="C">
                            <h3>Sou Contratante</h3>
                        </div>

                        <p>Busco músicos para contratar</p>
                    </label>
                </form>

                <div class="buttons">
                    <div class="button-help" id="button-help">
                        <i class="bi bi-question"></i>
                        <i class="bi bi-question-square-fill"></i>
                    </div>

                    <div class="button-cancel">
                        <button type="submit" id="button-cancel">Cancelar</button>
                    </div>

                    <div class="button-confirm">
                        <button type="submit" form="form-box-select" onclick="validateSelection()" id="button-confirm">Confirmar</button>
                    </div>
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
            </div>
        </div>
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
