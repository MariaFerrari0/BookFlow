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

       
        if ($userDAL->buscarPorEmail($email) !== null) {
            header("Location: ../VIEW/cadastro.php?erro=email_existente");
            exit;
        }

        
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

    
        $novoUsuario = new User(null, $nome, $email, $senhaHash);

      
        if ($userDAL->cadastrar($novoUsuario)) {
           
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