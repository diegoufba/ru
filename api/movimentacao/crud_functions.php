<?php
// Função para obter todos os produtos
function getAll($conn)
{
    $sql = "SELECT * FROM Movimentacao";
    
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
    $id_conta = $requestData['id_conta'];
    $valor = $requestData['valor'];
    $tipo = $requestData['tipo'];
    $data = $requestData['data'];

    $sqlMovimentacao = "INSERT INTO Movimentacao (id_conta, valor, tipo,`data`) VALUES ('$id_conta', '$valor', '$tipo ','$data')";
    $resultMovimentacao = $conn->query($sqlMovimentacao);

    return ($resultMovimentacao);
}

// Função para atualizar um produto existente
function update($conn, $requestData)
{
    $id = $requestData['id'];
    $id_conta = $requestData['id_conta'];
    $valor = $requestData['valor'];
    $tipo = $requestData['tipo'];
    $data = $requestData['data'];

    $sqlMovimentacao = "UPDATE Movimentacao SET id_conta = '$id_conta', valor = '$valor', tipo = '$tipo', `data` = '$data'  WHERE id = '$id'";
    $resultMovimentacao = $conn->query($sqlMovimentacao);

    return ($resultMovimentacao);
}


// Função para excluir um produto
function delete($conn, $id)
{
    $sqlMovimentacao = "DELETE FROM Movimentacao WHERE id = '$id'";
    $resultMovimentacao= $conn->query($sqlMovimentacao);

    return ($resultMovimentacao);
}

