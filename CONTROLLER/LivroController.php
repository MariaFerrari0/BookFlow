<?php
session_start();


if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../VIEW/login.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../MODEL/Livro.php';
require_once __DIR__ . '/../DAL/LivroDAL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $autor = filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_SPECIAL_CHARS);
    $paginas_total = filter_input(INPUT_POST, 'paginas_total', FILTER_SANITIZE_NUMBER_INT);
    
    $usuario_id = $_SESSION['usuario_id'];

    if ($titulo && $autor && $paginas_total) {
       
        $novoLivro = new Livro(null, $usuario_id, $titulo, $autor, $paginas_total, 'Quero ler');
        
        $livroDAL = new LivroDAL();
        
        if ($livroDAL->cadastrar($novoLivro)) {
            
            header("Location: ../VIEW/dashboard.php?cadastro_livro=sucesso");
            exit;
        } else {
            header("Location: ../VIEW/dashboard.php?erro=erro_salvar_livro");
            exit;
        }
    } else {
        header("Location: ../VIEW/dashboard.php?erro=campos_vazios");
        exit;
    }
} else {
    header("Location: ../VIEW/dashboard.php");
    exit;
}