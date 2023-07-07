<?php
// Função para obter todos os pagantes
function getAll($conn)
{
    $sql = "SELECT Estudante.cpf,Estudante.nome,Estudante.matricula,Estudante.curso
    FROM Estudante 
    INNER JOIN Bolsista ON Estudante.cpf = Bolsista.cpf";

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
        $sqlBolsista = "INSERT INTO Bolsista (cpf) VALUES ('$cpf')";
        $resultBolsista = $conn->query($sqlBolsista);
        if (!$resultBolsista) {
            throw new Exception('Erro na consulta do bolsista');
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

    // Iniciar a transação
    $conn->begin_transaction();

    try {
        // Atualizar tabela Estudante
        $sqlEstudante = "UPDATE Estudante SET nome = '$nome', matricula = '$matricula', curso = '$curso' WHERE cpf = '$cpf'";
        $resultEstudante = $conn->query($sqlEstudante);
        if (!$resultEstudante) {
            throw new Exception('Erro na atualização do estudante');
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

        // Excluir da tabela Refeicao
        $sqlRefeicao = "DELETE FROM Refeicao WHERE cpf_bolsista = '$cpf'";
        $resultRefeicao = $conn->query($sqlRefeicao);
        if (!$resultRefeicao) {
            throw new Exception('Erro na exclusão das refeicões');
        }

        // Excluir da tabela Pagante
        $sqlBolsista = "DELETE FROM Bolsista WHERE cpf = '$cpf'";
        $resultBolsista = $conn->query($sqlBolsista);
        if (!$resultBolsista) {
            throw new Exception('Erro na exclusão do bolsista');
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