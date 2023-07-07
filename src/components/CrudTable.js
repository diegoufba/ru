import React, {useState } from 'react';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import AddIcon from '@mui/icons-material/Add';
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/DeleteOutlined';
import SaveIcon from '@mui/icons-material/Save';
import CancelIcon from '@mui/icons-material/Close';
import Snackbar from '@mui/material/Snackbar';
import Alert from '@mui/material/Alert';

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
    const { setRows, setRowModesModel, columnNames } = props;

    const handleClick = () => {
        const internalId = randomId();
        const newRow = columnNames.reduce((acc, columnName) => {
            acc[columnName] = '';
            return acc;
        }, { internalId, isNew: true });

        setRows((oldRows) => [...oldRows, newRow]);
        setRowModesModel((oldModel) => ({
            ...oldModel,
            [internalId]: { mode: GridRowModes.Edit, fieldToFocus: columnNames[0] },
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

export default function CrudTable(props) {
    const opcoes = props.opcoes
    const apiPath = props.apiPath
    const columnNames = props.columnNames
    const primaryKey = props.primaryKey
    const rows = props.rows
    const setRows = props.setRows

    // const [rows, setRows] = useState([]);
    const [snackbar, setSnackbar] = useState(null);
    const handleCloseSnackbar = () => setSnackbar(null);

    const columns = columnNames.map(name => {
        if (opcoes.hasOwnProperty(name)) {
            return {
                field: name,
                headerName: name,
                width: 150,
                editable: name === 'id' ? false : true,
                type: 'singleSelect',
                valueOptions: opcoes[name],
            };
        } else {
            return {
                field: name,
                headerName: name,
                width: 150,
                editable: name === 'id' ? false : true,
            };
        }
    });
    // editable: name === primaryKey ? false: true
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
                    icon={<EditIcon color='success' />}
                    label="Edit"
                    className="textPrimary"
                    onClick={handleEditClick(id)}
                    color="inherit"
                />,
                <GridActionsCellItem
                    icon={<DeleteIcon color='error' />}
                    label="Delete"
                    onClick={handleDeleteClick(id)}
                    color="inherit"
                />,
            ];
        },
    })
    const [rowModesModel, setRowModesModel] = useState({});

    // useEffect(() => { fetchData(apiPath); }, [])

    // const fetchData = async (apiPath) => {
    //     try {
    //         const response = await fetch(apiPath)
    //         const jsonData = await response.json()

    //         const items = jsonData.map(item => ({
    //             ...item,
    //             internalId: randomId()
    //         }))
    //         setRows(items)

    //     } catch (error) {
    //         console.error('Erro ao buscar dados:', error)
    //     }
    // }

    const handleRowEditStop = (params, event) => {
        if (params.reason === GridRowEditStopReasons.rowFocusOut) {
            event.defaultMuiPrevented = true;
        }
    };

    const handleEditClick = (internalId) => () => {
        setRowModesModel({ ...rowModesModel, [internalId]: { mode: GridRowModes.Edit } });
    };

    const handleSaveClick = (internalId) => () => {
        setRowModesModel({ ...rowModesModel, [internalId]: { mode: GridRowModes.View } });
    };

    const handleDeleteClick = (internalId) => async () => {
        const row = rows.find(row => row.internalId === internalId)
        const id = row[primaryKey]
        
        const [sucess, message] = await saveOnDatabase(null, 'DELETE', id);
        if (sucess) {
            setRows(rows.filter((row) => row.internalId !== internalId));
            setSnackbar({ children: message, severity: 'success' });
        } else {
            setSnackbar({ children: message, severity: 'error' });
        }
    };


    const handleCancelClick = (internalId) => () => {
        setRowModesModel({
            ...rowModesModel,
            [internalId]: { mode: GridRowModes.View, ignoreModifications: true },
        });

        const editedRow = rows.find((row) => row.internalId === internalId);
        if (editedRow.isNew) {
            setRows(rows.filter((row) => row.internalId !== internalId));
        }
    };

    // async function saveOnDatabase(updatedRow, method, id) {
    //     const row = {}
    //     if (method !== 'DELETE') {
    //         columnNames.map((columnName) => {
    //             row[columnName] = updatedRow[columnName]
    //         })
    //     }

    //     const apiUrl = id ? `${apiPath}?id=${id}` : apiPath;
    //     let result = [false, ""]

    //     await fetch(apiUrl, {
    //         method: method,
    //         headers: {
    //             'Content-Type': 'application/json',
    //         },
    //         body: method !== 'DELETE' ? JSON.stringify(row) : undefined,
    //     })
    //         .then(response => {
    //             if (response.ok) {
    //                 result = [true, `Requisição ${method} bem-sucedida`]
    //             } else {
    //                 result = [false, `Erro na requisição ${method}`]
    //             }
    //         })
    //     return result
    // }

    // async function saveOnDatabase(updatedRow, method, id) {
    //     const row = {};
    //     if (method !== 'DELETE') {
    //       columnNames.map((columnName) => {
    //         row[columnName] = updatedRow[columnName];
    //       });
    //     }
      
    async function saveOnDatabase(updatedRow, method, id) {
        const row = {};
        if (method !== 'DELETE') {
          columnNames.map((columnName) => {
            row[columnName] = updatedRow[columnName];
          });
        }
      
        const apiUrl = id ? `${apiPath}?id=${id}` : apiPath;
        let result = [false, ""];
      
        try {
          const response = await fetch(apiUrl, {
            method: method,
            headers: {
              'Content-Type': 'application/json',
            },
            body: method !== 'DELETE' ? JSON.stringify(row) : undefined,
          });
      
          if (response.ok) {
            const responseData = await response.json();
            if (responseData.success) {
              result = [true, `Requisição ${method} e operação no banco de dados bem-sucedidas`];
            } else {
              result = [false, `Erro na operação no banco de dados`];
            }
          } else {
            result = [false, `Erro na requisição ${method}`];
          }
        } catch (error) {
          result = [false, `Erro na requisição ${method}: ${error.message}`];
        }
      
        return result;
      }
      
      

    const processRowUpdate = async (newRow) => {
        const method = newRow.isNew ? 'POST' : 'PUT'
        const [sucess, message] = await saveOnDatabase(newRow, method)
        if (sucess) {
            const updatedRow = { ...newRow, isNew: false };
            setRows(rows.map((row) => (row.internalId === newRow.internalId ? updatedRow : row)));
            setSnackbar({ children: message, severity: 'success' });
            return updatedRow;
        }
        else {
            setSnackbar({ children: message, severity: 'error' });
            return false;
        }
    };

    const handleProcessRowUpdateError = (error) => {
    }

    const handleRowModesModelChange = (newRowModesModel) => {
        setRowModesModel(newRowModesModel);
    };

    return (
        <Box
            sx={{
                height: '100%',
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
                sx={{
                    '.MuiDataGrid-columnHeaderTitle': {
                        fontWeight: 'bold !important',
                    },
                    backgroundColor: 'white'
                }}
                getRowId={(row) => row.internalId}
                rows={rows}
                columns={columns}
                editMode="row"
                rowModesModel={rowModesModel}
                onRowModesModelChange={handleRowModesModelChange}
                onRowEditStop={handleRowEditStop}
                processRowUpdate={processRowUpdate}
                onProcessRowUpdateError={handleProcessRowUpdateError}
                slots={{
                    toolbar: EditToolbar,
                }}
                slotProps={{
                    toolbar: { setRows, setRowModesModel, columnNames },
                }}
            />
            {!!snackbar && (
                <Snackbar
                    open
                    anchorOrigin={{ vertical: 'top', horizontal: 'center' }}
                    onClose={handleCloseSnackbar}
                    autoHideDuration={2000}
                >
                    <Alert {...snackbar} onClose={handleCloseSnackbar} />
                </Snackbar>
            )}
        </Box>
    )
}