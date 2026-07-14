<?php
// Inicia a sessão para podermos guardar os dados do usuário logado
session_start();

// Importa os arquivos necessários
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../MODEL/User.php';
require_once __DIR__ . '/../DAL/UserDAL.php';

// Verifica se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if ($email && $senha) {
        $userDAL = new UserDAL();
        $usuario = $userDAL->buscarPorEmail($email);

        // Se o usuário existir e a senha gravada no banco for compatível com a digitada
        if ($usuario && password_verify($senha, $usuario->getSenha())) {
            // Guarda as informações na sessão do navegador
            $_SESSION['usuario_id'] = $usuario->getId();
            $_SESSION['usuario_nome'] = $usuario->getNome();

            // Redireciona para o Dashboard (que criaremos a seguir)
            header("Location: ../VIEW/dashboard.php");
            exit;
        } else {
            // Se falhar, volta para a tela de login com uma mensagem de erro
            header("Location: ../VIEW/login.php?erro=usuario_ou_senha_incorretos");
            exit;
        }
    } else {
        header("Location: ../VIEW/login.php?erro=campos_vazios");
        exit;
    }
} else {
    // Se tentarem acessar este arquivo diretamente sem enviar o formulário, manda de volta
    header("Location: ../VIEW/login.php");
    exit;
}