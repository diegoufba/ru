<?php
// Função para obter todos os pagantes
function getAll($conn)
{
    $sql = "SELECT Estudante.cpf,Estudante.nome,Estudante.matricula,Estudante.curso,Conta.saldo 
    FROM Estudante 
    INNER JOIN Pagante ON Estudante.cpf = Pagante.cpf
    INNER JOIN Conta ON Estudante.cpf = Conta.cpf_pagante";

    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

function insert($conn, $requestData)
{
    $cpf = $requestData['cpf'];
    $nome = $requestData['nome'];
    $matricula = $requestData['matricula'];
    $curso = $requestData['curso'];
    $saldo = $requestData['saldo'];

    // Iniciar a transação
    $conn->begin_transaction();

    try {
        // Executar a primeira consulta
        $sqlEstudante = "INSERT INTO Estudante (cpf, nome, matricula, curso) VALUES ('$cpf', '$nome', '$matricula', '$curso')";
        $resultEstudante = $conn->query($sqlEstudante);
        if (!$resultEstudante) {
            throw new Exception('Erro na consulta do estudante');
        }

        // Executar a segunda consulta
        $sqlPagante = "INSERT INTO Pagante (cpf) VALUES ('$cpf')";
        $resultPagante = $conn->query($sqlPagante);
        if (!$resultPagante) {
            throw new Exception('Erro na consulta do pagante');
        }

        // Executar a terceira consulta
        $sqlConta = "INSERT INTO Conta (saldo, cpf_pagante) VALUES ('$saldo', '$cpf')";
        $resultConta = $conn->query($sqlConta);
        if (!$resultConta) {
            throw new Exception('Erro na consulta da conta');
        }

        // Se chegou até aqui, todas as consultas foram executadas com sucesso
        // Efetivar as alterações no banco de dados
        $conn->commit();

        return true;
    } catch (Exception $e) {
        // Algo deu errado, desfazer as alterações realizadas
        $conn->rollback();
        return false;
    }
}

function update($conn, $requestData)
{
    $cpf = $requestData['cpf'];
    $nome = $requestData['nome'];
    $matricula = $requestData['matricula'];
    $curso = $requestData['curso'];
    $saldo = $requestData['saldo'];

    // Iniciar a transação
    $conn->begin_transaction();

    try {
        // Atualizar tabela Estudante
        $sqlEstudante = "UPDATE Estudante SET nome = '$nome', matricula = '$matricula', curso = '$curso' WHERE cpf = '$cpf'";
        $resultEstudante = $conn->query($sqlEstudante);
        if (!$resultEstudante) {
            throw new Exception('Erro na atualização do estudante');
        }

        // Atualizar tabela Conta
        $sqlConta = "UPDATE Conta SET saldo = '$saldo' WHERE cpf_pagante = '$cpf'";
        $resultConta = $conn->query($sqlConta);
        if (!$resultConta) {
            throw new Exception('Erro na atualização da conta');
        }

        // Se chegou até aqui, todas as atualizações foram executadas com sucesso
        // Efetivar as alterações no banco de dados
        $conn->commit();

        return true;
    } catch (Exception $e) {
        // Algo deu errado, desfazer as alterações realizadas
        $conn->rollback();
        return false;
    }
}

function delete($conn, $id)
{
    $cpf = $id;
    // Iniciar a transação
    $conn->begin_transaction();

    try {
        // Excluir da tabela Movimentacao
        $sqlMovimentacao = "DELETE FROM Movimentacao 
        WHERE id_conta IN (SELECT id FROM Conta WHERE cpf_pagante = '$cpf')";
        $resultMovimentacao = $conn->query($sqlMovimentacao);
        if (!$resultMovimentacao) {
            throw new Exception('Erro na exclusão das movimentacões');
        }

        // Excluir da tabela Conta
        $sqlConta = "DELETE FROM Conta WHERE cpf_pagante = '$cpf'";
        $resultConta = $conn->query($sqlConta);
        if (!$resultConta) {
            throw new Exception('Erro na exclusão da conta');
        }

        // Excluir da tabela Refeicao
        $sqlRefeicao = "DELETE FROM Refeicao WHERE cpf_pagante = '$cpf'";
        $resultRefeicao = $conn->query($sqlRefeicao);
        if (!$resultRefeicao) {
            throw new Exception('Erro na exclusão das refeicões');
        }

        // Excluir da tabela Pagante
        $sqlPagante = "DELETE FROM Pagante WHERE cpf = '$cpf'";
        $resultPagante = $conn->query($sqlPagante);
        if (!$resultPagante) {
            throw new Exception('Erro na exclusão do pagante');
        }

        // Excluir da tabela Estudante
        $sqlEstudante = "DELETE FROM Estudante WHERE cpf = '$cpf'";
        $resultEstudante = $conn->query($sqlEstudante);
        if (!$resultEstudante) {
            throw new Exception('Erro na exclusão do estudante');
        }

        // Se chegou até aqui, todas as exclusões foram executadas com sucesso
        // Confirmar as alterações no banco de dados
        $conn->commit();

        return true;
    } catch (Exception $e) {
        // Algo deu errado, desfazer as alterações realizadas
        $conn->rollback();
        return false;
    }
}