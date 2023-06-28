<?php
// Função para obter todos os produtos
function getAll($conn)
{
    if (isset($_GET['cpf'])) {
        $cpf = $_GET['cpf'];
        $campus_ru = $_GET['campus_ru'];

        $sql = "SELECT nome, cpf,
        CASE
            WHEN EXISTS(SELECT 1 FROM Docente WHERE $cpf = Docente.cpf) THEN 'Docente'
            WHEN EXISTS(SELECT 1 FROM Pagante WHERE $cpf = Pagante.cpf) THEN 'Pagante'
            WHEN EXISTS(SELECT 1 FROM Bolsista WHERE $cpf = Bolsista.cpf) THEN 'Bolsista'
        END AS tipo,
        (
            SELECT 
                CASE
                    WHEN Conta.cpf_pagante IS NOT NULL OR Conta.cpf_docente IS NOT NULL THEN Conta.saldo
                END
            FROM Conta
            WHERE $cpf IN (Conta.cpf_pagante, Conta.cpf_docente)
            LIMIT 1
        ) AS saldo
        FROM
        (SELECT nome, cpf FROM Estudante
        UNION 
        SELECT nome, cpf FROM Docente) AS usuario
        WHERE usuario.cpf = $cpf";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    } else {
        $sql = "SELECT cpf FROM Estudante UNION SELECT cpf FROM Docente";

        $result = $conn->query($sql);

        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row['cpf'];
            }
        }

        return $data;
    }





    // $sql = "SELECT nome, cpf,
    // CASE
    //     WHEN EXISTS(SELECT 1 FROM Docente WHERE usuario.cpf = Docente.cpf) THEN 'Docente'
    //     WHEN EXISTS(SELECT 1 FROM Pagante WHERE usuario.cpf = Pagante.cpf) THEN 'Pagante'
    //     WHEN EXISTS(SELECT 1 FROM Bolsista WHERE usuario.cpf = Bolsista.cpf) THEN 'Bolsista'
    // END AS tipo,
    // (
    //     SELECT 
    //         CASE
    //             WHEN Conta.cpf_pagante IS NOT NULL OR Conta.cpf_docente IS NOT NULL THEN Conta.saldo
    //         END
    //     FROM Conta
    //     WHERE usuario.cpf IN (Conta.cpf_pagante, Conta.cpf_docente)
    //     LIMIT 1
    // ) AS saldo
    // FROM
    // (SELECT nome, cpf FROM Estudante
    // UNION 
    // SELECT nome, cpf FROM Docente) AS usuario";

    // $result = $conn->query($sql);

    // $data = array();

    // if ($result->num_rows > 0) {
    //     while ($row = $result->fetch_assoc()) {
    //         $data[] = $row;
    //     }
    // }

    // return $data;
}

// function getAll($conn)
// {
//     $cpf = $_GET['cpf'];
//     $campus_ru = $_GET['campus_ru'];

//     $sql = "SELECT nome FROM Docente WHERE cpf = $cpf";

//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         return $result->fetch_assoc();
//     }

// }

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
    $resultProduto = $conn->query($sqlProduto);

    return ($resultProduto);
}
