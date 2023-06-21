<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ru";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve algum erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Inclui o arquivo com as funções CRUD
require_once 'crud_functions.php';

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
        $data = getAllFuncionarios($conn);
        
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
        
        // Insere um novo funcionário no banco de dados
        $result = insertFuncionario($conn, $requestData);
        
        if ($result) {
            // Retorna uma resposta de sucesso
            echo json_encode(['message' => 'Funcionário inserido com sucesso.']);
        } else {
            // Retorna uma resposta de erro
            echo json_encode(['error' => 'Falha ao inserir o funcionário.']);
        }
        break;
    case 'PUT':
        // Obtém os dados enviados no corpo da requisição
        $requestData = json_decode(file_get_contents('php://input'), true);
        
        // Atualiza um funcionário no banco de dados
        $result = updateFuncionario($conn, $requestData);
        
        if ($result) {
            // Retorna uma resposta de sucesso
            echo json_encode(['message' => 'Funcionário atualizado com sucesso.']);
        } else {
            // Retorna uma resposta de erro
            echo json_encode(['error' => 'Falha ao atualizar o funcionário.']);
        }
        break;
    case 'DELETE':
        // Obtém o ID do funcionário a ser excluído
        $cpf = $_GET['cpf'];
        
        // Exclui um funcionário do banco de dados
        $result = deleteFuncionario($conn, $cpf);
        
        if ($result) {
            // Retorna uma resposta de sucesso
            echo json_encode(['message' => 'Funcionário excluído com sucesso.']);
        } else {
            // Retorna uma resposta de erro
            echo json_encode(['error' => 'Falha ao excluir o funcionário.']);
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
