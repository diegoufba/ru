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
  const movimentacoes = props.movimentacoes
  return (
    <TableContainer component={Paper} elevation={3} sx={{ ml: 2, p: 2, borderRadius: '1rem' }}>
      <Typography sx={{ mb: 2 }} variant="h5" gutterBottom>
        Movimentações
      </Typography>
      <Table aria-label="simple table">
        <TableHead>
          <TableRow>
            <TableCell sx={{fontWeight:'bold'}}>Tipo</TableCell>
            <TableCell sx={{fontWeight:'bold'}}>Valor</TableCell>
            <TableCell sx={{fontWeight:'bold'}}>Data</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {movimentacoes.map((row) => (
            <TableRow key={row.id}>
              <TableCell >{row.tipo}</TableCell>
              <TableCell >{row.valor}</TableCell>
              <TableCell >{row.data}</TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  );
}