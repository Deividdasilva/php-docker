<?php

// Definir fuso horário
date_default_timezone_set('America/Sao_Paulo');

/**
 * Classe User responsável por interagir com a tabela de usuários no banco de dados.
 */
class User {

    /**
     * @var PDO Conexão com o banco de dados
     */
    private $conn;

    /**
     * Construtor da classe.
     * 
     * @param PDO $db Conexão com o banco de dados.
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Retorna todos os usuários da tabela.
     * 
     * @return array Lista de usuários.
     */
    public function getUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Adiciona um novo usuário ao banco de dados.
     * 
     * @param string $name Nome do usuário.
     * @param string $email Email do usuário.
     * @param string $situacao Situação do usuário (Ativo/Inativo).
     * @param string $data_admissao Data de admissão do usuário.
     * @return bool Retorna true se a operação foi bem-sucedida.
     */
    public function addUser($name, $email, $situacao, $data_admissao) {
        $query = "INSERT INTO users (name, email, situacao, data_admissao, created_at) 
                  VALUES (:name, :email, :situacao, :data_admissao, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':situacao', $situacao);
        $stmt->bindParam(':data_admissao', $data_admissao);
        return $stmt->execute();
    }

    /**
     * Busca um usuário no banco de dados pelo ID.
     * 
     * @param int $id ID do usuário.
     * @return array|false Dados do usuário ou false se não encontrado.
     */
    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza os dados de um usuário no banco de dados.
     * 
     * @param int $id ID do usuário.
     * @param string $name Nome do usuário.
     * @param string $email Email do usuário.
     * @param string $situacao Situação do usuário (Ativo/Inativo).
     * @param string $data_admissao Data de admissão do usuário.
     * @return bool Retorna true se a operação foi bem-sucedida.
     */
    public function updateUser($id, $name, $email, $situacao, $data_admissao) {
        $query = "UPDATE users SET name = :name, email = :email, situacao = :situacao, data_admissao = :data_admissao, updated_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':situacao', $situacao);
        $stmt->bindParam(':data_admissao', $data_admissao);
        return $stmt->execute();
    }

    /**
     * Exclui um usuário do banco de dados.
     * 
     * @param int $id ID do usuário.
     * @return bool Retorna true se a operação foi bem-sucedida.
     */
    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
