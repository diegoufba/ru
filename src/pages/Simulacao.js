import React, { useEffect, useState } from 'react';
import Box from '@mui/material/Box';
import Container from '@mui/material/Container';
import Typography from '@mui/material/Typography';
import TextField from '@mui/material/TextField';
import MenuItem from '@mui/material/MenuItem';
import Menu from '../components/Menu';
import Button from '@mui/material/Button';
import Grid from '@mui/material/Grid';
import Paper from '@mui/material/Paper';
import BasicTable from '../components/BasicTable'
import Toolbar from '@mui/material/Toolbar';
import Snackbar from '@mui/material/Snackbar';
import MuiAlert from '@mui/material/Alert';

const Alert = React.forwardRef(function Alert(props, ref) {
    return <MuiAlert elevation={6} ref={ref} variant="filled" {...props} />;
});



export default function Simulacao(props) {

    const [open, setOpen] = React.useState(false);
    const [recargaSucess, setRecargaSucess] = useState(false)

    const handleClose = (event, reason) => {
        if (reason === 'clickaway') {
            return;
        }

        setOpen(false);
    };

    const urlBaseAvatar = "https://api.dicebear.com/6.x/personas/svg?size=128"
    const [avatarUrl, setAvatarUrl] = useState(urlBaseAvatar)

    const apiPath = 'http://localhost/ru/api/simulacao/'

    const [movimentacoes, setMovimentacoes] = useState([])

    const [dados, setDados] = useState({})
    const [cpfs, setCpfs] = useState([])
    const [campus, setCampus] = useState([])

    const [cpf, setCpf] = useState('')
    const [campus_ru, setCampus_ru] = useState('')

    const handleCpfChange = async (event) => {
        const cpf = event.target.value
        setCpf(cpf)
        await fetchData(apiPath, cpf)
    };

    const handleCampus_ruChange = (event) => {
        setCampus_ru(event.target.value);
    };

    useEffect(() => { fetchData(apiPath); }, [])

    const fetchData = async (apiPath, cpf) => {
        try {
            const path = cpf ? `${apiPath}?cpf=${cpf}` : apiPath
            const response = await fetch(path)
            const jsonData = await response.json()

            if (cpf) {
                setDados(jsonData.usuario)
                setAvatarUrl(`${urlBaseAvatar}&seed=${jsonData.usuario.cpf}`)
                setMovimentacoes(jsonData.conta)
            } else {
                setCpfs(jsonData.cpfs)
                setCampus(jsonData.campus)

                setCpf(jsonData.cpfs[1])
                fetchData(apiPath, jsonData.cpfs[1])

            }
        } catch (error) {
            console.error('Erro ao buscar dados:', error)
        }
    }

    const handleRecargaButton = async (valor) => {
        const op = await recarga(valor)
        setRecargaSucess(op)
        await fetchData(apiPath, cpf)
        setOpen(true)
    }

    async function recarga(valor) {
        const body = {
            id_conta: dados.id_conta,
            valor: valor,
            tipo: 'recarga'
        }
        let result = false
        await fetch(apiPath, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(body)
        })
            .then(response => {
                if (response.ok) {
                    result = true
                } else {
                    result = false
                }
            })
        if (result) {
            await fetch(apiPath, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(body)
            })
                .then(response => {
                    if (response.ok) {
                        result = true
                    } else {
                        result = false
                    }
                })
        }
        return result
    }

    return (
        <Container maxWidth="xl" sx={{ display: 'flex' }}>
            <Menu />
            <Snackbar anchorOrigin={{ vertical: 'top', horizontal: 'center' }} open={open} autoHideDuration={2000} onClose={handleClose}>
                {recargaSucess ?
                    <Alert onClose={handleClose} severity="success" sx={{ width: '100%' }}>
                        Recarga realizada com sucesso
                    </Alert> :
                    <Alert onClose={handleClose} severity="error" sx={{ width: '100%' }}>
                        Falha na Recarga
                    </Alert>}

            </Snackbar>
            <Box sx={{ m: 1 }}>
                <Typography color="primary" variant="h4" gutterBottom>
                    Conta
                </Typography>

                <Paper elevation={3} sx={{ mt: 2, p: 2, borderRadius: '1rem', width: '380px' }}>
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
                    <Box sx={{ display: 'flex', mt: 3 }}>
                        {dados.nome ? <img src={avatarUrl} alt="Avatar" /> : null}
                        <Box sx={{ mt: 2, ml: 2 }}>
                            {dados.nome ? <Typography variant="body1" gutterBottom>
                                <span style={{ fontWeight: 'bold' }}>Nome: </span>
                                {dados.nome}
                            </Typography> : null}
                            {dados.tipo ? <Typography variant="body1" gutterBottom>
                                <span style={{ fontWeight: 'bold' }}>Tipo: </span>
                                {dados.tipo}
                            </Typography> : null}
                            {dados.saldo ? <Typography variant="body1" gutterBottom>
                                <span style={{ fontWeight: 'bold' }}>Saldo: </span>
                                <span style={{ color: '#3f51b5' }}>R$ {dados.saldo}</span>

                            </Typography> : null}
                        </Box>
                    </Box>
                </Paper>
                {cpf ?
                    <Box sx={{ display: 'flex' }}>

                        <Paper elevation={3} sx={{ mt: 2, p: 2, borderRadius: '1rem' }}>
                            <Typography sx={{ mb: 2 }} variant="h5" gutterBottom>
                                Almoçar
                            </Typography>
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
                            <br />
                            <Button sx={{ mt: 2, width: '100%' }} disabled={cpf && campus_ru ? false : true} variant="contained">Almoçar</Button>
                        </Paper>
                        {dados.tipo !== 'Bolsista' ?
                            <Paper elevation={3} sx={{ mt: 2, ml: 2, p: 2, borderRadius: '1rem' }}>
                                <Typography sx={{ mb: 2 }} variant="h5" gutterBottom>
                                    Adicionar Credito
                                </Typography>
                                <Grid
                                    container
                                    spacing={2}
                                    direction="column"

                                    alignItems="center">
                                    <Grid item>
                                        <Button onClick={() => handleRecargaButton(5)} sx={{ width: '4.5rem', mr: 2 }} variant="outlined">R$ 5</Button>
                                        <Button onClick={() => handleRecargaButton(10)} sx={{ width: '4.5rem' }} variant="outlined">R$ 10</Button>
                                    </Grid>
                                    <Grid item>
                                        <Button onClick={() => handleRecargaButton(20)} sx={{ width: '4.5rem', mr: 2 }} variant="outlined">R$ 20</Button>
                                        <Button onClick={() => handleRecargaButton(50)} sx={{ width: '4.5rem' }} variant="outlined">R$ 50</Button>
                                    </Grid>
                                </Grid>
                            </Paper> : null}
                    </Box>
                    : null}

            </Box>
            {dados.id_conta ?
                <Box>
                    <Toolbar />
                    <BasicTable movimentacoes={movimentacoes} />
                </Box> : null}

        </Container>
    );
}
