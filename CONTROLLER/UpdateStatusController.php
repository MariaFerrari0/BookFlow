<?php
session_start();

// Impede acessos diretos que não sejam via POST
if (!isset($_SESSION['usuario_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../VIEW/login.php");
    exit;
}

require_once __DIR__ . '/../DAL/LivroDAL.php';

$livro_id = filter_input(INPUT_POST, 'livro_id', FILTER_VALIDATE_INT);
$novoStatus = filter_input(INPUT_POST, 'status', FILTER_DEFAULT);
$usuario_id = $_SESSION['usuario_id'];

if ($livro_id !== false && $novoStatus !== null) {
    $livroDAL = new LivroDAL();
    
    // Atualiza apenas o status do livro no banco de dados
    $livroDAL->atualizarStatus($livro_id, $usuario_id, $novoStatus);
}

// Redireciona de volta para o dashboard
header("Location: ../VIEW/dashboard.php");
exit;