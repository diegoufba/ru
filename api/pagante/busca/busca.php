<?php

function busca($conn)
{
    // Obtém os parâmetros da requisição GET
    $curso = isset($_GET['curso']) ? $_GET['curso'] : 'Todos';

    $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
    $operador = isset($_GET['operador']) ? $_GET['operador'] : '';
    $saldo = isset($_GET['saldo']) ? $_GET['saldo'] : '';

    // Constrói a consulta SQL inicial

    $sql = "SELECT Estudante.cpf,Estudante.nome,Estudante.matricula,Estudante.curso,Conta.saldo 
    FROM Estudante 
    INNER JOIN Pagante ON Estudante.cpf = Pagante.cpf
    INNER JOIN Conta ON Estudante.cpf = Conta.cpf_pagante
    WHERE 1=1";

    // Verifica se o parâmetro nome está presente
    if ($nome != '') {
        $nome = trim($nome);
        // Adiciona a condição de pesquisa por nome (case-insensitive e ignorando espaços extras)
        $sql .= " AND LOWER(TRIM(Estudante.nome)) LIKE LOWER('%$nome%')";
    }

    // Verifica se tanto o parâmetro salario quanto operador_salario estão presentes
    if ($saldo != '') {
        // Adiciona a condição de comparação de salário (dinamicamente com base no operador escolhido)
        $sql .= " AND Conta.saldo $operador $saldo";
    }


    // Verifica se o parâmetro turno está presente
    if ($curso != 'Todos') {
        // Adiciona a condição de pesquisa por turno
        $sql .= " AND Estudante.curso = '$curso'";
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
