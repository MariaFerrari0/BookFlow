<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/conexao.php";

class DashboardDAL {

    public function totalLivros(int $usuario_id): int {
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

    public function totalLidos(int $usuario_id): int {
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

    public function totalLendo(int $usuario_id): int {
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

    public function totalQueroLer(int $usuario_id): int {
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

    public function tempoLeitura(int $usuario_id): int {
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

    public function paginasLidas(int $usuario_id): int {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT SUM(pag_atual) FROM livros WHERE usuario_id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0;
        }
    }

    public function livroMaisLido(int $usuario_id): ?string {
        $pdo = \Conexao::getConexao();
        // Livro com mais minutos registrados no Pomodoro
        $sql = "SELECT l.titulo, SUM(p.minutos) as total_min FROM pomodoros p 
                INNER JOIN livros l ON p.livro_id = l.id 
                WHERE l.usuario_id = ? 
                GROUP BY l.id 
                ORDER BY total_min DESC LIMIT 1";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            $row = $stmt->fetch();
            return $row ? $row['titulo'] : null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function mediaAvaliacoes(int $usuario_id): float {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT AVG(a.nota_geral) FROM avaliacoes a 
                INNER JOIN livros l ON a.livro_id = l.id 
                WHERE l.usuario_id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return (float)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            return 0.0;
        }
    }
}
?>
?>