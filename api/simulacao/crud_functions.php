<?php
// Função para obter todos os produtos
function getAll($conn)
{
    if (isset($_GET['cpf'])) {
        $cpf = $_GET['cpf'];

        $sqlUsuario = "SELECT nome, cpf,
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
        ) AS saldo,
        (
            SELECT 
                CASE
                    WHEN Conta.cpf_pagante IS NOT NULL OR Conta.cpf_docente IS NOT NULL THEN Conta.id
                END
            FROM Conta
            WHERE $cpf IN (Conta.cpf_pagante, Conta.cpf_docente)
            LIMIT 1
        ) AS id_conta
        FROM
        (SELECT nome, cpf FROM Estudante
        UNION 
        SELECT nome, cpf FROM Docente) AS usuario
        WHERE usuario.cpf = $cpf";


        $resultUsuario = $conn->query($sqlUsuario);
        $usuario = null;

        if ($resultUsuario->num_rows > 0) {
            $usuario = $resultUsuario->fetch_assoc();
        }

        // CONTA
        $id_conta = $usuario['id_conta'];
        $dataConta = array();

        if ($id_conta) {
            $sqlConta = "SELECT id,tipo,valor,`data` 
            FROM Movimentacao WHERE Movimentacao.id_conta = $id_conta
            ORDER BY `data`";

            $resultConta = $conn->query($sqlConta);

            if ($resultConta->num_rows > 0) {
                while ($row = $resultConta->fetch_assoc()) {
                    $dataConta[] = $row;
                }
            }
        }
        return array("usuario" => $usuario, "conta" => $dataConta);
    } else {
        $sql_cpf = "SELECT cpf FROM Estudante UNION SELECT cpf FROM Docente";
        $resultCpf = $conn->query($sql_cpf);
        $datacpf = array();

        if ($resultCpf->num_rows > 0) {
            while ($row = $resultCpf->fetch_assoc()) {
                $datacpf[] = $row['cpf'];
            }
        }

        $sql_campus = "SELECT campus FROM RU";
        $resultCampus = $conn->query($sql_campus);
        $dataCampus = array();

        if ($resultCampus->num_rows > 0) {
            while ($row = $resultCampus->fetch_assoc()) {
                $dataCampus[] = $row['campus'];
            }
        }


        return array("cpfs" => $datacpf, "campus" => $dataCampus);
    }
}

// Função para inserir um novo produto
function insert($conn, $requestData)
{
    $id_conta = $requestData['id_conta'];
    $valor = $requestData['valor'];
    $tipo = $requestData['tipo'];

    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i:s');

    $sqlMovimentacao = "INSERT INTO Movimentacao (id_conta, valor, tipo,`data`) VALUES ('$id_conta', '$valor', '$tipo','$data')";
    $resultMovimentacao = $conn->query($sqlMovimentacao);

    return ($resultMovimentacao);
}

// Função para atualizar um produto existente
function update($conn, $requestData)
{
    $id_conta = $requestData['id_conta'];
    $valor = $requestData['valor'];

    $sqlSaldo = "SELECT saldo FROM conta WHERE Conta.id = $id_conta";
    $resultSaldo = $conn->query($sqlSaldo);

    if ($resultSaldo->num_rows > 0) {
        $saldo = $resultSaldo->fetch_assoc();
        $newSaldo = $saldo['saldo'] + $valor;

        $sqlConta = "UPDATE Conta SET saldo = '$newSaldo' WHERE Conta.id = $id_conta";
        $resultConta = $conn->query($sqlConta);

        return ($resultConta);
    } else {
        return (false);
    }
}


// Função para excluir um produto
function delete($conn, $id)
{
    $sqlProduto = "DELETE FROM Produto WHERE id = '$id'";
    $resultProduto = $conn->query($sqlProduto);

    return ($resultProduto);
}
