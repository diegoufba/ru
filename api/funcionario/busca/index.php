<?php

// Inclui o header
require_once '../../header.php';

function busca($conn)
{
    // Obtém os parâmetros da requisição GET
    $nome = isset($_GET['nome']) ? $_GET['nome'] : 'Todos';
    $campus_ru = isset($_GET['campus_ru']) ? $_GET['campus_ru'] : 'Todos';
    $salario = isset($_GET['salario']) ? $_GET['salario'] : 'Todos';
    $operador_salario = isset($_GET['operador_salario']) ? $_GET['operador_salario'] : 'Todos';
    $turno = isset($_GET['turno']) ? $_GET['turno'] : 'Todos';
    $funcao = isset($_GET['funcao']) ? $_GET['funcao'] : 'Todos';

    // Constrói a consulta SQL inicial
    $sql = "SELECT Funcionario.*, Cargo.*
        FROM Funcionario
        INNER JOIN Cargo
        ON Funcionario.cpf = Cargo.cpf
        WHERE 1=1";

    // Verifica se o parâmetro nome está presente
    if ($nome != 'Todos') {
        $nome = trim($nome);
        // Adiciona a condição de pesquisa por nome (case-insensitive e ignorando espaços extras)
        $sql .= " AND LOWER(TRIM(Funcionario.nome)) LIKE LOWER('%$nome%')";
    }

    // Verifica se tanto o parâmetro salario quanto operador_salario estão presentes
    if ($salario != 'Todos' && $operador_salario != 'Todos') {
        // Adiciona a condição de comparação de salário (dinamicamente com base no operador escolhido)
        $sql .= " AND Cargo.salario $operador_salario $salario";
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

// Verifica o método da requisição HTTP
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {

    // Consulta para obter todos os dados da tabela
    $data = busca($conn);

    // Verifica se há registros retornados
    if (!empty($data)) {
        // Retorna os dados como resposta JSON
        echo json_encode($data);
    } else {
        // Retorna uma resposta vazia caso não haja registros
        echo json_encode([]);
    }
}

// Fecha a conexão com o banco de dados
$conn->close();