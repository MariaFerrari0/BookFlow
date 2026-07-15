<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../MODEL/User.php';
require_once __DIR__ . '/../DAL/UserDAL.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if ($email && $senha) {
        $userDAL = new UserDAL();
        $usuario = $userDAL->buscarPorEmail($email);

      
        if ($usuario && password_verify($senha, $usuario->getSenha())) {
            $_SESSION['usuario_id'] = $usuario->getId();
            $_SESSION['usuario_nome'] = $usuario->getNome();

          
            header("Location: ../VIEW/dashboard.php");
            exit;
        } else {
          
            header("Location: ../VIEW/login.php?erro=usuario_ou_senha_incorretos");
            exit;
        }
    } else {
        header("Location: ../VIEW/login.php?erro=campos_vazios");
        exit;
    }
} else {
    
    header("Location: ../VIEW/login.php");
    exit;
}