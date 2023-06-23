<?php
// Função para obter todos os docentes
function getAll($conn)
{
    $sql = "SELECT * FROM Docente";

    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

// Função para inserir um novo docente
function insert($conn, $requestData)
{
    $cpf = $requestData['cpf'];
    $nome = $requestData['nome'];
    $colegiado = $requestData['colegiado'];

    $sqlDocente = "INSERT INTO Docente (cpf, nome, colegiado) VALUES ('$cpf', '$nome', '$colegiado')";
    $resultDocente = $conn->query($sqlDocente);

    return ($resultDocente);
}

// Função para atualizar um docente existente
function update($conn, $requestData)
{
    $cpf = $requestData['cpf'];
    $nome = $requestData['nome'];
    $colegiado = $requestData['colegiado'];

    $sqlDocente  = "UPDATE Docente SET nome = '$nome', colegiado = '$colegiado' WHERE cpf = '$cpf'";
    $resultDocente = $conn->query($sqlDocente);

    return ($resultDocente);
}


// Função para excluir um docente
function delete($conn, $id)
{
    $sqlDocente = "DELETE FROM Docente WHERE cpf = '$id'";
    $resultDocente = $conn->query($sqlDocente);

    return ($resultDocente);
}

