<?php

function busca($conn)
{
    // Obtém os parâmetros da requisição GET
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'Todos';

    $operador = isset($_GET['operador']) ? $_GET['operador'] : '';
    $valor = isset($_GET['valor']) ? $_GET['valor'] : '';

    // Constrói a consulta SQL inicial
    $sql = "SELECT * FROM Movimentacao
        WHERE 1=1";

    // Verifica se tanto o parâmetro salario quanto operador_salario estão presentes
    if ($valor != '') {
        // Adiciona a condição de comparação de salário (dinamicamente com base no operador escolhido)
        $sql .= " AND Movimentacao.valor $operador $valor";
    }

    // Verifica se o parâmetro turno está presente
    if ($tipo != 'Todos') {
        // Adiciona a condição de pesquisa por turno
        $sql .= " AND Movimentacao.tipo = '$tipo'";
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
