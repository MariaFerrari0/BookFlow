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
<body>

    <div class="container">
        <div class="row">
            <div class="col s12 m10 offset-m1 l8 offset-l2">
                <div class="card login-card valing-wrapper">
                    <div class="row" style="margin-bottom: 0;">
                        
                        <div class="col m6 hide-on-small-only indigo darken-4 white-text valign-wrapper" style="min-height: 500px; flex-direction: column; justify-content: center; padding: 40px;">
                            <i class="material-icons large">auto_stories</i>
                            <h4 class="center-align" style="font-weight: 800;">BookFlow</h4>
                            <p class="center-align grey-text text-lighten-2">Sua jornada de leitura organizada e inteligente.</p>
                        </div>

                        <div class="col s12 m6" style="padding: 40px; min-height: 500px;">
                            <h5 class="white-text" style="font-weight: 700; margin-bottom: 5px;">Bem-vindo de volta!</h5>
                            <p class="grey-text text-darken-1" style="margin-top: 0; margin-bottom: 30px;">Faça login para continuar</p>

                            <?php if (isset($_GET['erro'])): ?>
                                <div class="card-panel red darken-4 white-text" style="padding: 10px; margin-bottom: 20px;">
                                    <span class="white-text text-darken-2">
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

                                <div class="input-field" style="margin-top: 30px;">
                                    <i class="material-icons prefix">lock</i>
                                    <input type="password" id="senha" name="senha" required class="validate">
                                    <label for="senha">Senha</label>
                                </div>

                                <div class="right-align" style="margin-bottom: 20px;">
                                    <a href="#" class="indigo-text text-lighten-2 text-small">Esqueci minha senha</a>
                                </div>

                                <button type="submit" class="btn waves-effect waves-light indigo accent-4 btn-large" style="width: 100%; border-radius: 8px; font-weight: 600;">
                                    Entrar
                                </button>
                            </form>

                            <div class="center-align" style="margin-top: 30px;">
                               <p class="grey-text text-lighten-1">Não tem uma conta? <a href="cadastro.php" class="indigo-text text-lighten-2" style="font-weight: 600;">Cadastre-se</a></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    
    <script src="../public/js/login.js"></script>
</body>
</html>