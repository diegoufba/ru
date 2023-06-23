import React from 'react';
import Table from '../components/Table';
import Menu from '../components/Menu';
import Box from '@mui/material/Box';
import Container from '@mui/material/Container';
import Typography from '@mui/material/Typography';


//Falta: bloquear edicao da primary key
export default function Funcionario() {
    const apiPath = 'http://localhost/ru/api/funcionario/'
    const columnNames = ['cpf', 'nome', 'campus_ru', 'salario', 'turno', 'funcao']
    const primaryKey = 'cpf'
    const opcoes = {
        turno: ['matutino', 'vespertino', 'noturno'],
        campus_ru: ['Ondina', 'São Lazaro', 'Vitória'],
        funcao: ['Cozinheiro', 'Chef de cozinha', 'Nutricionista', 'Auxiliar de cozinha', 'Caixa', 'Auxiliar de limpeza', 'Gerente']
    }
    return (
        <Container maxWidth="xl" sx={{ display: 'flex' }}>
            <Menu />
            <Box sx={{ p: 1 }}>
                <Typography variant="h4" gutterBottom>
                    Funcionário
                </Typography>
                <Box sx={{ boxShadow: 3 }}>
                    <Table columnNames={columnNames} opcoes={opcoes} apiPath={apiPath} primaryKey={primaryKey} />
                </Box>
            </Box>
        </Container>
    );
}
