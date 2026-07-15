<?php
require_once __DIR__ . '/../config/database.php';

class UserDAL {
    private $db;

    public function __construct() {
        
        $this->db = Database::getInstance();
    }

    
    public function cadastrar(User $user) {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome', $user->getNome());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':senha', $user->getSenha());

        return $stmt->execute();
    }

   
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $dados = $stmt->fetch();
        if (!$dados) {
            return null;
        }

       
        return new User(
            $dados['id'],
            $dados['nome'],
            $dados['email'],
            $dados['senha']
        );
    }
}