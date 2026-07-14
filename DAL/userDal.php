<?php
// Importa a conexão com o banco de dados
require_once __DIR__ . '/../config/database.php';

class UserDAL {
    private $db;

    public function __construct() {
        // Pega a conexão PDO que você criou no database.php
        $this->db = Database::getInstance();
    }

    // Método para cadastrar um novo usuário no banco
    public function cadastrar(User $user) {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome', $user->getNome());
        $stmt->bindValue(':email', $user->getEmail());
        // A senha deve ser salva criptografada por segurança
        $stmt->bindValue(':senha', $user->getSenha());

        return $stmt->execute();
    }

    // Método para buscar um usuário pelo e-mail (usado no login)
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $dados = $stmt->fetch();
        if (!$dados) {
            return null;
        }

        // Retorna um objeto do tipo User com os dados do banco
        return new User(
            $dados['id'],
            $dados['nome'],
            $dados['email'],
            $dados['senha']
        );
    }
}