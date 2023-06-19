<?php
// Função para obter todos os funcionários
function getAllFuncionarios($conn) {
    $sql = "SELECT * FROM funcionarios";
    $result = $conn->query($sql);
    
    $data = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    return $data;
}

// Função para inserir um novo funcionário
function insertFuncionario($conn, $requestData) {
    $cpf = $requestData['cpf'];
    $nome = $requestData['nome'];
    $salario = $requestData['salario'];
    
    $sql = "INSERT INTO funcionarios (cpf, nome, salario) VALUES ('$cpf', '$nome', $salario)";
    $result = $conn->query($sql);
    
    return $result;
}

// Função para atualizar um funcionário existente
function updateFuncionario($conn, $requestData) {
    $cpf = $requestData['cpf'];
    $nome = $requestData['nome'];
    $salario = $requestData['salario'];
    
    $sql = "UPDATE funcionarios SET nome='$nome', salario=$salario WHERE cpf='$cpf'";
    $result = $conn->query($sql);
    
    return $result;
}

// Função para excluir um funcionário
function deleteFuncionario($conn, $cpf) {
    $sql = "DELETE FROM funcionarios WHERE cpf='$cpf'";
    $result = $conn->query($sql);
    
    return $result;
}