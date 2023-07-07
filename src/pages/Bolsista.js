import React from 'react';
import Page from '../components/Page';

//Falta: bloquear edicao da primary key
export default function Bolsista() {
    const title = 'Bolsista' 
    const apiPath = 'http://localhost/ru/api/bolsista/'
    const columnNames = ['cpf', 'nome', 'matricula', 'curso']
    const primaryKey = 'cpf'
    const attributeToCompareName = ''
    const opcoes = {
        curso: ['Letras', 'Matemática', 'Computação', 'Ciências Sociais', 'Educação', 'Engenharia', 'Saúde', 'Administração',
            'Artes', 'Direito', 'Comunicação', 'Ciências Biológicas', 'Ciências Exatas']
    };
    return (
        <Page title={title} columnNames={columnNames} attributeToCompareName={attributeToCompareName} opcoes={opcoes} apiPath={apiPath} primaryKey={primaryKey}/>
    );
}
