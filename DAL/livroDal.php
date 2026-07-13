<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/model/livro.php";

use MODEL\Livro;

class LivroDAL {

    public function cadastrarLivro(Livro $livro): bool {
        $pdo = \Conexao::getConexao();
        $sql = "INSERT INTO livros (usuario_id, titulo, autor, editora, genero, paginas, pag_atual, status, nota, capa, sinopse) 
                VALUES (:usuario_id, :titulo, :autor, :editora, :genero, :paginas, :pag_atual, :status, :nota, :capa, :sinopse)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':usuario_id', $livro->getUsuarioId(), \PDO::PARAM_INT);
            $stmt->bindValue(':titulo', $livro->getTitulo());
            $stmt->bindValue(':autor', $livro->getAutor());
            $stmt->bindValue(':editora', $livro->getEditora());
            $stmt->bindValue(':genero', $livro->getGenero());
            $stmt->bindValue(':paginas', $livro->getPaginas(), \PDO::PARAM_INT);
            $stmt->bindValue(':pag_atual', $livro->getPagAtual(), \PDO::PARAM_INT);
            $stmt->bindValue(':status', $livro->getStatus());
            $stmt->bindValue(':nota', $livro->getNota());
            $stmt->bindValue(':capa', $livro->getCapa());
            $stmt->bindValue(':sinopse', $livro->getSinopse());
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function listarLivros(int $usuario_id): array {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM livros WHERE usuario_id = ? ORDER BY titulo ASC";
        $livros = [];
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            $rows = $stmt->fetchAll();
            foreach ($rows as $row) {
                $livros[] = new Livro(
                    $row['id'], $row['usuario_id'], $row['titulo'], $row['autor'], $row['editora'],
                    $row['genero'], $row['paginas'], $row['pag_atual'], $row['status'],
                    (float)$row['nota'], $row['capa'], $row['sinopse']
                );
            }
        } catch (\PDOException $e) {}
        return $livros;
    }

    public function buscarLivro(int $id): ?Livro {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM livros WHERE id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                return new Livro(
                    $row['id'], $row['usuario_id'], $row['titulo'], $row['autor'], $row['editora'],
                    $row['genero'], $row['paginas'], $row['pag_atual'], $row['status'],
                    (float)$row['nota'], $row['capa'], $row['sinopse']
                );
            }
            return null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function buscarPorStatus(int $usuario_id, string $status): array {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM livros WHERE usuario_id = ? AND status = ?";
        $livros = [];
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id, $status]);
            $rows = $stmt->fetchAll();
            foreach ($rows as $row) {
                $livros[] = new Livro(
                    $row['id'], $row['usuario_id'], $row['titulo'], $row['autor'], $row['editora'],
                    $row['genero'], $row['paginas'], $row['pag_atual'], $row['status'],
                    (float)$row['nota'], $row['capa'], $row['sinopse']
                );
            }
        } catch (\PDOException $e) {}
        return $livros;
    }

    public function buscarFavoritos(int $usuario_id): array {
        $pdo = \Conexao::getConexao();
        // Assume favoritos como livros com nota máxima (ex: 5)
        $sql = "SELECT * FROM livros WHERE usuario_id = ? AND nota = 5";
        $livros = [];
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            $rows = $stmt->fetchAll();
            foreach ($rows as $row) {
                $livros[] = new Livro(
                    $row['id'], $row['usuario_id'], $row['titulo'], $row['autor'], $row['editora'],
                    $row['genero'], $row['paginas'], $row['pag_atual'], $row['status'],
                    (float)$row['nota'], $row['capa'], $row['sinopse']
                );
            }
        } catch (\PDOException $e) {}
        return $livros;
    }

    public function editarLivro(Livro $livro): bool {
        $pdo = \Conexao::getConexao();
        $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, editora = :editora, genero = :genero, 
                paginas = :paginas, pag_atual = :pag_atual, status = :status, nota = :nota, capa = :capa, sinopse = :sinopse 
                WHERE id = :id";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':titulo', $livro->getTitulo());
            $stmt->bindValue(':autor', $livro->getAutor());
            $stmt->bindValue(':editora', $livro->getEditora());
            $stmt->bindValue(':genero', $livro->getGenero());
            $stmt->bindValue(':paginas', $livro->getPaginas(), \PDO::PARAM_INT);
            $stmt->bindValue(':pag_atual', $livro->getPagAtual(), \PDO::PARAM_INT);
            $stmt->bindValue(':status', $livro->getStatus());
            $stmt->bindValue(':nota', $livro->getNota());
            $stmt->bindValue(':capa', $livro->getCapa());
            $stmt->bindValue(':sinopse', $livro->getSinopse());
            $stmt->bindValue(':id', $livro->getId(), \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function alterarStatus(int $id, string $status): bool {
        $pdo = \Conexao::getConexao();
        $sql = "UPDATE livros SET status = ? WHERE id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$status, $id]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function atualizarPagina(int $id, int $pag_atual): bool {
        $pdo = \Conexao::getConexao();
        $sql = "UPDATE livros SET pag_atual = ? WHERE id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$pag_atual, $id]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function excluirLivro(int $id): bool {
        $pdo = \Conexao::getConexao();
        $sql = "DELETE FROM livros WHERE id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function contarLivros(int $usuario_id): int {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT COUNT(*) FROM livros WHERE usuario_id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }

    public function contarLidos(int $usuario_id): int {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT COUNT(*) FROM livros WHERE usuario_id = ? AND status = 'Lido'";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }

    public function contarLendo(int $usuario_id): int {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT COUNT(*) FROM livros WHERE usuario_id = ? AND status = 'Lendo'";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }

    public function contarQueroLer(int $usuario_id): int {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT COUNT(*) FROM livros WHERE usuario_id = ? AND status = 'Quero Ler'";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }
}
?>