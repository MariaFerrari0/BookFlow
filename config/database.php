<?php

class Database {
    private static $instance = null;
    private $conn;

    // Configurações do seu banco de dados local
    private $host = "localhost";
    private $db_name = "bookflow";
    private $username = "root";
    private $password = ""; // Se usar MAMP no Mac, a senha geralmente é "root"

    // O construtor é privado para impedir que outras partes do código criem conexões duplicadas
    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            // Habilita o PDO a lançar erros caso haja algum problema na query
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Configura para que os retornos do banco venham sempre como um array associativo limpo
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro ao conectar ao BookFlow: " . $e->getMessage());
        }
    }

    // Este método estático garante que apenas UMA conexão seja aberta por requisição
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->getConnection();
    }

    public function getConnection() {
        return $this->conn;
    }
}