<?php
class Conexao {
    private static ?PDO $conexao = null;

    public static function getConexao(): PDO {
        if (self::$conexao === null) {
            try {
                self::$conexao = new PDO(
                    "mysql:host=localhost;dbname=bookflow;charset=utf8",
                    "root",
                    "",
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$conexao;
    }
}
?>