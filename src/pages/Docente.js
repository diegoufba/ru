import React from 'react';
import Page from '../components/Page';

//Falta: bloquear edicao da primary key
export default function Docente() {
    const title = 'Docente'
    const apiPath = 'http://localhost/ru/api/docente/'
    // const columnNames = ['cpf', 'nome', 'colegiado','saldo']
    const primaryKey = 'cpf'
    const attributeToCompareName = 'saldo'
    const opcoes = {
        colegiado: ['Letras', 'Matemática', 'Computação', 'Ciências Sociais', 'Educação', 'Engenharia', 'Saúde', 'Administração',
            'Artes', 'Direito', 'Comunicação', 'Ciências Biológicas', 'Ciências Exatas']
    };
    return (
        <Page title={title} attributeToCompareName={attributeToCompareName} opcoes={opcoes} apiPath={apiPath} primaryKey={primaryKey} />
    );
}
