<?php
// Ativa exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/CONTROLLERS/UsuarioController.php";
    $usuarioController = new \CONTROLLER\UsuarioController();

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!empty($nome) && !empty($email) && !empty($senha)) {
        // Envia os dados brutos para a controller (a DAL se encarregará do MD5)
        $sucesso = $usuarioController->cadastrar($nome, $email, $senha);

        if ($sucesso) {
            // Redireciona imediatamente para o login após cadastrar com sucesso
            header("Location: login.php?cadastro=sucesso");
            exit;
        } else {
            $mensagem_erro = "Erro ao cadastrar. O e-mail inserido já pode estar em uso.";
        }
    } else {
        $mensagem_erro = "Preencha todos os campos corretamente!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Bookflow</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/BookFlow/VIEW/assets/login.css">
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <div class="logo-area">
            <i class="material-icons logo-icon">auto_stories</i>
            <h2>Bookflow</h2>
        </div>
        <p class="subtitle">Crie a sua conta de leitura gratuita</p>

        <?php if (!empty($mensagem)): ?>
            <div class="alert <?php echo $status; ?>">
                <i class="material-icons alert-icon">
                    <?php echo $status === 'sucesso' ? 'check_circle' : 'error'; ?>
                </i>
                <span><?php echo $mensagem; ?></span>
            </div>
        <?php endif; ?>

        <form action="cadastro.php" method="POST" id="formCadastro">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <div class="input-with-icon">
                    <i class="material-icons input-icon">person</i>
                    <input type="text" id="nome" name="nome" placeholder="Ex: Maria Silva" required>
                </div>
                <span class="error-msg" id="error-nome"></span>
            </div>
            
            <div class="form-group">
                <label for="email">E-mail</label>
                <div class="input-with-icon">
                    <i class="material-icons input-icon">email</i>
                    <input type="email" id="email" name="email" placeholder="Ex: maria@email.com" required>
                </div>
                <span class="error-msg" id="error-email"></span>
            </div>
            
            <div class="form-group">
                <label for="senha">Palavra-passe</label>
                <div class="input-with-icon">
                    <i class="material-icons input-icon">lock</i>
                    <input type="password" id="senha" name="senha" placeholder="Mínimo 6 caracteres" required>
                </div>
                <span class="error-msg" id="error-senha"></span>
            </div>
            
            <button type="submit" class="btn-primary">
                <span>Criar minha Conta</span>
                <i class="material-icons btn-icon">arrow_forward</i>
            </button>
        </form>

        <div class="footer-link">
            Já tem uma conta? <a href="login.php">Entrar aqui</a>
        </div>
    </div>
</div>

<script src="/BookFlow/VIEW/javascript/login.js" defer></script>
</body>
</html>