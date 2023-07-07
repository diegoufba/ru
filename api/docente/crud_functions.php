<?php
// Função para obter todos os pagantes
function getAll($conn)
{
    $sql = "SELECT Docente.cpf,Docente.nome,Docente.colegiado,Conta.saldo 
    FROM Docente 
    INNER JOIN Conta ON Docente.cpf = Conta.cpf_docente";

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
    $colegiado = $requestData['colegiado'];
    $saldo = $requestData['saldo'];

    // Iniciar a transação
    $conn->begin_transaction();

    try {
        // Executar a primeira consulta
        $sqlDocente = "INSERT INTO Docente (cpf, nome, colegiado) VALUES ('$cpf', '$nome', '$colegiado')";
        $resultDocente = $conn->query($sqlDocente);
        if (!$resultDocente) {
            throw new Exception('Erro na consulta do docente');
        }

        // Executar a segunda consulta
        $sqlConta = "INSERT INTO Conta (saldo, cpf_docente) VALUES ('$saldo', '$cpf')";
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
    $colegiado = $requestData['colegiado'];
    $saldo = $requestData['saldo'];

    // Iniciar a transação
    $conn->begin_transaction();

    try {
        // Atualizar tabela Docente
        $sqlDocente  = "UPDATE Docente SET nome = '$nome', colegiado = '$colegiado' WHERE cpf = '$cpf'";
        $resultDocente = $conn->query($sqlDocente);
        if (!$resultDocente ) {
            throw new Exception('Erro na atualização do Docente');
        }

        // Atualizar tabela Conta
        $sqlConta = "UPDATE Conta SET saldo = '$saldo' WHERE cpf_docente = '$cpf'";
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
        WHERE id_conta IN (SELECT id FROM Conta WHERE cpf_docente = '$cpf')";
        $resultMovimentacao = $conn->query($sqlMovimentacao);
        if (!$resultMovimentacao) {
            throw new Exception('Erro na exclusão das movimentacões');
        }

        // Excluir da tabela Conta
        $sqlConta = "DELETE FROM Conta WHERE cpf_docente = '$cpf'";
        $resultConta = $conn->query($sqlConta);
        if (!$resultConta) {
            throw new Exception('Erro na exclusão da conta');
        }

        // Excluir da tabela Refeicao
        $sqlRefeicao = "DELETE FROM Refeicao WHERE cpf_docente = '$cpf'";
        $resultRefeicao = $conn->query($sqlRefeicao);
        if (!$resultRefeicao) {
            throw new Exception('Erro na exclusão das refeicões');
        }

        // Excluir da tabela Docente
        $sqlDocente = "DELETE FROM Docente WHERE cpf = '$id'";
        $resultDocente = $conn->query($sqlDocente);
        if (!$resultDocente) {
            throw new Exception('Erro na exclusão do docente');
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