<?php
session_start();

// Garante que apenas usuários logados via requisição POST acessem
if (!isset($_SESSION['usuario_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../VIEW/login.php");
    exit;
}

require_once __DIR__ . '/../DAL/LivroDAL.php';

$livro_id = filter_input(INPUT_POST, 'livro_id', FILTER_VALIDATE_INT);
$usuario_id = $_SESSION['usuario_id'];

if ($livro_id) {
    $livroDAL = new LivroDAL();
    $livroDAL->excluir($livro_id, $usuario_id);
}

// Redireciona de volta para o dashboard atualizado
header("Location: ../VIEW/dashboard.php");
exit;