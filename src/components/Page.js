import React, { useState } from 'react';
import CrudTableContainer from './CrudTableContainer';
import Menu from './Menu';
import Box from '@mui/material/Box';
import Container from '@mui/material/Container';
import Typography from '@mui/material/Typography';

// import CrudTable from './CrudTable';


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
                <CrudTableContainer rows={rows} attributeToCompareName={props.attributeToCompareName} columnNames={props.columnNames} setRows={setRows} opcoes={props.opcoes} apiPath={props.apiPath} primaryKey={props.primaryKey} />
            </Box>
        </Container>
    );
}
