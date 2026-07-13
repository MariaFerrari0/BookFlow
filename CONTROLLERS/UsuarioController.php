<?php
namespace CONTROLLER;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/UsuarioDAL.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/model/usuario.php";

use DAL\UsuarioDAL;
use MODEL\Usuario;

class UsuarioController {
    private UsuarioDAL $dal;

    public function __construct() {
        $this->dal = new UsuarioDAL();
    }

    public function cadastrar(string $nome, string $email, string $senha, string $cargo = 'leitor'): bool {
        if (empty($nome) || empty($email) || empty($senha)) {
            return false;
        }
        
        // Verifica se o email já existe cadastrado
        if ($this->dal->buscarPorEmail($email) !== null) {
            return false; // Email já em uso
        }

        $usuario = new Usuario(null, $nome, $email, $senha, $cargo);
        return $this->dal->cadastrar($usuario);
    }

    public function login(string $email, string $senha): bool {
        if (empty($email) || empty($senha)) {
            return false;
        }

        $usuario = $this->dal->login($email, $senha);
        if ($usuario !== null) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            // Guarda as informações básicas na sessão do utilizador
            $_SESSION['usuario_id'] = $usuario->getIdUsuario();
            $_SESSION['usuario_nome'] = $usuario->getNome();
            $_SESSION['usuario_email'] = $usuario->getEmail();
            $_SESSION['usuario_cargo'] = $usuario->getCargo();
            return true;
        }
        return false;
    }

    public function deslogar(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
    }

    public function listar(): array {
        return $this->dal->listar();
    }

    public function buscarPorId(int $id_usuario): ?Usuario {
        return $this->dal->buscarPorId($id_usuario);
    }

    public function atualizar(int $id_usuario, string $nome, string $email, string $cargo): bool {
        if (empty($nome) || empty($email)) {
            return false;
        }

        // Verifica se o email novo já é usado por outro utilizador
        $existente = $this->dal->buscarPorEmail($email);
        if ($existente !== null && $existente->getIdUsuario() !== $id_usuario) {
            return false; 
        }

        $usuario = new Usuario($id_usuario, $nome, $email, '', $cargo);
        return $this->dal->atualizar($usuario);
    }

    public function alterarSenha(int $id_usuario, string $nova_senha): bool {
        if (empty($nova_senha) || strlen($nova_senha) < 6) {
            return false; // Senha muito curta
        }
        return $this->dal->alterarSenha($id_usuario, $nova_senha);
    }

    public function excluir(int $id_usuario): bool {
        return $this->dal->excluir($id_usuario);
    }
}
?>