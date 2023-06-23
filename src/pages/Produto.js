import React from 'react';
import Page from '../components/Page';

//Falta: bloquear edicao da primary key
export default function Docente() {
    const title = 'Produto'
    const apiPath = 'http://localhost/ru/api/produto/'
    const columnNames = ['id', 'nome_empresa', 'valor_nutricional', 'data_validade']
    const primaryKey = 'id'
    const opcoes = {
        nome_empresa: ['Company A', 'Company B', 'Company C']
    };


    return (
        <Page title={title} columnNames={columnNames} opcoes={opcoes} apiPath={apiPath} primaryKey={primaryKey} />
    );
}