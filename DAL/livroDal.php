<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/dal/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/model/Livro.php";

use MODEL\Livro;

class LivroDAL {

    // Lista apenas os livros pertencentes ao usuário logado
    public function listarPorUsuario(int $id_usuario): array {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM livros WHERE id_usuario = ? ORDER BY titulo ASC";
        $livros = [];
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_usuario]);
            $rows = $stmt->fetchAll();
            
            foreach ($rows as $row) {
                $livros[] = new Livro(
                    $row['id_livro'],
                    $row['id_usuario'],
                    $row['titulo'],
                    $row['autor'],
                    $row['status_leitura'] ?? 'Não Lido',
                    $row['paginas'] ?? 0
                );
            }
        } catch (\PDOException $e) {
            // Pode tratar o erro aqui se necessário
        }
        return $livros;
    }
}