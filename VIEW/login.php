<?php
// Ativa exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Se o usuário já estiver logado, manda direto para o dashboard
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

$mensagem_erro = "";

// Verifica se veio uma confirmação de cadastro realizado
if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'sucesso') {
    $mensagem_sucesso = "Cadastro realizado com sucesso! Faça login abaixo.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/CONTROLLERS/UsuarioController.php";
    $usuarioController = new \CONTROLLER\UsuarioController();

    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!empty($email) && !empty($senha)) {
        // Efetua o login na Controller
        $usuario = $usuarioController->login($email, $senha);

        if ($usuario) {
            // Guarda as informações básicas na sessão do navegador
            $_SESSION['usuario_id'] = $usuario->getIdUsuario();
            $_SESSION['usuario_nome'] = $usuario->getNome();
            $_SESSION['usuario_email'] = $usuario->getEmail();

            // Redireciona para o Dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            $mensagem_erro = "E-mail ou palavra-passe incorretos.";
        }
    } else {
        $mensagem_erro = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - Bookflow</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../VIEW/assets/login.css">
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <div class="logo-area">
            <i class="material-icons logo-icon">auto_stories</i>
            <h2>Bookflow</h2>
        </div>
        <p class="subtitle">Faça login para gerir as suas leituras</p>

        <?php if (!empty($mensagem)): ?>
            <div class="alert <?php echo $status; ?>">
                <i class="material-icons alert-icon">
                    <?php echo $status === 'sucesso' ? 'check_circle' : 'error'; ?>
                </i>
                <span><?php echo $mensagem; ?></span>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" id="formLogin">
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
                    <input type="password" id="senha" name="senha" placeholder="Insira a sua senha" required>
                </div>
                <span class="error-msg" id="error-senha"></span>
            </div>
            
            <button type="submit" class="btn-primary">
                <span>Entrar</span>
                <i class="material-icons btn-icon">login</i>
            </button>
        </form>

        <div class="footer-link">
            Ainda não tem conta? <a href="cadastro.php">Crie uma aqui</a>
        </div>
    </div>
</div>

<script src="../VIEW/javascript/login.js" defer></script>
</body>
</html>