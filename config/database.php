<?php

// Definir fuso horário
date_default_timezone_set('America/Sao_Paulo');

/**
 * Classe Database responsável pela conexão com o banco de dados.
 */
class Database {

    /**
     * @var string Host do banco de dados
     */
    private $host = "mysql";

    /**
     * @var string Nome do banco de dados
     */
    private $db_name = "phpdocker";

    /**
     * @var string Nome de usuário para conectar ao banco de dados
     */
    private $username = "root";

    /**
     * @var string Senha para conectar ao banco de dados
     */
    private $password = "root";

    /**
     * @var PDO|null Conexão com o banco de dados
     */
    public $conn;

    /**
     * Método responsável por estabelecer a conexão com o banco de dados.
     *
     * @return PDO|null Retorna a conexão PDO ou null em caso de falha.
     */
    public function connect() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
