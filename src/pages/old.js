import React, { useEffect, useState } from 'react';
import { DataGrid } from '@mui/x-data-grid';
import Button from '@mui/material/Button';

export default function App() {
  const apiPath = 'http://localhost/ru/api/'
  const [rows, setRows] = useState([])
  const [columns, setColumns] = useState([])

  useEffect(() => { fetchData(); }, [])

  const fetchData = async () => {
    try {
      const response = await fetch(apiPath)
      const jsonData = await response.json()

      // cpf é a chave primaria
      const items = jsonData.map(item => ({
        ...item,
        id: item.cpf
      }))
      setRows(items)

      const columnNames = Object.keys(jsonData[0])
      const col = columnNames.map(name => ({
        field: name,
        headerName: name,
        width: 150,
        editable: true,
      }))
      setColumns(col)

    } catch (error) {
      console.error('Erro ao buscar dados:', error)
    }
  }

  function mySaveOnServerFunction(updatedRow) {
    fetch(apiPath, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(updatedRow),
    })
      .then(response => {
        if (response.ok) {
          console.log('Requisição PUT bem-sucedida');
          // Lógica adicional aqui, se necessário
        } else {
          console.error('Erro na requisição PUT');
          // Tratar o erro aqui, se necessário
        }
      })
      .catch(error => {
        console.error('Erro na requisição PUT', error);
        // Tratar o erro aqui, se necessário
      });
  }
  function nothing(){

  }
  function test(){
    console.log(rows)
  }

  return (
    <div>
      <Button onClick={test} variant="contained">Contained</Button>
      <DataGrid
        autoHeight
        editMode="row"
        rows={rows}
        columns={columns}
        processRowUpdate={(updatedRow, originalRow) =>
          mySaveOnServerFunction(updatedRow)
        }
        onProcessRowUpdateError={nothing}
      />
    </div>
  );
}
