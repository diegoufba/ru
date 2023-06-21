import React, { useEffect, useState } from 'react';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/DeleteOutlined';
import SaveIcon from '@mui/icons-material/Save';
import CancelIcon from '@mui/icons-material/Close';
import {
    GridRowModes,
    DataGrid,
    GridToolbarContainer,
    GridActionsCellItem,
    GridRowEditStopReasons,
} from '@mui/x-data-grid';
import {
    randomId,
} from '@mui/x-data-grid-generator';


function EditToolbar(props) {
    // const { setRows, setRowModesModel } = props;
    // const columnNames = ['cpf', 'nome', 'salario']
    const { setRows, setRowModesModel, columnNames } = props;

    const handleClick = () => {
        const id = randomId();
        const newRow = columnNames.reduce((acc, columnName) => {
            acc[columnName] = '';
            return acc;
        }, { id, isNew: true });

        setRows((oldRows) => [...oldRows, newRow]);
        // setRows((oldRows) => [...oldRows, { id, cpf: '', nome: '', salario: '', isNew: true }]);
        setRowModesModel((oldModel) => ({
            ...oldModel,
            [id]: { mode: GridRowModes.Edit, fieldToFocus: 'name' },
        }));
    };

    return (
        <GridToolbarContainer>
            <Button color="primary" startIcon={<AddIcon />} onClick={handleClick}>
                Adicionar
            </Button>
        </GridToolbarContainer>
    );
}

export default function Table(props) {
    // const columnNames = ['cpf', 'nome', 'salario']
    const apiPath = props.apiPath
    const columnNames = props.columnNames
    const primaryKey = props.primaryKey

    const [rows, setRows] = useState([]);

    const columns = columnNames.map(name => ({
        field: name,
        headerName: name,
        width: 150,
        editable: true,
    }))
    columns.push({
        field: 'actions',
        type: 'actions',
        headerName: 'Ações',
        width: 100,
        cellClassName: 'actions',
        getActions: ({ id }) => {
            const isInEditMode = rowModesModel[id]?.mode === GridRowModes.Edit;

            if (isInEditMode) {
                return [
                    <GridActionsCellItem
                        icon={<SaveIcon />}
                        label="Save"
                        sx={{
                            color: 'primary.main',
                        }}
                        onClick={handleSaveClick(id)}
                    />,
                    <GridActionsCellItem
                        icon={<CancelIcon />}
                        label="Cancel"
                        className="textPrimary"
                        onClick={handleCancelClick(id)}
                        color="inherit"
                    />,
                ];
            }

            return [
                <GridActionsCellItem
                    icon={<EditIcon />}
                    label="Edit"
                    className="textPrimary"
                    onClick={handleEditClick(id)}
                    color="inherit"
                />,
                <GridActionsCellItem
                    icon={<DeleteIcon />}
                    label="Delete"
                    onClick={handleDeleteClick(id)}
                    color="inherit"
                />,
            ];
        },
    })
    const [rowModesModel, setRowModesModel] = useState({});

    useEffect(() => { fetchData(apiPath, primaryKey); }, [])

    const fetchData = async (apiPath, primaryKey) => {
        try {
            const response = await fetch(apiPath)
            const jsonData = await response.json()

            // cpf é a chave primaria
            const items = jsonData.map(item => ({
                ...item,
                id: item[primaryKey]
            }))
            setRows(items)

        } catch (error) {
            console.error('Erro ao buscar dados:', error)
        }
    }

    const handleRowEditStop = (params, event) => {
        if (params.reason === GridRowEditStopReasons.rowFocusOut) {
            event.defaultMuiPrevented = true;
        }
    };

    const handleEditClick = (id) => () => {
        setRowModesModel({ ...rowModesModel, [id]: { mode: GridRowModes.Edit } });
    };

    const handleSaveClick = (id) => () => {
        setRowModesModel({ ...rowModesModel, [id]: { mode: GridRowModes.View } });
    };

    const handleDeleteClick = (id) => () => {
        setRows(rows.filter((row) => row.id !== id));
        saveOnDatabase(null, 'DELETE', id);
    };


    const handleCancelClick = (id) => () => {
        setRowModesModel({
            ...rowModesModel,
            [id]: { mode: GridRowModes.View, ignoreModifications: true },
        });

        const editedRow = rows.find((row) => row.id === id);
        if (editedRow.isNew) {
            setRows(rows.filter((row) => row.id !== id));
        }
    };

    function saveOnDatabase(updatedRow, method, id) {
        const row = {}
        if (method !== 'DELETE') {
            columnNames.map((columnName) => {
                row[columnName] = updatedRow[columnName]
            })
        }

        // const apiUrl = id ? `${apiPath}${id}` : apiPath;
        const apiUrl = id ? `${apiPath}?${primaryKey}=${id}` : apiPath;

        fetch(apiUrl, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: method !== 'DELETE' ? JSON.stringify(row) : undefined,
        })
            .then(response => {
                if (response.ok) {
                    console.log(`Requisição ${method} bem-sucedida`);
                    // Lógica adicional aqui, se necessário
                } else {
                    console.error(`Erro na requisição ${method}`);
                    // Tratar o erro aqui, se necessário
                }
            })
            .catch(error => {
                console.error(`Erro na requisição ${method}`, error);
                // Tratar o erro aqui, se necessário
            });
    }

    const processRowUpdate = (newRow) => {
        const method = newRow.isNew ? 'POST' : 'PUT'
        const updatedRow = { ...newRow, isNew: false };
        setRows(rows.map((row) => (row.id === newRow.id ? updatedRow : row)));
        saveOnDatabase(updatedRow, method)

        return updatedRow;
    };

    const handleRowModesModelChange = (newRowModesModel) => {
        setRowModesModel(newRowModesModel);
    };

    return (
        <Box
            sx={{
                height: 500,
                width: '100%',
                '& .actions': {
                    color: 'text.secondary',
                },
                '& .textPrimary': {
                    color: 'text.primary',
                },
            }}
        >
            <DataGrid
                rows={rows}
                columns={columns}
                editMode="row"
                rowModesModel={rowModesModel}
                onRowModesModelChange={handleRowModesModelChange}
                onRowEditStop={handleRowEditStop}
                processRowUpdate={processRowUpdate}
                slots={{
                    toolbar: EditToolbar,
                }}
                slotProps={{
                    toolbar: { setRows, setRowModesModel,columnNames },
                }}
            />
        </Box>
    );
}