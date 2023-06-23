import React from 'react';
import Page from '../components/Page';

//Falta: bloquear edicao da primary key
export default function Funcionario() {
    const title = 'Funcionários' 
    const apiPath = 'http://localhost/ru/api/funcionario/'
    const columnNames = ['cpf', 'nome', 'campus_ru', 'salario', 'turno', 'funcao']
    const primaryKey = 'cpf'
    const opcoes = {
        turno: ['matutino', 'vespertino', 'noturno'],
        campus_ru: ['Ondina', 'São Lazaro', 'Vitória'],
        funcao: ['Cozinheiro', 'Chef de cozinha', 'Nutricionista', 'Auxiliar de cozinha', 'Caixa', 'Auxiliar de limpeza', 'Gerente']
    }
    return (
        <Page title={title} columnNames={columnNames} opcoes={opcoes} apiPath={apiPath} primaryKey={primaryKey}/>
    );
}
