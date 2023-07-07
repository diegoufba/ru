import React from 'react';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Simulacao from './pages/Simulacao';
import Funcionario from './pages/Funcionario';
import Bolsista from './pages/Bolsista';
import Docente from './pages/Docente';
import Pagante from './pages/Pagante';
import Movimentacao from './pages/Movimentacao';
import './App.css'

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route exact path="/" element={<Simulacao />} />
        <Route exact path="/movimentacao" element={<Movimentacao />} />
        <Route exact path="/funcionario" element={<Funcionario />} />
        <Route exact path="/bolsista" element={<Bolsista />} />
        <Route exact path="/docente" element={<Docente />} />
        <Route exact path="/pagante" element={<Pagante />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
