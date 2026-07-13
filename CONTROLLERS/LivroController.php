<?php
namespace CONTROLLER;

include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/DAL/LivroDAL.php";

use DAL\LivroDAL;

class LivroController {

    public function listarLivrosDoUsuario(int $id_usuario): array {
        $livroDAL = new LivroDAL();
        return $livroDAL->listarPorUsuario($id_usuario);
    }
}