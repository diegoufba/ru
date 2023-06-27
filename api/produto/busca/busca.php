<?php

function busca($conn)
{
    // Obtém os parâmetros da requisição GET
    $nome_empresa = isset($_GET['nome_empresa']) ? $_GET['nome_empresa'] : 'Todos';

    // Constrói a consulta SQL inicial
    $sql = "SELECT * FROM Produto
        WHERE 1=1";


    // Verifica se o parâmetro turno está presente
    if ($nome_empresa != 'Todos') {
        // Adiciona a condição de pesquisa por turno
        $sql .= " AND Produto.nome_empresa = '$nome_empresa'";
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