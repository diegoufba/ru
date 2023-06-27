<?php

// Verifica o método da requisição HTTP
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {

    // Consulta para obter todos os dados da tabela
    $data = busca($conn);

    // Verifica se há registros retornados
    if (!empty($data)) {
        // Retorna os dados como resposta JSON
        echo json_encode($data);
    } else {
        // Retorna uma resposta vazia caso não haja registros
        echo json_encode([]);
    }
}

// Fecha a conexão com o banco de dados
$conn->close();