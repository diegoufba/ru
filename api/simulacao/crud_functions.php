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

        $sqlRefeicao = "SELECT Refeicao.id, Refeicao.campus_ru, Prato.nome,
        (SELECT GROUP_CONCAT(Ingrediente.nome SEPARATOR ', ')
         FROM Prato
         JOIN Composicao ON Prato.id = Composicao.id_prato
         JOIN Ingrediente ON Composicao.id_ingrediente = Ingrediente.id
         WHERE Prato.id = Refeicao.id_prato) AS ingredientes,
        Prato.valor_nutricional, Refeicao.data
        FROM Refeicao
        INNER JOIN Prato ON Refeicao.id_prato = Prato.id
        WHERE Refeicao.cpf_pagante = '$cpf' OR Refeicao.cpf_bolsista = '$cpf' OR Refeicao.cpf_docente = '$cpf'";

        $resultRefeicao = $conn->query($sqlRefeicao);
        $dataRefeicao = array();

        if ($resultRefeicao->num_rows > 0) {
            while ($row = $resultRefeicao->fetch_assoc()) {
                $dataRefeicao[] = $row;
            }
        }

        return array("usuario" => $usuario, "conta" => $dataConta,"refeicao" => $dataRefeicao);
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

        $sql_pratos = "SELECT Prato.id, Prato.nome,Prato.valor_nutricional, GROUP_CONCAT(Ingrediente.nome SEPARATOR ', ') AS ingredientes
        FROM Prato
        JOIN Composicao ON Prato.id = Composicao.id_prato
        JOIN Ingrediente ON Composicao.id_ingrediente = Ingrediente.id
        GROUP BY Prato.id, Prato.nome";

        $resultPratos = $conn->query($sql_pratos);
        $dataPratos = array();

        if ($resultPratos->num_rows > 0) {
            while ($row = $resultPratos->fetch_assoc()) {
                $dataPratos[] = $row;
            }
        }


        return array("cpfs" => $datacpf, "campus" => $dataCampus, "pratos" => $dataPratos);
    }
}

// Função para inserir um novo produto
function insert($conn, $requestData)
{
    $id_conta = $requestData['id_conta'];
    $valor = $requestData['valor'];
    $tipo = $requestData['tipo'];

    $cpf = $requestData['cpf'];
    $id_prato = $requestData['id_prato'];
    $campus_ru = $requestData['campus_ru'];

    $tipo_usuario = $requestData['tipo_usuario'];

    date_default_timezone_set('America/Sao_Paulo');
    $data = date('Y-m-d H:i:s');

    if (isset($id_prato)) {
        switch ($tipo_usuario) {
            case 'Pagante':
                $sqlRefeicao = "INSERT INTO Refeicao (cpf_pagante, `data`, id_prato, campus_ru) 
                VALUES ('$cpf' , '$data', '$id_prato', '$campus_ru')";
                break;
            case 'Docente':
                $sqlRefeicao = "INSERT INTO Refeicao (cpf_docente, `data`, id_prato, campus_ru) 
                VALUES ($cpf, '$data', '$id_prato', '$campus_ru')";
                break;
            case 'Bolsista':
                $sqlRefeicao = "INSERT INTO Refeicao ( cpf_bolsista, `data`, id_prato, campus_ru) 
                VALUES ($cpf , '$data', '$id_prato', '$campus_ru')";
                break;
            default:
                break;
        }
        $resultRefeicao = $conn->query($sqlRefeicao);

        if ($tipo_usuario != 'Bolsista') {
            $valor = -2.50;
            if ($tipo_usuario == 'Docente') {
                $valor = -14.39;
            }

            $conn->autocommit(false);
            try {
                $conn->begin_transaction(); // Iniciar a transação

                // Inserir na tabela Movimentacao
                $sqlInsert = "INSERT INTO Movimentacao (id_conta, valor, tipo, `data`) VALUES ('$id_conta', '$valor', '$tipo', '$data')";
                $conn->query($sqlInsert);

                // Atualizar saldo na tabela Conta
                $sqlUpdate = "UPDATE Conta SET saldo = saldo + '$valor' WHERE id = '$id_conta'";
                $conn->query($sqlUpdate);

                $conn->commit(); // Efetivar as alterações

            } catch (Exception $e) {
                $conn->rollback(); // Reverter a transação em caso de erro
                echo "Erro na transação: " . $e->getMessage();
            }
            $conn->autocommit(true);
        }
    } else {
        $sqlMovimentacao = "INSERT INTO Movimentacao (id_conta, valor, tipo,`data`) VALUES ('$id_conta', '$valor', '$tipo','$data')";
        $resultMovimentacao = $conn->query($sqlMovimentacao);
    }

    return ($resultRefeicao);
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
