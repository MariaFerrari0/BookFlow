<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookFlow - Criar Conta</title>
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="login-body">

    <div class="login-container">
        <div class="login-sidebar hide-on-small-only">
            <i class="material-icons">person_add</i>
            <h2>Junte-se<span> Nós</span></h2>
            <p>Crie sua conta no BookFlow e comece a monitorar as suas leituras de forma moderna.</p>
        </div>

        <div class="login-form-wrapper">
            <h4>Criar Conta ✨</h4>
            <p class="subtitle">Preencha seus dados para começar.</p>

            <?php if (isset($_GET['erro'])): ?>
                <div class="card-panel red darken-4 white-text" style="padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #f87171;">
                    <span class="white-text" style="font-weight: 600;">
                        <?php 
                            if ($_GET['erro'] === 'email_existente') echo "Este e-mail já está cadastrado.";
                            elseif ($_GET['erro'] === 'erro_cadastro') echo "Erro ao salvar usuário. Tente novamente.";
                            elseif ($_GET['erro'] === 'campos_vazios') echo "Preencha todos os campos.";
                        ?>
                    </span>
                </div>
            <?php endif; ?>

            <form action="../CONTROLLER/CadastroController.php" method="POST">
                <div class="input-field">
                    <i class="material-icons prefix">person</i>
                    <input type="text" id="nome" name="nome" required class="validate">
                    <label for="nome">Nome Completo</label>
                </div>

                <div class="input-field">
                    <i class="material-icons prefix">email</i>
                    <input type="email" id="email" name="email" required class="validate">
                    <label for="email">E-mail</label>
                </div>

                <div class="input-field">
                    <i class="material-icons prefix">lock</i>
                    <input type="password" id="senha" name="senha" required minlength="6" class="validate">
                    <label for="senha">Senha (Mín. 6 caracteres)</label>
                </div>

                <button type="submit" class="btn waves-effect waves-light btn-login" style="margin-top: 15px;">
                    CADASTRAR
                </button>
            </form>

            <div class="register-text">
                Já tem uma conta? <a href="login.php">Faça login</a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.AutoInit();
        });
    </script>
</body>
</html>