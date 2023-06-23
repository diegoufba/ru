<?php
// Função para obter todos os funcionários
function getAll($conn)
{
    $sql = "SELECT Funcionario.*, Cargo.*
    FROM Funcionario
    INNER JOIN Cargo
    ON Funcionario.cpf = Cargo.cpf";
    
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
function insert($conn, $requestData)
{
    $cpf = $requestData['cpf'];
    $nome = $requestData['nome'];
    $campus_ru = $requestData['campus_ru'];
    $salario = $requestData['salario'];
    $turno = $requestData['turno'];
    $funcao = $requestData['funcao'];

    $sqlFuncionario = "INSERT INTO Funcionario (cpf, nome, campus_ru) VALUES ('$cpf', '$nome', '$campus_ru')";
    $resultFuncionario = $conn->query($sqlFuncionario);

    $sqlCargo = "INSERT INTO Cargo (cpf, salario, turno, funcao) VALUES ('$cpf', $salario, '$turno', '$funcao')";
    $resultCargo = $conn->query($sqlCargo);

    return ($resultFuncionario && $resultCargo);
}

// Função para atualizar um funcionário existente
function update($conn, $requestData)
{
    $cpf = $requestData['cpf'];
    $nome = $requestData['nome'];
    $campus_ru = $requestData['campus_ru'];
    $salario = $requestData['salario'];
    $turno = $requestData['turno'];
    $funcao = $requestData['funcao'];

    $sqlFuncionario = "UPDATE Funcionario SET nome = '$nome', campus_ru = '$campus_ru' WHERE cpf = '$cpf'";
    $resultFuncionario = $conn->query($sqlFuncionario);

    $sqlCargo = "UPDATE Cargo SET salario = $salario, turno = '$turno', funcao = '$funcao' WHERE cpf = '$cpf'";
    $resultCargo = $conn->query($sqlCargo);

    return ($resultFuncionario && $resultCargo);
}


// Função para excluir um funcionário
function delete($conn, $id)
{
    $sqlCargo = "DELETE FROM Cargo WHERE cpf = '$id'";
    $resultCargo = $conn->query($sqlCargo);

    $sqlFuncionario = "DELETE FROM Funcionario WHERE cpf = '$id'";
    $resultFuncionario = $conn->query($sqlFuncionario);

    return ($resultFuncionario && $resultCargo);
}

