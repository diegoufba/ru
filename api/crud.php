<?php

// Verifica o método da requisição HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'OPTIONS':
        // Define os cabeçalhos CORS permitidos para a solicitação
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        exit();
    
    case 'GET':
        // Consulta para obter todos os dados da tabela
        $data = getAll($conn);
        
        // Verifica se há registros retornados
        if (!empty($data)) {
            // Retorna os dados como resposta JSON
            echo json_encode($data);
        } else {
            // Retorna uma resposta vazia caso não haja registros
            echo json_encode([]);
        }
        break;
    case 'POST':
        // Obtém os dados enviados no corpo da requisição
        $requestData = json_decode(file_get_contents('php://input'), true);
        
        // Insere um novo valor no banco de dados
        $result = insert($conn, $requestData);
        
        if ($result) {
            // Retorna uma resposta de sucesso
            echo json_encode(['success' => true]);
        } else {
            // Retorna uma resposta de erro
            echo json_encode(['success' => false]);
        }
        break;
    case 'PUT':
        // Obtém os dados enviados no corpo da requisição
        $requestData = json_decode(file_get_contents('php://input'), true);
        
        // Atualiza um valor no banco de dados
        $result = update($conn, $requestData);
        
        if ($result) {
            // Retorna uma resposta de sucesso
            echo json_encode(['success' => true]);
        } else {
            // Retorna uma resposta de erro
            echo json_encode(['success' => false]);
        }
        break;
    case 'DELETE':
        // Obtém o ID do objeto a ser excluído
        $id = $_GET['id'];
        
        // Exclui um funcionário do banco de dados
        $result = delete($conn, $id);
        
        if ($result) {
            // Retorna uma resposta de sucesso
            echo json_encode(['success' => true]);
        } else {
            // Retorna uma resposta de erro
            echo json_encode(['success' => false]);
        }
        break;
    default:
        // Retorna uma resposta de método não permitido
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido.']);
        break;
}

// Fecha a conexão com o banco de dados
$conn->close();
