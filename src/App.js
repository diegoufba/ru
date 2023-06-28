import React from 'react';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Simulacao from './pages/Simulacao';
import Funcionario from './pages/Funcionario';
import Estudante from './pages/Estudante';
import Docente from './pages/Docente';
import Produto from './pages/Produto';
import './App.css'

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route exact path="/" element={<Simulacao />} />
        <Route exact path="/funcionario" element={<Funcionario />} />
        <Route exact path="/estudante" element={<Estudante />} />
        <Route exact path="/docente" element={<Docente />} />
        <Route exact path="/produto" element={<Produto />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
