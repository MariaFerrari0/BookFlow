<?php
namespace DAL;

include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/dal/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/Bookflow/model/usuario.php";

use MODEL\Usuario;

class UsuarioDAL {

    public function cadastrar(Usuario $usuario): bool {
        $pdo = \Conexao::getConexao();
        $sql = "INSERT INTO usuarios (nome, email, senha, cargo) VALUES (:nome, :email, :senha, :cargo)";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':nome', $usuario->getNome());
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->bindValue(':senha', md5($usuario->getSenha())); // Mantendo md5 conforme seu padrão anterior
            $stmt->bindValue(':cargo', $usuario->getCargo());
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function login(string $email, string $senha): ?Usuario {
        $pdo = \Conexao::getConexao();
        $senha_criptografada = md5($senha);
        $sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email, $senha_criptografada]);
            $row = $stmt->fetch();
            if ($row) {
                return new Usuario(
                    $row['id_usuario'],
                    $row['nome'],
                    $row['email'],
                    $row['senha'],
                    $row['cargo'],
                    $row['criado_em']
                );
            }
            return null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function listar(): array {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM usuarios ORDER BY nome ASC";
        $usuarios = [];
        try {
            $stmt = $pdo->query($sql);
            $rows = $stmt->fetchAll();
            foreach ($rows as $row) {
                $usuarios[] = new Usuario(
                    $row['id_usuario'],
                    $row['nome'],
                    $row['email'],
                    $row['senha'],
                    $row['cargo'],
                    $row['criado_em']
                );
            }
        } catch (\PDOException $e) {}
        return $usuarios;
    }

    public function buscarPorId(int $id_usuario): ?Usuario {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_usuario]);
            $row = $stmt->fetch();
            if ($row) {
                return new Usuario(
                    $row['id_usuario'],
                    $row['nome'],
                    $row['email'],
                    $row['senha'],
                    $row['cargo'],
                    $row['criado_em']
                );
            }
            return null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function buscarPorEmail(string $email): ?Usuario {
        $pdo = \Conexao::getConexao();
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $row = $stmt->fetch();
            if ($row) {
                return new Usuario(
                    $row['id_usuario'],
                    $row['nome'],
                    $row['email'],
                    $row['senha'],
                    $row['cargo'],
                    $row['criado_em']
                );
            }
            return null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function atualizar(Usuario $usuario): bool {
        $pdo = \Conexao::getConexao();
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, cargo = :cargo WHERE id_usuario = :id_usuario";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':nome', $usuario->getNome());
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->bindValue(':cargo', $usuario->getCargo());
            $stmt->bindValue(':id_usuario', $usuario->getIdUsuario(), \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function alterarSenha(int $id_usuario, string $nova_senha): bool {
        $pdo = \Conexao::getConexao();
        $sql = "UPDATE usuarios SET senha = ? WHERE id_usuario = ?";
        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([md5($nova_senha), $id_usuario]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function excluir(int $id_usuario): bool {
        $pdo = \Conexao::getConexao();
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$id_usuario]);
        } catch (\PDOException $e) {
            return false;
        }
    }
}
?>
?>