<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/model/pomodoro.php";

use MODEL\Pomodoro;

class PomodoroDAL {

    public function iniciarSessao(Pomodoro $pomodoro): bool {
        $pdo = \Conexao::getConexao();
        $sql = "INSERT INTO pomodoros (livro_id, inicio, minutos) VALUES (:livro_id, :inicio, :minutos)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':livro_id', $pomodoro->getLivroId(), \PDO::PARAM_INT);
            $stmt->bindValue(':inicio', $pomodoro->getInicio());
            $stmt->bindValue(':minutos', 0, \PDO::PARAM_INT); // Começa zerado
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function encerrarSessao(int $id, string $fim, int $minutos): bool {
        $pdo = \Conexao::getConexao();
        $sql = "UPDATE pomodoros SET fim = ?, minutos = ? WHERE id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$fim, $minutos, $id]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function listarSessoes(int $livro_id): array {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM pomodoros WHERE livro_id = ? ORDER BY inicio DESC";
        $pomodoros = [];
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$livro_id]);
            $rows = $stmt->fetchAll();
            foreach ($rows as $row) {
                $pomodoros[] = new Pomodoro(
                    $row['id'], $row['livro_id'], $row['inicio'], $row['fim'], (int)$row['minutos']
                );
            }
        } catch (\PDOException $e) {}
        return $pomodoros;
    }

    public function tempoTotal(int $usuario_id): int {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT SUM(p.minutos) FROM pomodoros p INNER JOIN livros l ON p.livro_id = l.id WHERE l.usuario_id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }

    public function tempoHoje(int $usuario_id): int {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT SUM(p.minutos) FROM pomodoros p INNER JOIN livros l ON p.livro_id = l.id 
                WHERE l.usuario_id = ? AND DATE(p.inicio) = CURDATE()";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }

    public function tempoSemana(int $usuario_id): int {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT SUM(p.minutos) FROM pomodoros p INNER JOIN livros l ON p.livro_id = l.id 
                WHERE l.usuario_id = ? AND p.inicio >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }

    public function tempoMes(int $usuario_id): int {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT SUM(p.minutos) FROM pomodoros p INNER JOIN livros l ON p.livro_id = l.id 
                WHERE l.usuario_id = ? AND MONTH(p.inicio) = MONTH(NOW()) AND YEAR(p.inicio) = YEAR(NOW())";
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