<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/model/comentario.php";

use MODEL\Comentario;

class ComentarioDAL {

    public function adicionarComentario(Comentario $comentario): bool {
        $pdo = \Conexao::getConexao();
        $sql = "INSERT INTO comentarios (livro_id, comentario, pagina, data) VALUES (:livro_id, :comentario, :pagina, :data)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':livro_id', $comentario->getLivroId(), \PDO::PARAM_INT);
            $stmt->bindValue(':comentario', $comentario->getComentario());
            $stmt->bindValue(':pagina', $comentario->getPagina(), \PDO::PARAM_INT);
            $data = $comentario->getData() ?: date('Y-m-d H:i:s');
            $stmt->bindValue(':data', $data);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function listarComentarios(int $livro_id): array {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM comentarios WHERE livro_id = ? ORDER BY pagina ASC, data DESC";
        $comentarios = [];
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$livro_id]);
            $rows = $stmt->fetchAll();
            foreach ($rows as $row) {
                $comentarios[] = new Comentario(
                    $row['id'], $row['livro_id'], $row['comentario'], (int)$row['pagina'], $row['data']
                );
            }
        } catch (\PDOException $e) {}
        return $comentarios;
    }

    public function buscarComentario(int $id): ?Comentario {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM comentarios WHERE id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row) {
                return new Comentario(
                    $row['id'], $row['livro_id'], $row['comentario'], (int)$row['pagina'], $row['data']
                );
            }
            return null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function editarComentario(Comentario $comentario): bool {
        $pdo = \Conexao::getConexao();
        $sql = "UPDATE comentarios SET comentario = :comentario, pagina = :pagina WHERE id = :id";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':comentario', $comentario->getComentario());
            $stmt->bindValue(':pagina', $comentario->getPagina(), \PDO::PARAM_INT);
            $stmt->bindValue(':id', $comentario->getId(), \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function excluirComentario(int $id): bool {
        $pdo = \Conexao::getConexao();
        $sql = "DELETE FROM comentarios WHERE id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            return false;
        }
    }
}
?>