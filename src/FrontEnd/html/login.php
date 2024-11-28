<?php include '../../FrontEnd/html/acessibilidade.html';?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicConnect</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../global.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!--MAIN-->
    <main> 
        <div class="login-left">
            <div class="card">
                <h2>Login</h2>

                <!-- mensagem de erro -->
                <?php 
                    session_start();

                    if (!empty($_SESSION['login-error'])){
                        echo "<span class='login-error'>" . $_SESSION['login-error'] . "</span>";

                        unset($_SESSION['login-error']);
                    }
                ?>

                <form class="form" id="form" action="../../BackEnd/views/processar-login.php" method="post">
                    <div>
                        <input type="text" name="email" class="email required" placeholder="E-mail" required>
                        <span class="span-required">Digite um email válido</span>
                    </div>
                
                    <div>
                        <input type="password" name="password" class="password required" placeholder="Senha" required>
                        <span class="span-required">Senha deve ter no mínimo 8 caracteres</span>
                    </div>
                
                    <button type="submit" id="button-login">Entrar</button>
                </form>
                
                
                <p>Ainda não tem uma conta? <a href="./cadastro-inicial.php">Crie uma agora!</a></p>
                <p><a href="#">Esqueceu sua senha?</a></p>
            </div>
        </div>
        <div class="login-right">
                <img class="login-img" src="../img/img-login.png" alt="imagem__musico">
        </div>
    </main>
    <!--FIM MAIN-->
</body>
</html>