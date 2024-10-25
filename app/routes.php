<?php

require_once '../app/Controllers/UserController.php';

// Instância do controlador de usuários
$controller = new UserController();

// Pega a URI da requisição
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Definição de rotas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($request_uri) {
        case '/add-user':
            $controller->store();
            break;
        case '/update-user':
            $controller->update();
            break;
        default:
            http_response_code(404);
            echo "Rota POST não encontrada.";
            break;
    }
} else {
    switch ($request_uri) {
        case '/create-user':
            $controller->create();
            break;
        case '/edit-user':
            $controller->edit();
            break;
        case '/delete-user':
            $controller->delete();
            break;
        default:
            $controller->index();
            break;
    }
}
