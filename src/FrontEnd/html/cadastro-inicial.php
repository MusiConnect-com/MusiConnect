<?php 

session_start();
include '../../FrontEnd/html/acessibilidade.html';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicConnect</title>
    <link rel="stylesheet" href="../css/cadastro-inicial.css">
    <link rel="stylesheet" href="../global.css">
    <!-- <script src="../js/cadastro-inicial.js" defer></script> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!--MAIN-->
    <main>
        <div class="signup-left">
            <img src="../img/img-cadastro.png" alt="imagem-musico">
        </div>

        <div class="signup-right">
            <div class="card">
                <h2>Sign up</h2>
                <p>Já tem cadastro? <a href="./login.php">Faça login</a></p>

                <form action="../../BackEnd/views/consultar-cpf-email.php" method="post" id="form-cadastro" onsubmit="return validarForm()">
                    <div>
                        <div id="nome-sobrenome">
                            <input type="text" class="first-name required" name="nome" placeholder="Nome" oninput="nameValidate()" minlength="3" required>
                            <input type="text" class="last-name required" name="sobrenome" placeholder="Sobrenome" minlength="3" required>
                        </div>
                        <span class="span-required">Nome deve ter no mínimo 3 caracteres</span>
                    </div>

                    <div>
                        <input type="text" class="cpf required" name="cpf" id="cpf" placeholder="CPF" maxlength="14" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" oninput="mascaraCPF(this)" required>
                        <span class="span-required">Digite um CPF válido</span>

                        <?php 
                            if (!empty($_SESSION['cpf-error'])){
                                echo "<span class='session-error'>" . $_SESSION['cpf-error'] . "</span>";

                                unset($_SESSION['cpf-error']);
                            }
                        ?>
                    </div>

                    <div>
                        <input type="email" class="email required" name="email" placeholder="E-mail" oninput="emailValidate()" required>
                        <span class="span-required">Digite um email válido</span>

                        <?php 
                            if (!empty($_SESSION['email-error'])){
                                echo "<span class='session-error'>" . $_SESSION['email-error'] . "</span>";

                                unset($_SESSION['email-error']);
                            }
                        ?>
                    </div>

                    <div>
                        <input type="password" class="password required" name="senha" id="senha" placeholder="Senha" oninput="passwordValidate()" minlength="8" required>
                        <span class="span-required">Senha deve ter no mínimo 8 caracteres</span>
                    </div>

                    <div>
                        <input type="password" class="confirm-password required" name="confirmar-senha" id="confirmar-senha" placeholder="Confirmar senha" oninput="comparePassword()" minlength="8" required>
                        <span class="span-required" id="span-senha-diferente">Senhas devem ser compatíveis</span>
                    </div>

                    <button type="submit" id="button-signup">Cadastrar</button>

                    <script>
                            function mascaraCPF(cpf) {
                                // Remove caracteres que não sejam números
                                cpf.value = cpf.value.replace(/\D/g, '');
                                
                                // Adiciona a máscara ao CPF
                                cpf.value = cpf.value.replace(/(\d{3})(\d)/, '$1.$2');
                                cpf.value = cpf.value.replace(/(\d{3})(\d)/, '$1.$2');
                                cpf.value = cpf.value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

                                // Limita o número de caracteres
                                if (cpf.value.length > 14) {
                                    cpf.value = cpf.value.substring(0, 14);
                                }
                            }

                            function validarForm() {
                                // Obtém o valor do campo CPF
                                var senha = document.getElementById('senha').value;
                                var confirmSenha = document.getElementById('confirmar-senha').value;
                                var spanSenhaDif = document.getElementById('span-senha-diferente');

                                if (senha !== confirmSenha) {
                                    spanSenhaDif.style.display = "block";
                                    return false;
                                } else {
                                    spanSenhaDif.style.display = "none";
                                    return true;
                                }

                                
                            }

                    </script>
                </form>


                <p>Ao criar uma conta, você concorda com os <span>Termos de uso</span>
                    e <span>Política de Privacidade</span></p>
            </div>
        </div>
    </main>
    <!--FIM MAIN-->
</body>
</html>