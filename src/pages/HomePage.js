import React, { useEffect, useState } from 'react';
import { DataGrid } from '@mui/x-data-grid';

export default function App() {
  const apiPath = 'http://localhost/ru/api/'
  const [rows, setRows] = useState([])
  const [columns, setColumns] = useState([])

  useEffect(() => { fetchData(); }, [])

  const fetchData = async () => {
    try {
      const response = await fetch(apiPath)
      const jsonData = await response.json()

      const items = jsonData.map(item => ({
        ...item,
        id: item.cpf
      }))
      setRows(items)

      const columnNames = Object.keys(jsonData[0])
      const col = columnNames.map(name => ({
        field: name,
        headerName: name,
        width: 150
      }))
      setColumns(col)

    } catch (error) {
      console.error('Erro ao buscar dados:', error)
    }
  }

  return (
    <div>
      <DataGrid autoHeight rows={rows} columns={columns} />
    </div>
  );
}
