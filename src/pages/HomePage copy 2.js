import React, { useEffect, useState } from 'react';
import { DataGrid, GridToolbar } from '@mui/x-data-grid';

function FuncionariosGrid() {
  const [funcionarios, setFuncionarios] = useState([]);
  const [editRowsModel, setEditRowsModel] = useState({});

  useEffect(() => {
    fetchFuncionarios();
  }, []);

  const fetchFuncionarios = async () => {
    try {
      const response = await fetch('http://localhost/ru/api/');
      const data = await response.json();

      const funcionariosComId = data.map(funcionario => ({
        ...funcionario,
        id: funcionario.cpf,
      }));

      setFuncionarios(funcionariosComId);
    } catch (error) {
      console.error('Erro ao buscar os funcionários:', error);
    }
  };

  const handleEditRowModelChange = (newModel) => {
    setEditRowsModel(newModel);
  };

  const handleSave = async (params) => {
    try {
      const response = await fetch('http://localhost/ru/api/', {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(params),
      });

      if (response.ok) {
        fetchFuncionarios();
      } else {
        console.error('Erro ao salvar os dados dos funcionários');
      }
    } catch (error) {
      console.error('Erro ao salvar os dados dos funcionários:', error);
    }
  };

  const columns = [
    { field: 'cpf', headerName: 'CPF', width: 150, editable: false },
    { field: 'nome', headerName: 'Nome', width: 200, editable: true },
    { field: 'salario', headerName: 'Salário', width: 150, editable: true },
  ];

  return (
    <div style={{ height: 400, width: '100%' }}>
      <DataGrid
        rows={funcionarios}
        columns={columns}
        editRowsModel={editRowsModel}
        onEditRowModelChange={handleEditRowModelChange}
        pageSize={5}
        components={{
          Toolbar: GridToolbar,
        }}
        isCellEditable={(params) => params.row.id !== undefined}
        onEditCellChangeCommitted={handleSave}
      />
    </div>
  );
}

export default FuncionariosGrid;
