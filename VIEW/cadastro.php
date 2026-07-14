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
            <div class="logo-neon" style="flex-direction: column; align-items: center; gap: 15px;">
                <i class="material-icons" style="font-size: 4.5rem; color: #6366f1;">auto_stories</i>
                <h2 class="logo-neon-text" style="font-size: 3.5rem; margin: 0;">
                    <span class="brand-book">Book</span><span class="brand-flow">Flow</span>
                </h2>
            </div>
            <p class="text-neon-subtle" style="margin-top: 20px; font-size: 1.1rem; max-width: 280px; text-align: center; line-height: 1.6;">
                Crie sua conta no BookFlow e comece a monitorar as suas leituras de forma moderna.
            </p>
        </div>

        <div class="login-form-wrapper">
            <h4 class="text-neon-purple" style="font-weight: 700;">Criar Conta ✨</h4>
            <p class="subtitle text-neon-subtle">Preencha seus dados para começar.</p>

            <?php if (isset($_GET['erro'])): ?>
                <div class="card-panel red darken-4 white-text" style="padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #f87171; box-shadow: 0 0 10px rgba(239, 68, 68, 0.4);">
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
                    <i class="material-icons prefix" style="color: #6366f1;">person</i>
                    <input type="text" id="nome" name="nome" required class="validate" style="color: #ffffff;">
                    <label for="nome">Nome Completo</label>
                </div>

                <div class="input-field">
                    <i class="material-icons prefix" style="color: #6366f1;">email</i>
                    <input type="email" id="email" name="email" required class="validate" style="color: #ffffff;">
                    <label for="email">E-mail</label>
                </div>

                <div class="input-field">
                    <i class="material-icons prefix" style="color: #6366f1;">lock</i>
                    <input type="password" id="senha" name="senha" required minlength="6" class="validate" style="color: #ffffff;">
                    <label for="senha">Senha (Mín. 6 caracteres)</label>
                </div>

                <button type="submit" class="btn waves-effect waves-light btn-login" style="margin-top: 15px; box-shadow: 0 0 15px rgba(168, 85, 247, 0.4); font-weight: bold;">
                    CADASTRAR
                </button>
            </form>

            <div class="register-text text-neon-subtle" style="margin-top: 30px;">
                Já tem uma conta? <a href="login.php" class="text-neon-purple" style="font-weight: 700; margin-left: 5px;">Faça login</a>
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