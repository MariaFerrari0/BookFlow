<?php
namespace CONTROLLER;

include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/DAL/usuarioDAL.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/BookFlow/MODEL/Usuario.php";

use DAL\UsuarioDAL;
use MODEL\Usuario;

class UsuarioController {

    public function cadastrar(string $nome, string $email, string $senha): bool {
        $usuarioDAL = new UsuarioDAL();

        // Verifica se o e-mail já está cadastrado antes de prosseguir
        if ($usuarioDAL->buscarPorEmail($email) !== null) {
            return false;
        }

        // Cria a model e define os atributos
        $usuario = new Usuario();
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha($senha); // Lembre-se: a criptografia md5() será aplicada pela DAL no insert

        return $usuarioDAL->cadastrar($usuario);
    }

    public function login(string $email, string $senha): ?Usuario {
        $usuarioDAL = new UsuarioDAL();
        // A DAL se encarrega de comparar as senhas usando md5()
        return $usuarioDAL->login($email, $senha);
    }
}
?>