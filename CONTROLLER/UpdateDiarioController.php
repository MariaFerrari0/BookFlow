<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../VIEW/login.php");
    exit;
}

require_once __DIR__ . '/../DAL/LivroDAL.php';
require_once __DIR__ . '/../MODEL/Diario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $livro_id = filter_input(INPUT_POST, 'livro_id', FILTER_VALIDATE_INT);
    $anotacao = isset($_POST['anotacao']) ? trim($_POST['anotacao']) : '';
    $usuario_id = (int)$_SESSION['usuario_id'];

    if ($livro_id && !empty($anotacao)) {
        $livroDAL = new LivroDAL();
        
        
        $livro = $livroDAL->buscarPorId($livro_id);
        if ($livro && $livro->getUsuarioId() === $usuario_id) {
            
           
            $sucesso = $livroDAL->adicionarAnotacaoDiario($livro_id, $anotacao);
            
            if ($sucesso) {
                header("Location: ../VIEW/dashboard.php?status=comentario_adicionado");
                exit;
            }
        }
    }
}

header("Location: ../VIEW/dashboard.php?status=erro");
exit;