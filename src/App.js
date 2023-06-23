import React from 'react';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Funcionario from './pages/Funcionario';
import Estudante from './pages/Estudante';
import Docente from './pages/Docente';
import './App.css'

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route exact path="/" element={<Funcionario />} />
        <Route exact path="/estudante" element={<Estudante />} />
        <Route exact path="/docente" element={<Docente />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
