import React, { useEffect, useState } from 'react';
import Table from './Table';
import Menu from './Menu';
import Busca from './Busca';
import Box from '@mui/material/Box';
import Container from '@mui/material/Container';
import Typography from '@mui/material/Typography';


//Falta: bloquear edicao da primary key
export default function Page(props) {
    const [rows, setRows] = useState([]);
    return (
        <Container maxWidth="xl" sx={{ display: 'flex' }}>
            <Menu />
            <Box sx={{ p: 1 }}>
                <Typography color="primary" variant="h4" gutterBottom>
                    {props.title}
                </Typography>
                <Box sx={{ boxShadow: 3, mt: 2, p:2,backgroundColor: 'white' }}>
                    <Busca setRows={setRows} opcoes={props.opcoes} apiPath={props.apiPath}/>
                </Box>
                <Box sx={{ boxShadow: 3, mt: 2 }}>
                    <Table row={rows} setRows={setRows} columnNames={props.columnNames} opcoes={props.opcoes} apiPath={props.apiPath} primaryKey={props.primaryKey} />
                </Box>
            </Box>
        </Container>
    );
}
