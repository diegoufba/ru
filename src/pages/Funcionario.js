import React from 'react';
import Table from '../components/Table';
import Container from '@mui/material/Container';


//Falta: bloquear edicao da primary key
// select em campos onde é select
export default function Funcionario() {
    const apiPath = 'http://localhost/ru/api/funcionario/'
    const columnNames = ['cpf', 'nome','campus_ru', 'salario','turno','funcao']
    const primaryKey = 'cpf'
    const opcoes = {
        turno: ['matutino', 'vespertino', 'noturno'],
        campus_ru: ['Ondina', 'São Lazaro', 'Vitória'],
        funcao: ['Cozinheiro', 'Chef de cozinha', 'Nutricionista', 'Auxiliar de cozinha', 'Caixa', 'Auxiliar de limpeza', 'Gerente']
    }
    return (
        <Container sx={{marginTop:'2rem'}} maxWidth="xl">
            <Table columnNames={columnNames} opcoes={opcoes} apiPath={apiPath} primaryKey={primaryKey} />
        </Container>
    );
}
