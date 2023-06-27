<?php

function busca($conn)
{
    // Obtém os parâmetros da requisição GET
    $campus_ru = isset($_GET['campus_ru']) ? $_GET['campus_ru'] : 'Todos';
    $turno = isset($_GET['turno']) ? $_GET['turno'] : 'Todos';
    $funcao = isset($_GET['funcao']) ? $_GET['funcao'] : 'Todos';
    
    $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
    $operador = isset($_GET['operador']) ? $_GET['operador'] : '';
    $salario = isset($_GET['salario']) ? $_GET['salario'] : '';

    // Constrói a consulta SQL inicial
    $sql = "SELECT Funcionario.*, Cargo.*
        FROM Funcionario
        INNER JOIN Cargo
        ON Funcionario.cpf = Cargo.cpf
        WHERE 1=1";

    // Verifica se o parâmetro nome está presente
    if ($nome != '') {
        $nome = trim($nome);
        // Adiciona a condição de pesquisa por nome (case-insensitive e ignorando espaços extras)
        $sql .= " AND LOWER(TRIM(Funcionario.nome)) LIKE LOWER('%$nome%')";
    }

    // Verifica se tanto o parâmetro salario quanto operador_salario estão presentes
    if ($salario != '') {
        // Adiciona a condição de comparação de salário (dinamicamente com base no operador escolhido)
        $sql .= " AND Cargo.salario $operador $salario";
    }

    // Verifica se o parâmetro turno está presente
    if ($turno != 'Todos') {
        // Adiciona a condição de pesquisa por turno
        $sql .= " AND Cargo.turno = '$turno'";
    }

    // Verifica se o parâmetro campus_ru está presente
    if ($campus_ru != 'Todos') {
        // Adiciona a condição de pesquisa por campus_ru
        $sql .= " AND Funcionario.campus_ru = '$campus_ru'";
    }

    // Verifica se o parâmetro funcao está presente
    if ($funcao != 'Todos') {
        // Adiciona a condição de pesquisa por função
        $sql .= " AND Cargo.funcao = '$funcao'";
    }


    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}