<?php

function busca($conn)
{
    // Obtém os parâmetros da requisição GET
    $colegiado = isset($_GET['colegiado']) ? $_GET['colegiado'] : 'Todos';
    
    $nome = isset($_GET['nome']) ? $_GET['nome'] : '';

    // Constrói a consulta SQL inicial
    $sql = "SELECT * FROM Docente
        WHERE 1=1";

    // Verifica se o parâmetro nome está presente
    if ($nome != '') {
        $nome = trim($nome);
        // Adiciona a condição de pesquisa por nome (case-insensitive e ignorando espaços extras)
        $sql .= " AND LOWER(TRIM(Docente.nome)) LIKE LOWER('%$nome%')";
    }


    // Verifica se o parâmetro turno está presente
    if ($colegiado != 'Todos') {
        // Adiciona a condição de pesquisa por turno
        $sql .= " AND Docente.colegiado = '$colegiado'";
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