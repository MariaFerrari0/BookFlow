<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../MODEL/User.php';
require_once __DIR__ . '/../DAL/UserDAL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if ($nome && $email && $senha) {
        $userDAL = new UserDAL();

        // 1. Verifica se o e-mail já está cadastrado para evitar duplicados
        if ($userDAL->buscarPorEmail($email) !== null) {
            header("Location: ../VIEW/cadastro.php?erro=email_existente");
            exit;
        }

        // 2. Criptografa de forma correta e segura a senha
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

        // 3. Instancia o Model de Usuário com a senha criptografada
        $novoUsuario = new User(null, $nome, $email, $senhaHash);

        // 4. Salva no banco de dados
        if ($userDAL->cadastrar($novoUsuario)) {
            // Sucesso! Redireciona para o login com parâmetro de sucesso
            header("Location: ../VIEW/login.php?cadastro=sucesso");
            exit;
        } else {
            header("Location: ../VIEW/cadastro.php?erro=erro_cadastro");
            exit;
        }
    } else {
        header("Location: ../VIEW/cadastro.php?erro=campos_vazios");
        exit;
    }
} else {
    header("Location: ../VIEW/cadastro.php");
    exit;
}