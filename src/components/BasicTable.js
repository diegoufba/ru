import * as React from 'react';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import Typography from '@mui/material/Typography';

export default function BasicTable(props) {
  const linhas = props.linhas
  const columns = Object.keys(linhas[0]) 
  // const columns = ['id', 'tipo', 'valor', 'data']
  // console.log(columns)
  return (
    <TableContainer component={Paper} elevation={3} sx={{ p: 2, borderRadius: '1rem' }}>
      <Typography sx={{ mb: 2 }} variant="h5" gutterBottom>
        {props.nome}
      </Typography>
      <Table aria-label="simple table">
        <TableHead>
          <TableRow>
            {columns.map((column) => (
              <TableCell sx={{fontWeight:'bold'}}>{column}</TableCell>
            ))}
          </TableRow>
        </TableHead>
        <TableBody>
          {linhas.map((row) => (
            <TableRow key={row.id}>
              {columns.map((column) => (
                <TableCell >{row[column]}</TableCell>
              ))}
              {/* <TableCell >{row.id}</TableCell>
              <TableCell >{row.tipo}</TableCell>
              <TableCell >{row.valor}</TableCell>
              <TableCell >{row.data}</TableCell> */}
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  );
}