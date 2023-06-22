import React from 'react';
import Table from '../components/Table';


//Falta: bloquear edicao da primary key
// select em campos onde é select
export default function Funcionario() {
    const columnNames = ['cpf', 'nome','campus_ru', 'salario','turno','funcao']
    const apiPath = 'http://localhost/ru/api/funcionario/'
    const primaryKey = 'cpf'
    return (
        <div>
            <Table columnNames={columnNames} apiPath={apiPath} primaryKey={primaryKey} />
        </div>
    );
}
