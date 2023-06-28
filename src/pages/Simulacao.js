import React, { useEffect, useState } from 'react';
import Box from '@mui/material/Box';
import Container from '@mui/material/Container';
import Typography from '@mui/material/Typography';
import TextField from '@mui/material/TextField';
import MenuItem from '@mui/material/MenuItem';
import Menu from '../components/Menu';

export default function Simulacao(props) {

    const urlBaseAvatar = "https://api.dicebear.com/6.x/personas/svg?size=128"
    const [avatarUrl, setAvatarUrl] = useState(urlBaseAvatar)

    const apiPath = 'http://localhost/ru/api/simulacao/'
    const campus = ['Ondina', 'São Lázaro', 'Vitória']

    const [dados, setDados] = useState({})
    const [cpfs, setCpfs] = useState([])

    const [cpf, setCpf] = useState('')
    const [campus_ru, setCampus_ru] = useState('')

    const handleCpfChange = (event) => {
        const cpf = event.target.value
        setCpf(cpf)
        fetchData(apiPath, cpf)
    };

    const handleCampus_ruChange = (event) => {
        setCampus_ru(event.target.value);
    };

    useEffect(() => { getCpfs(apiPath); }, [])

    const getCpfs = async (apiPath) => {
        try {
            const response = await fetch(apiPath)
            const jsonData = await response.json()

            setCpfs(jsonData)

        } catch (error) {
            console.error('Erro ao buscar dados:', error)
        }
    }

    const fetchData = async (apiPath, cpf) => {
        try {
            const response = await fetch(`${apiPath}?cpf=${cpf}`)
            const jsonData = await response.json()
            setDados(jsonData)
            setAvatarUrl(`${urlBaseAvatar}&seed=${jsonData.cpf}`)

        } catch (error) {
            console.error('Erro ao buscar dados:', error)
        }
    }

    return (
        <Container maxWidth="xl" sx={{ display: 'flex' }}>
            <Menu />
            <Box sx={{ flexGrow: 1, m: 1 }}>
                <Box sx={{ display: 'flex' }}>
                    <Typography color="primary" variant="h4" gutterBottom>
                        Conta
                    </Typography>
                </Box>
                <Box sx={{ display: 'flex', boxShadow: 3, mt: 2, p: 2, backgroundColor: 'white' }} component="form" noValidate autoComplete="off" >
                    <TextField
                        sx={{ minWidth: 'calc(6em + 20px)', mr: 2 }}
                        id="outlined-select-cpf"
                        select
                        label="cpf"
                        value={cpf}
                        onChange={handleCpfChange}
                        variant='standard'
                    >
                        {cpfs.map((cpf) => (
                            <MenuItem key={cpf} value={cpf}>
                                {cpf}
                            </MenuItem>
                        ))}
                    </TextField>
                    <TextField
                        sx={{ minWidth: 'calc(8em + 20px)' }}
                        id="outlined-select-campus"
                        select
                        label="campus_ru"
                        value={campus_ru}
                        onChange={handleCampus_ruChange}
                        variant='standard'
                    >
                        {campus.map((cam) => (
                            <MenuItem key={cam} value={cam}>
                                {cam}
                            </MenuItem>
                        ))}
                    </TextField>
                </Box>
                <Box sx={{ display: 'flex', boxShadow: 3, mt: 2, p: 2, backgroundColor: 'white' }}>
                    {dados.nome ? <img src={avatarUrl} alt="Avatar" /> : null}
                    <Box sx={{ mt: 2, ml: 2 }}>
                        <Typography variant="body1" gutterBottom>
                            <span style={{ fontWeight: 'bold' }}>Nome: </span>
                            {dados.nome}
                        </Typography>
                        <Typography variant="body1" gutterBottom>
                            <span style={{ fontWeight: 'bold' }}>Tipo: </span>
                            {dados.tipo}
                        </Typography>
                        {dados.saldo ? <Typography variant="body1" gutterBottom>
                            <span style={{ fontWeight: 'bold' }}>Saldo: </span>
                            R$ {dados.saldo}
                        </Typography> : null}

                    </Box>
                </Box>
            </Box>
        </Container>
    );
}
