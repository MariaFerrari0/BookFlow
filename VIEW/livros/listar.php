<?php
// 1. Protege a página garantindo que só utilizadores logados acedem
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /BookFlow/VIEW/login.php");
    exit;
}

// 2. Importa a Controller
include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/CONTROLLERS/LivroController.php";
$livroController = new \CONTROLLER\LivroController();

// 3. Busca apenas os livros do utilizador que está atualmente logado na sessão
$id_usuario_logado = $_SESSION['usuario_id'];
$meusLivros = $livroController->listarLivrosDoUsuario($id_usuario_logado);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Livros - BookFlow</title>
    <link rel="stylesheet" href="/BookFlow/VIEW/assets/style.css">
    <link rel="stylesheet" href="/BookFlow/VIEW/assets/livros.css">
</head>
<body>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/VIEW/menu.php"; ?>

    <div class="container-conteudo">
        <header class="header-pagina">
            <h1>Minha Estante Virtual</h1>
            <p>Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>! Gerencie as suas leituras abaixo.</p>
            <a href="cadastrar_livro.php" class="btn-adicionar">+ Adicionar Novo Livro</a>
        </header>

        <main class="tabela-container">
            <?php if (empty($meusLivros)): ?>
                <div class="alerta-vazio">
                    <p>Você ainda não adicionou nenhum livro à sua estante.</p>
                    <a href="cadastrar_livro.php">Comece adicionando o seu primeiro livro!</a>
                </div>
            <?php else: ?>
                <table class="tabela-livros">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Páginas</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meusLivros as $livro): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($livro->getTitulo()); ?></strong></td>
                                <td><?php echo htmlspecialchars($livro->getAutor()); ?></td>
                                <td><?php echo $livro->getPaginas() > 0 ? $livro->getPaginas() . ' pág.' : 'Não informado'; ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $livro->getStatusLeitura())); ?>">
                                        <?php echo htmlspecialchars($livro->getStatusLeitura()); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="editar_livro.php?id=<?php echo $livro->getIdLivro(); ?>" class="btn-editar">Editar</a>
                                    <a href="excluir_livro.php?id=<?php echo $livro->getIdLivro(); ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja remover este livro?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
    </div>

</body>
</html>