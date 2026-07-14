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
            // AJUSTE: Passando o campo 'comentarios' diretamente no construtor
            $livros[] = new Livro(
                (int)$linha['id'],
                (int)$linha['usuario_id'],
                $linha['titulo'] ?? 'Sem Título',
                $linha['autor'] ?? 'Autor Desconhecido',
                (int)($linha['paginas'] ?? 0),
                $linha['status'] ?? 'Quero ler',
                (int)($linha['paginas_lidas'] ?? 0),
                $linha['comentarios'] ?? ''
            );
        }
        
        return $livros;
    }

    // Método para buscar um único livro (necessário para o Controller validar a segurança)
    public function buscarPorId(int $id): ?Livro {
        $sql = "SELECT * FROM livros WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$linha) {
            return null;
        }

        // AJUSTE: Passando o campo 'comentarios' diretamente no construtor
        return new Livro(
            (int)$linha['id'],
            (int)$linha['usuario_id'],
            $linha['titulo'] ?? 'Sem Título',
            $linha['autor'] ?? 'Autor Desconhecido',
            (int)($linha['paginas'] ?? 0),
            $linha['status'] ?? 'Quero ler',
            (int)($linha['paginas_lidas'] ?? 0),
            $linha['comentarios'] ?? ''
        );
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

    // Método para atualizar o texto do diário de leitura (comentários)
    public function atualizarComentarios(int $id, string $comentarios, int $usuario_id): bool {
        $sql = "UPDATE livros SET comentarios = :comentarios WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':comentarios', $comentarios, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    // Insere uma nova anotação/comentário na tabela diario_leitura
    public function adicionarAnotacaoDiario(int $livro_id, string $anotacao, int $pagina_atual = 0, int $paginas_lidas = 0): bool {
        $sql = "INSERT INTO diario_leitura (livro_id, data_registro, paginas_lidas, pagina_atual, anotacao) 
                VALUES (:livro_id, :data_registro, :paginas_lidas, :pagina_atual, :anotacao)";
        
        $stmt = $this->conexao->prepare($sql);
        
        $data_hoje = date('Y-m-d'); // Captura o dia atual automaticamente
        
        $stmt->bindValue(':livro_id', $livro_id, PDO::PARAM_INT);
        $stmt->bindValue(':data_registro', $data_hoje, PDO::PARAM_STR);
        $stmt->bindValue(':paginas_lidas', $paginas_lidas, PDO::PARAM_INT);
        $stmt->bindValue(':pagina_atual', $pagina_atual, PDO::PARAM_INT);
        $stmt->bindValue(':anotacao', $anotacao, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    // Lista todas as anotações registradas para o livro ordenadas da mais nova para a mais antiga
    public function listarDiarioDoLivro(int $livro_id): array {
        $sql = "SELECT * FROM diario_leitura WHERE livro_id = :livro_id ORDER BY id DESC";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':livro_id', $livro_id, PDO::PARAM_INT);
        $stmt->execute();

        $historico = [];
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $historico[] = new Diario(
                (int)$linha['id'],
                (int)$linha['livro_id'],
                $linha['data_registro'],
                (int)$linha['paginas_lidas'],
                (int)$linha['pagina_atual'],
                $linha['anotacao']
            );
        }
        return $historico;
    }
}