<?php
session_start();

// Segurança: Se o usuário não estiver logado, não deixa processar
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../VIEW/login.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../MODEL/Livro.php';
require_once __DIR__ . '/../DAL/LivroDAL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitiza as entradas de texto
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $autor = filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_SPECIAL_CHARS);
    $paginas_total = filter_input(INPUT_POST, 'paginas_total', FILTER_SANITIZE_NUMBER_INT);
    
    $usuario_id = $_SESSION['usuario_id']; // Pega o ID de quem está logado

    if ($titulo && $autor && $paginas_total) {
        // Cria o objeto Livro (id inicial é null, páginas lidas começa em 0)
        $novoLivro = new Livro(null, $usuario_id, $titulo, $autor, $paginas_total, 'Quero ler');
        
        $livroDAL = new LivroDAL();
        
        if ($livroDAL->cadastrar($novoLivro)) {
            // Sucesso! Redireciona de volta para o dashboard
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