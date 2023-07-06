import React from 'react';
import Page from '../components/Page';

//Falta: bloquear edicao da primary key
export default function Pagante() {
    const title = 'Pagante'
    const apiPath = 'http://localhost/ru/api/pagante/'
    const columnNames = ['cpf', 'nome', 'matricula','curso','saldo']
    const primaryKey = 'cpf'
    const attributeToCompareName = ''
    const opcoes = {
        curso: ['Letras', 'Matemática', 'Computação', 'Ciências Sociais', 'Educação', 'Engenharia', 'Saúde', 'Administração',
            'Artes', 'Direito', 'Comunicação', 'Ciências Biológicas', 'Ciências Exatas']
    };
    return (
        <Page title={title} columnNames={columnNames} attributeToCompareName={attributeToCompareName} opcoes={opcoes} apiPath={apiPath} primaryKey={primaryKey} />
    );
}
