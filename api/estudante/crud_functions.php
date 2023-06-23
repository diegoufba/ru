<?php
// Função para obter todos os estudantes
function getAll($conn)
{
    $sql = "SELECT * FROM Estudante";

    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

// Função para inserir um novo estudante
function insert($conn, $requestData)
{
    $cpf = $requestData['cpf'];
    $nome = $requestData['nome'];
    $matricula = $requestData['matricula'];
    $curso = $requestData['curso'];

    $sqlEstudante = "INSERT INTO Estudante (cpf, nome, matricula,curso) VALUES ('$cpf', '$nome', '$matricula','$curso')";
    $resultEstudante = $conn->query($sqlEstudante);


    return ($resultEstudante);
}

// Função para atualizar um estudante existente
function update($conn, $requestData)
{
    $cpf = $requestData['cpf'];
    $nome = $requestData['nome'];
    $matricula = $requestData['matricula'];
    $curso = $requestData['curso'];

    $sqlEstudante = "UPDATE Estudante SET nome = '$nome', matricula = '$matricula', curso = '$curso' WHERE cpf = '$cpf'";
    $resultEstudante = $conn->query($sqlEstudante);


    return ($resultEstudante);
}


// Função para excluir um estudante
function delete($conn, $id)
{

    $sqlEstudante = "DELETE FROM Estudante WHERE cpf = '$id'";
    $resultEstudante= $conn->query($sqlEstudante);

    return ($resultEstudante);
}
