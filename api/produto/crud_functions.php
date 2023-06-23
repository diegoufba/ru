<?php
// Função para obter todos os produtos
function getAll($conn)
{
    $sql = "SELECT * FROM Produto";
    
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

// Função para inserir um novo produto
function insert($conn, $requestData)
{
    $nome_empresa = $requestData['nome_empresa'];
    $valor_nutricional = $requestData['valor_nutricional'];
    $data_validade = $requestData['data_validade'];

    $sqlProduto = "INSERT INTO Produto (nome_empresa, valor_nutricional, data_validade) VALUES ('$nome_empresa', '$valor_nutricional', '$data_validade')";
    $resultProduto = $conn->query($sqlProduto);

    return ($resultProduto);
}

// Função para atualizar um produto existente
function update($conn, $requestData)
{
    $id = $requestData['id'];
    $nome_empresa = $requestData['nome_empresa'];
    $valor_nutricional = $requestData['valor_nutricional'];
    $data_validade = $requestData['data_validade'];

    $sqlProduto = "UPDATE Produto SET nome_empresa = '$nome_empresa', valor_nutricional = '$valor_nutricional', data_validade = '$data_validade'  WHERE id = '$id'";
    $resultProduto = $conn->query($sqlProduto);

    return ($resultProduto);
}


// Função para excluir um produto
function delete($conn, $id)
{
    $sqlProduto = "DELETE FROM Produto WHERE id = '$id'";
    $resultProduto= $conn->query($sqlProduto);

    return ($resultProduto);
}

