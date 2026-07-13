<?php
// Ativa exibição de erros para testes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Garante que apenas utilizadores logados acedem a esta página
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$id_livro = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id_livro) {
    header("Location: listar.php");
    exit;
}

// Importa a Controller de Livros
include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/CONTROLLERS/LivroController.php";
$livroController = new \CONTROLLER\LivroController();

// Busca as informações do livro pelo ID (certifique-se de que o método existe na sua Controller)
$livro = $livroController->buscarPorId($id_livro);

// Se o livro não existir ou não pertencer ao utilizador logado, redireciona de volta
if (!$livro || $livro->getIdUsuario() !== $_SESSION['usuario_id']) {
    header("Location: listar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Livro - Bookflow</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../VIEW/assets/menu.css">
    <link rel="stylesheet" href="../VIEW/assets/livros_det.css">
</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/VIEW/menu.php"; ?>

<main class="content-container">
    <div class="details-card">
        <div class="details-header">
            <div class="header-icon-area">
                <i class="material-icons book-cover-icon">menu_book</i>
            </div>
            <div class="header-text">
                <h2><?php echo htmlspecialchars($livro->getTitulo()); ?></h2>
                <p class="author">por <?php echo htmlspecialchars($livro->getAutor()); ?></p>
            </div>
        </div>

        <hr class="divider">

        <div class="details-body">
            <div class="info-row">
                <div class="info-item">
                    <i class="material-icons info-icon">auto_stories</i>
                    <div>
                        <span class="info-label">Total de Páginas</span>
                        <span class="info-value"><?php echo $livro->getPaginas(); ?> páginas</span>
                    </div>
                </div>

                <div class="info-item">
                    <i class="material-icons info-icon">bookmark</i>
                    <div>
                        <span class="info-label">Status da Leitura</span>
                        <span class="info-value badge-status <?php echo strtolower(str_replace(' ', '-', $livro->getStatusLeitura())); ?>">
                            <?php echo htmlspecialchars($livro->getStatusLeitura()); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <hr class="divider">

        <div class="details-actions">
            <a href="listar.php" class="btn-action btn-back">
                <i class="material-icons">arrow_back</i>
                <span>Voltar</span>
            </a>

            <a href="editar.php?id=<?php echo $livro->getId(); ?>" class="btn-action btn-edit">
                <i class="material-icons">edit</i>
                <span>Editar</span>
            </a>

            <button class="btn-action btn-delete" onclick="confirmarExclusao(<?php echo $livro->getId(); ?>)">
                <i class="material-icons">delete</i>
                <span>Excluir</span>
            </button>
        </div>
    </div>
</main>

<script src="../VIEW/javascript/livros_det.js" defer></script>
</body>
</html>