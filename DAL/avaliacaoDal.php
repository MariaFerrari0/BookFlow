<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/model/avaliacao.php";

use MODEL\Avaliacao;

class AvaliacaoDAL {

    public function salvarAvaliacao(Avaliacao $avaliacao): bool {
        $pdo = \Conexao::getConexao();
        $sql = "INSERT INTO avaliacoes (livro_id, historia, personagem, escrita, nota_geral, comentario) 
                VALUES (:livro_id, :historia, :personagem, :escrita, :nota_geral, :comentario)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':livro_id', $avaliacao->getLivroId(), \PDO::PARAM_INT);
            $stmt->bindValue(':historia', $avaliacao->getHistoria(), \PDO::PARAM_INT);
            $stmt->bindValue(':personagem', $avaliacao->getPersonagem(), \PDO::PARAM_INT);
            $stmt->bindValue(':escrita', $avaliacao->getEscrita(), \PDO::PARAM_INT);
            $stmt->bindValue(':nota_geral', $avaliacao->getNotaGeral(), \PDO::PARAM_INT);
            $stmt->bindValue(':comentario', $avaliacao->getComentario());
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function listarAvaliacoes(int $usuario_id): array {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT a.* FROM avaliacoes a INNER JOIN livros l ON a.livro_id = l.id WHERE l.usuario_id = ?";
        $avaliacoes = [];
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            $rows = $stmt->fetchAll();
            foreach ($rows as $row) {
                $avaliacoes[] = new Avaliacao(
                    $row['id'], $row['livro_id'], (int)$row['historia'], (int)$row['personagem'],
                    (int)$row['escrita'], (int)$row['nota_geral'], $row['comentario']
                );
            }
        } catch (\PDOException $e) {}
        return $avaliacoes;
    }

    public function buscarAvaliacao(int $livro_id): ?Avaliacao {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM avaliacoes WHERE livro_id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$livro_id]);
            $row = $stmt->fetch();
            if ($row) {
                return new Avaliacao(
                    $row['id'], $row['livro_id'], (int)$row['historia'], (int)$row['personagem'],
                    (int)$row['escrita'], (int)$row['nota_geral'], $row['comentario']
                );
            }
            return null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function editarAvaliacao(Avaliacao $avaliacao): bool {
        $pdo = \Conexao::getConexao();
        $sql = "UPDATE avaliacoes SET historia = :historia, personagem = :personagem, escrita = :escrita, 
                nota_geral = :nota_geral, comentario = :comentario WHERE id = :id";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':historia', $avaliacao->getHistoria(), \PDO::PARAM_INT);
            $stmt->bindValue(':personagem', $avaliacao->getPersonagem(), \PDO::PARAM_INT);
            $stmt->bindValue(':escrita', $avaliacao->getEscrita(), \PDO::PARAM_INT);
            $stmt->bindValue(':nota_geral', $avaliacao->getNotaGeral(), \PDO::PARAM_INT);
            $stmt->bindValue(':comentario', $avaliacao->getComentario());
            $stmt->bindValue(':id', $avaliacao->getId(), \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function excluirAvaliacao(int $id): bool {
        $pdo = \Conexao::getConexao();
        $sql = "DELETE FROM avaliacoes WHERE id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function mediaLivro(int $livro_id): float {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT AVG(nota_geral) as media FROM avaliacoes WHERE livro_id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$livro_id]);
            $row = $stmt->fetch();
            return $row['media'] ? (float)$row['media'] : 0.0;
        } catch (\PDOException $e) {
            return 0.0;
        }
    }
}
?>