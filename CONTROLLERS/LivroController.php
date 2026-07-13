<?php
namespace CONTROLLER;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/LivroDAL.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/model/livro.php";

use DAL\LivroDAL;
use MODEL\Livro;

class LivroController {
    private LivroDAL $dal;

    public function __construct() {
        $this->dal = new LivroDAL();
    }

    public function cadastrarLivro(
        int $usuario_id, string $titulo, string $autor, string $editora, 
        string $genero, int $paginas, int $pag_atual, string $status, 
        float $nota, string $capa, string $sinopse
    ): bool {
        if (empty($titulo) || empty($autor) || $paginas <= 0) {
            return false;
        }

        $livro = new Livro(
            null, $usuario_id, $titulo, $autor, $editora, 
            $genero, $paginas, $pag_atual, $status, $nota, $capa, $sinopse
        );
        return $this->dal->cadastrarLivro($livro);
    }

    public function listarLivros(int $usuario_id): array {
        return $this->dal->listarLivros($usuario_id);
    }

    public function buscarLivro(int $id): ?Livro {
        return $this->dal->buscarLivro($id);
    }

    public function buscarPorStatus(int $usuario_id, string $status): array {
        return $this->dal->buscarPorStatus($usuario_id, $status);
    }

    public function buscarFavoritos(int $usuario_id): array {
        return $this->dal->buscarFavoritos($usuario_id);
    }

    public function editarLivro(
        int $id, string $titulo, string $autor, string $editora, 
        string $genero, int $paginas, int $pag_atual, string $status, 
        float $nota, string $capa, string $sinopse
    ): bool {
        if (empty($titulo) || empty($autor) || $paginas <= 0) {
            return false;
        }

        $livro = new Livro(
            $id, null, $titulo, $autor, $editora, 
            $genero, $paginas, $pag_atual, $status, $nota, $capa, $sinopse
        );
        return $this->dal->editarLivro($livro);
    }

    public function alterarStatus(int $id, string $status): bool {
        return $this->dal->alterarStatus($id, $status);
    }

    public function atualizarPagina(int $id, int $pag_atual): bool {
        $livro = $this->dal->buscarLivro($id);
        if ($livro === null || $pag_atual < 0 || $pag_atual > $livro->getPaginas()) {
            return false; // Página inválida
        }
        
        // Se a página atual atingir o limite de páginas, muda o status para 'Lido' automaticamente
        if ($pag_atual === $livro->getPaginas()) {
            $this->dal->alterarStatus($id, 'Lido');
        }

        return $this->dal->atualizarPagina($id, $pag_atual);
    }

    public function excluirLivro(int $id): bool {
        return $this->dal->excluirLivro($id);
    }

    public function contarLivros(int $usuario_id): int {
        return $this->dal->contarLivros($usuario_id);
    }

    public function contarLidos(int $usuario_id): int {
        return $this->dal->contarLidos($usuario_id);
    }

    public function contarLendo(int $usuario_id): int {
        return $this->dal->contarLendo($usuario_id);
    }

    public function contarQueroLer(int $usuario_id): int {
        return $this->dal->contarQueroLer($usuario_id);
    }
}
?>