<?php
session_start();


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
    
   
    $livroDAL->atualizarStatus($livro_id, $usuario_id, $novoStatus);
}


header("Location: ../VIEW/dashboard.php");
exit;