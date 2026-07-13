<?php

// Ativa exibição de erros para testes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Garante que apenas utilizadores logados acessam esta página
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$mensagem = "";
$status = ""; // 'sucesso' ou 'erro'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/controllers/LivroController.php";
    $livroController = new \CONTROLLER\LivroController();

    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $paginas = intval($_POST['paginas'] ?? 0);
    $status_leitura = trim($_POST['status_leitura'] ?? 'Quero Ler');
    $usuario_id = $_SESSION['usuario_id']; // Vincula o livro ao utilizador logado

    if (!empty($titulo) && !empty($autor) && $paginas > 0) {
        $sucesso = $livroController->cadastrar($titulo, $autor, $paginas, $status_leitura, $usuario_id);

        if ($sucesso) {
            $mensagem = "Livro cadastrado com sucesso!";
            $status = "sucesso";
        } else {
            $mensagem = "Erro ao cadastrar o livro. Tente novamente.";
            $status = "erro";
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos corretamente!";
        $status = "erro";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livro - Bookflow</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/menu.css">
    <link rel="stylesheet" href="../../assets/css/livros.css">
</head>
<body>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/views/menu.php"; ?>

<main class="content-container">
    <div class="form-card">
        <div class="card-header">
            <i class="material-icons title-icon">library_add</i>
            <h2>Cadastrar Novo Livro</h2>
            <p>Adicione um novo livro à sua estante virtual</p>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="alert <?php echo $status; ?>">
                <i class="material-icons alert-icon">
                    <?php echo $status === 'sucesso' ? 'check_circle' : 'error'; ?>
                </i>
                <span><?php echo $mensagem; ?></span>
            </div>
        <?php endif; ?>

        <form action="cadastrar.php" method="POST" id="formCadastrarLivro">
            <div class="form-group">
                <label for="titulo">Título do Livro</label>
                <div class="input-with-icon">
                    <i class="material-icons input-icon">book</i>
                    <input type="text" id="titulo" name="titulo" placeholder="Ex: O Pequeno Príncipe" required>
                </div>
            </div>

            <div class="form-group">
                <label for="autor">Autor</label>
                <div class="input-with-icon">
                    <i class="material-icons input-icon">person</i>
                    <input type="text" id="autor" name="autor" placeholder="Ex: Antoine de Saint-Exupéry" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="paginas">Total de Páginas</label>
                    <div class="input-with-icon">
                        <i class="material-icons input-icon">auto_stories</i>
                        <input type="number" id="paginas" name="paginas" min="1" placeholder="Ex: 120" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status_leitura">Status da Leitura</label>
                    <div class="input-with-icon">
                        <i class="material-icons input-icon">playlist_add_check</i>
                        <select id="status_leitura" name="status_leitura" required>
                            <option value="Quero Ler">Quero Ler</option>
                            <option value="Lendo">Lendo</option>
                            <option value="Lido">Lido</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn-primary">
                    <i class="material-icons btn-icon">save</i>
                    <span>Salvar Livro</span>
                </button>
                <a href="listar.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</main>

<script src="../../assets/js/livros.js" defer></script>
</body>
</html>