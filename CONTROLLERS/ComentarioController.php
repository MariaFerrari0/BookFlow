<?php
namespace CONTROLLER;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/ComentarioDAL.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/model/comentario.php";

use DAL\ComentarioDAL;
use MODEL\Comentario;

class ComentarioController {
    private ComentarioDAL $dal;

    public function __construct() {
        $this->dal = new ComentarioDAL();
    }

    public function adicionarComentario(int $livro_id, string $comentarioText, int $pagina): bool {
        if (empty($comentarioText) || $pagina < 0) {
            return false;
        }

        $comentario = new Comentario(null, $livro_id, $comentarioText, $pagina, date('Y-m-d H:i:s'));
        return $this->dal->adicionarComentario($comentario);
    }

    public function listarComentarios(int $livro_id): array {
        return $this->dal->listarComentarios($livro_id);
    }

    public function buscarComentario(int $id): ?Comentario {
        return $this->dal->buscarComentario($id);
    }

    public function editarComentario(int $id, string $comentarioText, int $pagina): bool {
        if (empty($comentarioText) || $pagina < 0) {
            return false;
        }

        $comentario = new Comentario($id, null, $comentarioText, $pagina);
        return $this->dal->editarComentario($comentario);
    }

    public function excluirComentario(int $id): bool {
        return $this->dal->excluirComentario($id);
    }
}
?>