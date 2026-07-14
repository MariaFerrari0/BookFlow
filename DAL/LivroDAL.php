<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../MODEL/Livro.php';

class LivroDAL {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Database::getInstance();
    }

    // Método para cadastrar um novo livro no banco de dados
    public function cadastrar(Livro $livro): bool {
        // Ajustado de acordo com a sua tabela real: usa 'paginas'
        $sql = "INSERT INTO livros (usuario_id, titulo, autor, paginas, status) 
                VALUES (:usuario_id, :titulo, :autor, :paginas, :status)";
        
        $stmt = $this->conexao->prepare($sql);
        
        $stmt->bindValue(':usuario_id', $livro->getUsuarioId(), PDO::PARAM_INT);
        $stmt->bindValue(':titulo', $livro->getTitulo(), PDO::PARAM_STR);
        $stmt->bindValue(':autor', $livro->getAutor(), PDO::PARAM_STR);
        $stmt->bindValue(':paginas', $livro->getPaginasTotal(), PDO::PARAM_INT);
        $stmt->bindValue(':status', $livro->getStatus(), PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    // Método para buscar todos os livros de um usuário específico
    public function listarPorUsuario(int $usuario_id): array {
        $sql = "SELECT * FROM livros WHERE usuario_id = :usuario_id ORDER BY id DESC";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $livros = [];
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $livros[] = new Livro(
                (int)$linha['id'],
                (int)$linha['usuario_id'],
                $linha['titulo'] ?? 'Sem Título',
                $linha['autor'] ?? 'Autor Desconhecido',
                (int)($linha['paginas'] ?? 0), // Usando 'paginas' vindo do banco
                $linha['status'] ?? 'Quero ler',
                (int)($linha['paginas_lidas'] ?? 0) // <-- ADICIONADO: Puxa o progresso do banco!
            );
        }
        
        return $livros;
    }

    // Método para atualizar apenas o status de um livro específico
    public function atualizarStatus(int $livro_id, int $usuario_id, string $novoStatus): bool {
        $sql = "UPDATE livros SET status = :status WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->conexao->prepare($sql);
        
        $stmt->bindValue(':status', $novoStatus, PDO::PARAM_STR);
        $stmt->bindValue(':id', $livro_id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Método para deletar um livro
    public function excluir(int $id, int $usuario_id): bool {
        $sql = "DELETE FROM livros WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Método para salvar o progresso das páginas lidas
    public function atualizarProgresso(int $id, int $paginasLidas, int $usuario_id): bool {
        $sql = "UPDATE livros SET paginas_lidas = :paginas_lidas WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':paginas_lidas', $paginasLidas, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}