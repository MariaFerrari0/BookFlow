<?php
// Garante que o menu só carrega se o utilizador estiver logado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se o utilizador não estiver logado, não exibe o menu
if (!isset($_SESSION['usuario_id'])) {
    return;
}

// Define o caminho base para a navegação das telas
$base_url = "/BookFlow/views";
?>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<link rel="stylesheet" href="../VIEW/assets/menu.css">

<aside class="sidebar">
    <div class="sidebar-header">
        <span class="logo-text">Bookflow</span>
    </div>
    
    <nav class="sidebar-menu">
        <a href="<?php echo $base_url; ?>/dashboard.php" class="menu-item">
            <i class="material-icons menu-icon">dashboard</i> Dashboard
        </a>
        
        <a href="<?php echo $base_url; ?>/livros/listar.php" class="menu-item">
            <i class="material-icons menu-icon">library_books</i> Meus Livros
        </a>
        
        <a href="<?php echo $base_url; ?>/comentarios/listar.php" class="menu-item">
            <i class="material-icons menu-icon">edit</i> Anotações
        </a>
        
        <a href="<?php echo $base_url; ?>/avaliacoes/listar.php" class="menu-item">
            <i class="material-icons menu-icon">star</i> Avaliações
        </a>
        
        <a href="<?php echo $base_url; ?>/pomodoro/index.php" class="menu-item">
            <i class="material-icons menu-icon">timer</i> Pomodoro
        </a>
        
        <a href="<?php echo $base_url; ?>/perfil/perfil.php" class="menu-item">
            <i class="material-icons menu-icon">person</i> Meu Perfil
        </a>
    </nav>
    
    <div class="sidebar-footer">
        <a href="<?php echo $base_url; ?>/login.php?logout=true" class="logout-btn">
            <i class="material-icons">exit_to_app</i> Sair
        </a>
    </div>
</aside>

<script src="../VIEW/javascript/menu.js" defer></script>