import React from 'react';
import Page from '../components/Page';

//Falta: bloquear edicao da primary key
export default function Movimentacao() {
    const title = 'Movimentação'
    const apiPath = 'http://localhost/ru/api/movimentacao/'
    const columnNames = ['id', 'id_conta', 'valor', 'tipo','data']
    const primaryKey = 'id'
    const attributeToCompareName = 'valor'
    const opcoes = {
        tipo: ['recarga', 'refeicao']
    };
    return (
        <Page title={title} columnNames={columnNames} attributeToCompareName={attributeToCompareName} opcoes={opcoes} apiPath={apiPath} primaryKey={primaryKey} />
    );
}