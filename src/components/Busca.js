import React, { useEffect, useState } from 'react';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import MenuItem from '@mui/material/MenuItem';
import { randomId } from '@mui/x-data-grid-generator';



export default function Busca(props) {
    const opcoes = props.opcoes
    const baseApiPath = props.apiPath + 'busca/'
    const setRows = props.setRows
    const nomeIsDefined = props.columnNames.includes('nome')

    const attributeToCompareName = props.attributeToCompareName
    const operadores = ["<", "<=", "=", ">=", ">"]
    const [operadorValue, setOperadorValue] = useState('=');
    const [attributeToCompare, setAttributeToCompare] = useState('')

    const [nome, setNome] = useState('');
    const [parametros, setParametros] = useState({});

    const handleChangeNome = (event) => {
        setNome(event.target.value);
    };

    const handleChangeOperador = (event) => {
        setOperadorValue(event.target.value);
    };

    const handleChangeattributeToCompare = (event) => {
        setAttributeToCompare(event.target.value);
    };

    const handleChangeParametro = (event, chave) => {
        const valor = event.target.value;
        setParametros((prevParametros) => ({
            ...prevParametros,
            [chave]: valor,
        }));
    };

    const handleClear = () => {
        setNome('')
        setParametros({})
        setOperadorValue('=')
        setAttributeToCompare('')
        fetchData(false)
    }

    const fetchData = async (includeQueries) => {
        try {
            const parametrosComNome = attributeToCompareName ? { ...parametros, nome: nome, operador: operadorValue, [attributeToCompareName]: attributeToCompare } :
                { ...parametros, nome: nome }
            console.log(parametrosComNome)
            const queryParams = new URLSearchParams(parametrosComNome).toString();
            const apiPath = includeQueries ? `${baseApiPath}?${queryParams}` : baseApiPath;
            console.log(apiPath)
            const response = await fetch(apiPath)
            const jsonData = await response.json()

            const items = jsonData.map(item => ({
                ...item,
                internalId: randomId()
            }))
            setRows(items)

        } catch (error) {
            console.error('Erro ao buscar dados:', error)
        }
    }

    return (
        <Box component="form" noValidate autoComplete="off">
            {nomeIsDefined ? <TextField value={nome} onChange={handleChangeNome} fullWidth id="outlined-basic" label="Nome" variant="outlined" /> : null}
            <Box sx={{ display: 'flex', flexDirection: 'column', mt: 2 }}>
                <Box>
                    {Object.keys(opcoes).map((chave) => (
                        <TextField
                            key={chave}
                            sx={{ mr: 2, minWidth: 200 }}
                            id={`outlined-select-${chave}`}
                            select
                            label={chave}
                            defaultValue="Todos"
                            value={parametros[chave] || 'Todos'}
                            onChange={(event) => handleChangeParametro(event, chave)}
                        >
                            <MenuItem key='Todos' value='Todos'>
                                Todos
                            </MenuItem>
                            {opcoes[chave].map((opcao) => (
                                <MenuItem key={opcao} value={opcao}>
                                    {opcao}
                                </MenuItem>
                            ))}
                        </TextField>
                    ))}
                </Box>
                <Box sx={{ display: 'flex', alignItems: 'center', mt: 2 }}>
                    {attributeToCompareName ? <>
                        <TextField
                            sx={{ minWidth: 'calc(6em + 20px)' }}
                            key="operador"
                            value={operadorValue}
                            id="outlined-select-operador"
                            select
                            label={attributeToCompareName}
                            onChange={handleChangeOperador}
                        >
                            {operadores.map((operador) => (
                                <MenuItem key={operador} value={operador}>
                                    {operador}
                                </MenuItem>
                            ))}
                        </TextField>
                        <TextField onChange={handleChangeattributeToCompare} sx={{ mr: 2 }} id="outlined-attributeToCompare" value={attributeToCompare} label='valor' variant="outlined" />
                    </> : null}
                    <Button onClick={() => { fetchData(true) }} size="large" variant="contained">Filtrar</Button>
                    <Button onClick={handleClear} sx={{ ml: 2 }} size="large" variant="outlined">Limpar</Button>
                </Box>
            </Box>
        </Box>
    );
}
