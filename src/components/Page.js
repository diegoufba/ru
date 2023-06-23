import React from 'react';
import Table from './Table';
import Menu from './Menu';
import Box from '@mui/material/Box';
import Container from '@mui/material/Container';
import Typography from '@mui/material/Typography';


//Falta: bloquear edicao da primary key
export default function Page(props) {
    return (
        <Container maxWidth="xl" sx={{ display: 'flex' }}>
            <Menu />
            <Box sx={{ p: 1 }}>
                <Typography color="primary" variant="h4" gutterBottom>
                    {props.title}
                </Typography>
                <Box sx={{ boxShadow: 3 }}>
                    <Table columnNames={props.columnNames} opcoes={props.opcoes} apiPath={props.apiPath} primaryKey={props.primaryKey} />
                </Box>
            </Box>
        </Container>
    );
}
