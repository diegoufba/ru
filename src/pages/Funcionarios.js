import React from 'react';
import Table from '../components/Table';


//Falta: bloquear edicao da primary key
// select em campos onde é select
export default function Funcionarios() {
    const columnNames = ['cpf', 'nome', 'salario']
    const apiPath = 'http://localhost/ru/api/'
    const primaryKey = 'cpf'
    return (
        <div>
        <Table columnNames={columnNames} apiPath={apiPath} primaryKey={primaryKey} />
        </div>
    );
}
