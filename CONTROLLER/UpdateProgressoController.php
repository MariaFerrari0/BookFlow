<?php
session_start();

// Impede acessos diretos que não sejam via POST
if (!isset($_SESSION['usuario_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../VIEW/login.php");
    exit;
}

require_once __DIR__ . '/../DAL/LivroDAL.php';

$livro_id = filter_input(INPUT_POST, 'livro_id', FILTER_VALIDATE_INT);
$paginas_lidas = filter_input(INPUT_POST, 'paginas_lidas', FILTER_VALIDATE_INT);
$usuario_id = $_SESSION['usuario_id'];

if ($livro_id !== false && $paginas_lidas !== false) {
    if ($paginas_lidas < 0) {
        $paginas_lidas = 0;
    }

    $livroDAL = new LivroDAL();
    $livroDAL->atualizarProgresso($livro_id, $paginas_lidas, $usuario_id);
}

// Redireciona de volta para o dashboard de forma limpa
header("Location: ../VIEW/dashboard.php");
exit;