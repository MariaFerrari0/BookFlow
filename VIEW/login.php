<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookFlow - Login</title>
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="login-body">

    <div class="login-container">
        <div class="login-sidebar hide-on-small-only">
            <i class="material-icons">auto_stories</i>
            <h2>Book<span>Flow</span></h2>
            <p>Sua jornada de leitura organizada e inteligente de um jeito inovador.</p>
        </div>

        <div class="login-form-wrapper">
            <h4>Bem-vindo de volta! 👋</h4>
            <p class="subtitle">Faça login para continuar</p>

            <?php if (isset($_GET['erro'])): ?>
                <div class="card-panel red darken-4 white-text" style="padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #f87171;">
                    <span class="white-text" style="font-weight: 600;">
                        <?php 
                            if ($_GET['erro'] === 'usuario_ou_senha_incorretos') echo "E-mail ou senha incorretos.";
                            elseif ($_GET['erro'] === 'campos_vazios') echo "Por favor, preencha todos os campos.";
                        ?>
                    </span>
                </div>
            <?php endif; ?>

            <form action="../CONTROLLER/LoginController.php" method="POST">
                <div class="input-field">
                    <i class="material-icons prefix">email</i>
                    <input type="email" id="email" name="email" required class="validate">
                    <label for="email">E-mail</label>
                </div>

                <div class="input-field">
                    <i class="material-icons prefix">lock</i>
                    <input type="password" id="senha" name="senha" required class="validate">
                    <label for="senha">Senha</label>
                </div>

                <div class="login-links">
                    <p style="margin: 0;"></p> <a href="#">Esqueci minha senha</a>
                </div>

                <button type="submit" class="btn waves-effect waves-light btn-login">
                    Entrar
                </button>
            </form>

            <div class="register-text">
                Não tem uma conta? <a href="cadastro.php">Cadastre-se</a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="../public/js/login.js"></script>
</body>
</html>