<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../../config/database.php';

// Definir fuso horário
date_default_timezone_set('America/Sao_Paulo');

/**
 * Controlador responsável por gerenciar operações relacionadas aos usuários.
 */
class UserController {

    /**
     * @var PDO $db Instância de conexão com o banco de dados.
     */
    private $db;

    /**
     * @var User $userModel Instância do modelo User para manipular os dados de usuário.
     */
    private $userModel;

    /**
     * Construtor da classe UserController.
     * Inicializa a conexão com o banco de dados e o modelo User.
     */
    public function __construct() {
        $this->db = (new Database())->connect();
        $this->userModel = new User($this->db);
    }

    /**
     * Exibe a lista de usuários.
     *
     * @return void
     */
    public function index() {
        try {
            $users = $this->userModel->getUsers();
            include '../app/Views/users/index.php';
        } catch (Exception $e) {
            echo "Erro ao carregar os usuários: " . $e->getMessage();
        }
    }

    /**
     * Exibe o formulário de criação de um novo usuário.
     *
     * @return void
     */
    public function create() {
        include '../app/Views/users/create.php'; 
    }

    /**
     * Armazena um novo usuário no banco de dados.
     *
     * @return void
     */
    public function store() {
        if ($this->validatePostFields(['name', 'email', 'situacao', 'data_admissao'])) {

            $name = $this->sanitizeInput($_POST['name']);
            $email = $this->sanitizeInput($_POST['email']);
            $situacao = $this->sanitizeInput($_POST['situacao']);
            $dataAdmissao = $this->sanitizeInput($_POST['data_admissao']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Email inválido!";
                return;
            }

            try {
                $this->userModel->addUser($name, $email, $situacao, $dataAdmissao);
                header('Location: /');
            } catch (Exception $e) {
                echo "Erro ao adicionar o usuário: " . $e->getMessage();
            }
        } else {
            echo "Preencha todos os campos!";
        }
    }

    /**
     * Exibe o formulário de edição de um usuário.
     *
     * @return void
     */
    public function edit() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $user = $this->userModel->getUserById($id);
            include '../app/Views/users/edit.php';
        } else {
            echo "Usuário não encontrado.";
        }
    }

    /**
     * Atualiza as informações de um usuário existente.
     *
     * @return void
     */
    public function update() {
        if ($this->validatePostFields(['id', 'name', 'email', 'situacao', 'data_admissao'])) {

            $id = $_POST['id'];
            $name = $this->sanitizeInput($_POST['name']);
            $email = $this->sanitizeInput($_POST['email']);
            $situacao = $this->sanitizeInput($_POST['situacao']);
            $dataAdmissao = $this->sanitizeInput($_POST['data_admissao']);

            try {
                $this->userModel->updateUser($id, $name, $email, $situacao, $dataAdmissao);
                header('Location: /');
            } catch (Exception $e) {
                echo "Erro ao atualizar o usuário: " . $e->getMessage();
            }
        } else {
            echo "Preencha todos os campos!";
        }
    }

    /**
     * Exclui um usuário com base no ID.
     *
     * @return void
     */
    public function delete() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            try {
                $this->userModel->deleteUser($id);
                header('Location: /');
            } catch (Exception $e) {
                echo "Erro ao excluir o usuário: " . $e->getMessage();
            }
        } else {
            echo "ID de usuário não fornecido.";
        }
    }

    /**
     * Valida se os campos POST necessários estão presentes e não estão vazios.
     *
     * @param array $fields Lista dos campos a serem validados.
     * @return bool Retorna true se todos os campos estão presentes e preenchidos, caso contrário false.
     */
    private function validatePostFields(array $fields): bool {
        foreach ($fields as $field) {
            if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                return false;
            }
        }
        return true;
    }

    /**
     * Sanitiza e formata o valor recebido de um campo do formulário.
     *
     * @param string $input Valor do campo do formulário a ser sanitizado.
     * @return string Retorna o valor sanitizado.
     */
    private function sanitizeInput(string $input): string {
        return htmlspecialchars(trim($input));
    }
}

