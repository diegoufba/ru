<?php

function busca($conn)
{
    // Obtém os parâmetros da requisição GET
    $colegiado = isset($_GET['colegiado']) ? $_GET['colegiado'] : 'Todos';

    $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
    $operador = isset($_GET['operador']) ? $_GET['operador'] : '';
    $saldo = isset($_GET['saldo']) ? $_GET['saldo'] : '';

    $sql = "SELECT Docente.cpf,Docente.nome,Docente.colegiado,Conta.saldo 
    FROM Docente 
    INNER JOIN Conta ON Docente.cpf = Conta.cpf_docente
    WHERE 1=1";


    // Verifica se o parâmetro nome está presente
    if ($nome != '') {
        $nome = trim($nome);
        // Adiciona a condição de pesquisa por nome (case-insensitive e ignorando espaços extras)
        $sql .= " AND LOWER(TRIM(Docente.nome)) LIKE LOWER('%$nome%')";
    }

    // Verifica se tanto o parâmetro salario quanto operador_salario estão presentes
    if ($saldo != '') {
        // Adiciona a condição de comparação de salário (dinamicamente com base no operador escolhido)
        $sql .= " AND Conta.saldo $operador $saldo";
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
