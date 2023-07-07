// MyTableContainer.js
import React, { useEffect, useState } from 'react';
import CrudTable from './CrudTable';
import Busca from './Busca';
import { randomId } from '@mui/x-data-grid-generator';
import Box from '@mui/material/Box';

function CrudTableContainer(props) {
  const apiPath = props.apiPath
  const [columnNames, setcolumnNames] = useState([]);

  useEffect(() => { fetchData(apiPath) }, [])

  const fetchData = async (apiPath) => {
    try {
      const response = await fetch(apiPath)
      const jsonData = await response.json()

      const items = jsonData.map(item => ({
        ...item,
        internalId: randomId()
      }))
      props.setRows(items)

      const columns = jsonData.length > 0 ? Object.keys(jsonData[0]) : []
      setcolumnNames(columns)

    } catch (error) {
      console.error('Erro ao buscar dados:', error)
    }
  }

  if (columnNames.length !== 0 && props.rows !== 0) {
    return (
      <>
        <Box sx={{ boxShadow: 3, mt: 2, p: 2, backgroundColor: 'white' }}>
          <Busca setRows={props.setRows} columnNames={columnNames} opcoes={props.opcoes} apiPath={props.apiPath} attributeToCompareName={props.attributeToCompareName} />
        </Box>
        <Box sx={{ boxShadow: 3, mt: 2 }}>
          <CrudTable columnNames={columnNames} rows={props.rows} setRows={props.setRows} opcoes={props.opcoes} apiPath={props.apiPath} primaryKey={props.primaryKey} />
        </Box>
      </>
    )
  }
  // Pode exibir um indicador de carregamento enquanto as colunas estão sendo carregadas
  return <div></div>
}

export default CrudTableContainer;
