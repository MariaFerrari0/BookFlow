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
<body>

    <div class="container">
        <div class="row">
            <div class="col s12 m10 offset-m1 l8 offset-l2">
                <div class="card login-card">
                    <div class="row" style="margin-bottom: 0;">
                        
                        <div class="col m6 hide-on-small-only indigo darken-4 white-text valign-wrapper" style="min-height: 550px; flex-direction: column; justify-content: center; padding: 40px;">
                            <i class="material-icons large">person_add</i>
                            <h4 class="center-align" style="font-weight: 800;">Junte-se a nós</h4>
                            <p class="center-align grey-text text-lighten-2">Crie sua conta no BookFlow e comece a rastrear suas leituras hoje mesmo.</p>
                        </div>

                        <div class="col s12 m6" style="padding: 40px; min-height: 550px;">
                            <h5 class="white-text" style="font-weight: 700; margin-bottom: 5px;">Criar Conta</h5>
                            <p class="grey-text text-darken-1" style="margin-top: 0; margin-bottom: 25px;">Preencha os dados abaixo</p>

                            <?php if (isset($_GET['erro'])): ?>
                                <div class="card-panel red darken-4 white-text" style="padding: 10px; margin-bottom: 20px;">
                                    <span class="white-text">
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

                                <div class="input-field" style="margin-top: 20px;">
                                    <i class="material-icons prefix">email</i>
                                    <input type="email" id="email" name="email" required class="validate">
                                    <label for="email">E-mail</label>
                                </div>

                                <div class="input-field" style="margin-top: 20px;">
                                    <i class="material-icons prefix">lock</i>
                                    <input type="password" id="senha" name="senha" required class="validate">
                                    <label for="senha">Senha (Mín. 6 caracteres)</label>
                                </div>

                                <button type="submit" class="btn waves-effect waves-light indigo accent-4 btn-large" style="width: 100%; border-radius: 8px; font-weight: 600; margin-top: 20px;">
                                    Cadastrar
                                </button>
                            </form>

                            <div class="center-align" style="margin-top: 25px;">
                                <p class="grey-text text-lighten-1">Já tem uma conta? <a href="login.php" class="indigo-text text-lighten-2" style="font-weight: 600;">Faça Login</a></p>
                            </div>
                        </div>

                    </div>
                </div>
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